<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticlesController extends Controller
{
    public function index(int $page=1) {
        $articles = Article::where("is_published", true)
                           ->orderBy("created_at", "desc")
                           ->paginate(5, ["*"], "page/$page", $page);
        $nav_links = $this->index_links($articles);

        return view("index", [
            "articles" => $articles,
            "nav_links" => $nav_links,
        ]);
    }

    public function show(string $slug, $is_published=true) {
        $article = Article::where("slug", $slug);
        if ($is_published)
            $article = $article->where("is_published", 1);
        $article = $article->firstOrFail();

        $open_graph = (object) [
            "title" => $article->headline,
            "url" => route("articles", $article->slug),
            "description" => $article->description,
        ];
        if ($article->hero_url)
            $open_graph->image = $article->hero_url;

        return view("article", [
            "article" => $article,
            "nav_links" => $this->article_links($article),
            "open_graph" => $open_graph,
        ]);
    }

    public function preview(string $slug) {
        return $this->show($slug, false);
    }

    private function article_links(Article $article) {
        $newer = Article::where("is_published", true)
                        ->where("created_at", ">", $article->created_at)
                        ->first();
        $older = Article::where("is_published", true)
                        ->where("created_at", "<", $article->created_at)
                        ->first();

        return (object) [
            "newer" => $newer->url ?? null,
            "older" => $older->url ?? null,
        ];
    }

    private function index_links(LengthAwarePaginator $articles) {
        $current = $articles->currentPage(); 
        $last = $articles->lastPage(); 
        if ($current < 1)
            $current = 1;
        elseif ($current > $last)
            $current = $last + 1;
        $newer = $current - 1;
        $older = $current + 1;

        return (object) [
            "newer" => $newer >= 1 ? route("page", $newer) : null,
            "older" => $older <= $last ? route("page", $older) : null,
        ];
    }
}

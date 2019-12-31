<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index() {
        $articles = Article::where("is_published", true)->orderBy("created_at", "desc")->paginate(5);
        return view("index", ["articles" => $articles, ]);
    }

    public function show(string $slug, $is_published=true) {
        $article = Article::where("slug", $slug);
        if ($is_published)
            $article = $article->where("is_published", 1);
        $article = $article->firstOrFail();
        return view("article", [
            "article" => $article,
            "open_graph" => (object) [
                "title" => $article->headline,
                "url" => url(route('blog') . "/$article->slug"),
                "image" => $article->thumbnail_url,
                "description" => $article->description,
            ],
        ]);
    }

    public function preview(string $slug) {
        return $this->show($slug, false);
    }
}

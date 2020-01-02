<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TagsController extends Controller
{
    public function index(string $name, int $page=1) {
        $tag = Tag::where("name", $name)->firstOrFail();
        // $articles = Article::where("is_published", true)
        //                    ->orderBy("created_at", "desc")
        //                    ->paginate(5, ["*"], "page/$page", $page);
        $articles = $tag->articles()->paginate();
        $nav_links = $this->nav_links($articles);

        return view("index", [
            "articles" => $articles,
            "nav_links" => $nav_links,
            "tag_name" => $tag->name,
        ]);
    }

    private function nav_links(LengthAwarePaginator $articles) {
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

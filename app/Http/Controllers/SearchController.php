<?php

namespace App\Http\Controllers;

use App\Article;
use App\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request) {
        $query = $request->input("query");
        $headlines = $this->search_headlines($query);
        $tags = $this->search_tags($query);
        $articles = $tags->merge($headlines)->slice(0, 5);
        return $articles;
    }

    private function search_headlines(string $query) {
        return Article::where("is_published", true)
            ->where("headline", "like", "%$query%")
            ->orderBy("created_at", "desc")
            ->limit(5)
            ->get();
    }

    private function search_tags(string $query) {
        $tag = Tag::where("name", $query)->first();
        if ($tag)
            return $tag->articles->where("is_published", true);
        return collect([]);
    }
}

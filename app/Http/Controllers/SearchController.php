<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request) {
        $query = $request->input("query");
        $articles = Article::where("headline", "like", "%$query%")
                           ->orderBy("created_at", "desc")
                           ->limit(5)
                           ->get();
        return $articles;
    }
}

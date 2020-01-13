<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class GoController extends Controller
{
    public function show(string $short_url_id) {
        $article = Article::find_short_url($short_url_id);
        if ($article)
            return redirect()->route("articles", $article->slug);
        return redirect()->route("index");
    }
}

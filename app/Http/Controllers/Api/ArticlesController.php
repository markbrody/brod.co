<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index(Request $request) {
        $articles = Article::where("is_published", true)->orderBy("created_at", "desc");
        return $articles->paginate(10);
    }

    public function store(Request $request) {
        $valid = $request->validate([
            "headline" => "bail|required",
            "subheading" => "nullable",
            "markdown" => "bail|required",
        ]);
        $article = Article::create([
            "headline" => $valid['headline'],
            "subheading" => $valid['subheading'],
            "markdown" => $valid['markdown'],
            "user_id" => Auth::id(),
        ]);
        return $this->show($article->id);
    }

    public function show(string $id) {
        return Article::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $valid = $request->validate([
            "headline" => "min:1",
            "subheading" => "nullable",
            "markdown" => "min:1",
            "is_published" => "boolean",
        ]);
        $article = Article::findOrFail($id);
        $article->headline = array_key_exists("headline", $valid) ? $valid['headline'] : $article->headline;
        $article->subheading = array_key_exists("subheading", $valid) ? $valid['subheading'] : $article->subheading;
        $article->markdown = array_key_exists("markdown", $valid) ? $valid['markdown'] : $article->markdown;
        $article->is_published = array_key_exists("is_published", $valid) ? $valid['is_published'] : $article->is_published;
        $article->save();

        return $this->show($article->id);
    }

    public function destroy(string $id) {
        //
    }
}

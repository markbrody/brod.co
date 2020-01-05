<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        return view("admin.index", ["articles" => Article::orderBy("created_at", "desc")->get()]);
    }

    public function show(string $id) {
        return view("admin.show", ["article" => Article::findOrFail($id)]);
    }

    public function update(Request $request, string $id) {
        $article = Article::findOrFail($id);
        $valid = $request->validate([
            "headline" => "bail|required",
            "subheading" => "nullable",
            "markdown" => "bail|required",
        ]);
        $article->headline = $valid['headline'];
        $article->subheading = $valid['subheading'];
        $article->markdown = $valid['markdown'];
        $article->save();
        return $this->show($article->id);
    }

    public function assets() {
        return view("admin.assets", ["articles" => Article::orderBy("headline", "asc")->get()]);
    }
}

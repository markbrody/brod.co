<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleTagsController extends Controller
{
    public function index(string $article_id) {
        $article = Article::findOrFail($article_id);
        return $article->tags;
    }

    public function store(Request $request, string $article_id) {
        $tag = Tag::findOrFail($request->input("id"));
        $article = Article::findOrFail($article_id);
        $article->tags()->attach($tag);
        return $article->tags;
    }

    public function destroy(string $article_id, int $tag_id) {
        $tag = Tag::findOrFail($tag_id);
        $article = Article::findOrFail($article_id);
        $article->tags()->detach($tag);
        return $article->tags;
    }
}

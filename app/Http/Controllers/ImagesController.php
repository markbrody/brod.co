<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    private $article;

    // private $mime_type;

    public function hero(string $slug, string $extension) {
        $this->set_article($slug);
        if ($this->article->hero_path)
            return response(file_get_contents($this->article->hero_path))
                ->withHeaders(["Content-Type" => "image/$extension"]);
        return;
    }

    public function thumbnail(string $slug, string $extension) {
        $this->set_article($slug);
        if ($this->article->thumbnail_path)
            return response(file_get_contents($this->article->thumbnail_path))
                ->withHeaders(["Content-Type" => "image/$extension"]);
        return;
    }

    public function set_article(string $slug): void {
        $this->article = Article::where("slug", $slug)->firstOrFail();
    }
}

<?php

namespace App\Http\Controllers;

use App\Article;
use App\Images\Asset;
use Illuminate\Http\Request;
use Storage;

class ImagesController extends Controller
{
    private $article;

    public function asset(string $article_id, string $filename) {
        $asset = Asset::IMAGE_DIRECTORY . "$article_id/$filename";
        if (Storage::exists($asset))
            return response(Storage::get($asset))
                ->withHeaders(["Content-Type" => Storage::mimetype($asset)]);
        abort(404);
    }

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

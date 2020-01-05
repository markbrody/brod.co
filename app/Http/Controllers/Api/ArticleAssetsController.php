<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Images\Asset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class ArticleAssetsController extends Controller
{
    public function index(string $id) {
        $article = Article::findOrFail($id);
        $image_directory = Asset::IMAGE_DIRECTORY . "$id/";
        if (Storage::exists($image_directory))
            dd(Storage::files($image_directory));
        return [];
    }

}

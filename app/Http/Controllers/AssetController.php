<?php

namespace App\Http\Controllers;

use App\Images\Asset;
use App\Article;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function update(Request $request, string $id) {
        $article = Article::findOrFail($id);
        $image = new Asset($article->id, $request->file("image"));
        if (!preg_match("/^image\/(jpeg|png)$/", $image->mime_type))
            return response()->json(["error" => "Unsupported file type"]);
        $image->save();
        return response()->json($article);
    }

}

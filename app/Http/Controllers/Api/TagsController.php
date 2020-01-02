<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index(Request $request) {
        $search = $request->input("search");
        if ($search)
            $tags = Tag::where("name", "like", "$search%")->get();
        else
            $tags = Tag::all();
        return $tags;
    }

    public function store(Request $request) {
        $valid = $request->validate([
            "name" => "bail|required",
        ]);
        return Tag::create(["name" => $valid['name']]);
    }

    public function destroy(int $id) {
        return json_encode(["success" => Tag::destroy($id)]);
    }
}

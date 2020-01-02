<?php

use Illuminate\Http\Request;

Route::group(["middleware" => "auth:api"], function() {
    Route::resource("articles", "Api\ArticlesController");
    Route::get("articles/{article_id}/tags", "Api\ArticleTagsController@index");
    Route::post("articles/{article_id}/tags", "Api\ArticleTagsController@store");
    Route::delete("articles/{article_id}/tags/{tag_id}", "Api\ArticleTagsController@destroy");
    Route::resource("tags", "Api\TagsController");
});

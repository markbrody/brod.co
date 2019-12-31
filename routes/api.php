<?php

use Illuminate\Http\Request;

Route::group(["middleware" => "auth:api"], function() {
    Route::resource("articles", "Api\ArticlesController");
});

<?php

/**
  * Routes that require login
  */
Route::group(["middleware" => ["auth", ]], function() {
    Route::get("admin", "AdminController@index")->name("admin");
    Route::get("admin/assets", "AdminController@assets")->name("assets");
    Route::get("admin/{id}", "AdminController@show")->name("edit");
    Route::post("admin/{id}", "AdminController@update");
    Route::get("preview/{slug}", "ArticlesController@preview");

    Route::group(["prefix" => "ajax"], function() {
        Route::put("assets/{id}", "AssetController@update");
        Route::put("hero/{id}", "HeroController@update");
        Route::get("tweet/{id}", "TweetController@show");
    });
});

/**
  * Guest routes
  */
Route::get("/", "ArticlesController@index")->name("index");
Route::get("articles", "ArticlesController@index");
Route::get("articles/{slug}", "ArticlesController@show")->name("articles");
Route::get("calendar/{year?}/{month?}", "CalendarController@index")->name("calendar");
Route::get("go/{short_url_id}", "GoController@show")->name("go");
Route::get("page/{page}", "ArticlesController@index")->name("page");
Route::get("robots.txt", "RobotsController@index");
Route::get("sitemap.xml", "SitemapController@index");
Route::get("tags/{name}", "TagsController@index")->name("tags");

Route::group(["prefix" => "ajax"], function() {
    Route::get("cookies", "CookiesController@index");
    Route::get("search", "SearchController@index");
});

/**
 * Dynamically built images
 */
Route::group(["prefix" => "images"], function() {
    Route::get("assets/{article_id}/{filename}", "ImagesController@asset");
    Route::get("heroes/{slug}.{extension}", "ImagesController@hero");
    Route::get("thumbnails/{slug}.{extension}", "ImagesController@thumbnail");
});

/**
 * Auth routes
 */
Route::get("login", "Auth\LoginController@showLoginForm")->name("login");
Route::post("login", "Auth\LoginController@login");
Route::get("logout", "Auth\LoginController@logout")->name("logout");

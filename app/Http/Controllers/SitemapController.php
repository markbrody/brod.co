<?php

namespace App\Http\Controllers;

use App\Article;
use App\Images\Hero;
use App\Tag;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Storage;

class SitemapController extends Controller
{
    private $routes;

    private $excludes;

    public function __construct() {
        $this->routes = collect(app()->routes->getRoutes());
        $this->excludes = [
            "ajax",
            "calendar",
            "images\/heroes",
            "images\/thumbnails",
            "login",
            "logout",
            "_ignition",
            "robots\.txt",
            "sitemap\.xml",
        ];
    }

    public function index() {
        $urls = [];
        $this->eligible_routes()->each(function($route) use (&$urls) {
            if (preg_match("/(\w+).*\/\{[\w{}.]+\}$/", $route->uri, $match)) {
                $method = "get_$match[1]";
                foreach ($this->{$method}() as $page) {
                    $urls[] = (object) [
                        "loc" => $page->url,
                        "lastmod" => $page->updated_at->format("Y-m-d\TH:i:sP"),
                        "changefreq" => $page->changefreq,
                        "priority" => 0.8,
                    ];
                }
            }
            else
                $urls[] = (object) [
                    "loc" => url($route->uri),
                    "lastmod" => $this->get_lastmod($route->uri),
                    "changefreq" => "weekly",
                    "priority" => 0.5,
                ];
        });
        return response(view("sitemap", [
            "urls" => $urls,
        ]))->header("Content-Type", "application/xml");
    }

    private function eligible_routes() {
        $exclude = "/^(?!(" . implode("|", $this->excludes) . ").*$).*/";
        return $this->routes->filter(function($route) use ($exclude) {
            return in_array("GET", $route->methods) &&
                preg_match("/^((?!auth).)*$/", implode(",", $route->action['middleware'])) &&
                preg_match("/^((?!{token\??}).)*$/", $route->uri) &&
                preg_match($exclude, $route->uri);
        });
    }

    private function get_articles() {
        foreach (Article::where("is_published", 1)->get() as $article)
            yield (object) [
                "url" => $article->url,
                "updated_at" => $article->updated_at,
                "changefreq" => "weekly",
            ];
    }

    private function get_go() {
        foreach (Article::where("is_published", 1)->get() as $article)
            yield (object) [
                "url" => $article->short_url,
                "updated_at" => $article->updated_at,
                "changefreq" => "weekly",
            ];
    }

    /**
     * This involves looking up corresponding articles and inefficient
     */
    // private function get_images() {
    //     foreach (Storage::files(Hero::IMAGE_DIRECTORY) as $image) {
    //         $updated_at = Storage::lastModified($image);
    //         yield (object) [
    //             "url" => asset($image),
    //             "updated_at" => Carbon::createFromTimestamp($updated_at),
    //             "changefreq" => "monthly",
    //         ];
    //     }
    // }
    private function get_images() {
        return [];
    }

    private function get_page() {
        $articles = Article::select("id", "updated_at")
                           ->where("is_published", true)
                           ->orderBy("updated_at", "desc")
                           ->get();

        for ($i=1; $i<=ceil($articles->count() / 5); $i++)
            yield (object) [
                "url" => route("page", $i),
                "updated_at" => $articles[0]->updated_at,
                "changefreq" => "daily",
            ];
    }

    private function get_tags() {
        $tags = Tag::all();
        foreach ($tags as $tag)
            yield (object) [
                "url" => route("tags", $tag->name),
                "updated_at" => $tag->updated_at,
                "changefreq" => "daily",
            ];
    }

    private function get_lastmod($uri) {
        if ($uri == "/")
            $uri = "index";
        elseif ($uri == "articles")
            $uri = "articles_index";
        $blade = str_replace("-", "_", $uri);
        $filename = resource_path("views/$blade.blade.php");
        if (file_exists($filename))
            $mtime = Carbon::createFromTimestamp(filemtime($filename));
        else
            $mtime = (new Carbon("first day of this month"))->startOfDay();
        return $mtime->format("Y-m-d\TH:i:sP");
    }

}

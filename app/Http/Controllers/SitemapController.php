<?php

namespace App\Http\Controllers;

use App\Article;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    private $routes;

    private $excludes;

    public function __construct() {
        $this->routes = collect(app()->routes->getRoutes());
        $this->excludes = [
            // "ajax",
            // "biscolab",
            // "images",
            // "logout",
            // "robots\.txt",
            // "sitemap\.xml",
        ];
    }

    public function index() {
        $urls = [];
        $this->eligible_routes()->each(function($route) use (&$urls) {
            if (preg_match("/(\w+)\/\{\w+\}$/", $route->uri, $match)) {
                $method = "get_$match[1]";
                foreach ($this->{$method}() as $page) {
                    $urls[] = (object) [
                        "loc" => url(preg_replace("/\{\w+\}$/", $page->id, $route->uri)),
                        "lastmod" => $page->updated_at->format(DateTime::ISO8601),
                        "priority" => 0.8,
                    ];
                }
            }
            else
                $urls[] = (object) [
                    "loc" => url($route->uri),
                    "lastmod" => $this->get_lastmod($route->uri),
                    "priority" => 1,
                ];
        });
        return response(view("sitemap", [
            "urls" => $urls,
        ]))->header("Content-Type", "text/plain");
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

    private function get_blog() {
        foreach (Article::where("is_published", 1)->get() as $article)
            yield (object) [
                "id" => $article->slug,
                "updated_at" => $article->updated_at,
            ];
    }

    private function get_lastmod($uri) {
        if ($uri == "/")
            $uri = "index";
        elseif ($uri == "blog")
            $uri = "articles_index";
        $blade = str_replace("-", "_", $uri);
        $filename = resource_path("views/$blade.blade.php");
        if (file_exists($filename))
            $mtime = Carbon::createFromTimestamp(filemtime($filename));
        else
            $mtime = (new Carbon("first day of this month"))->startOfDay();
        return $mtime->format(DateTime::ISO8601);
    }

}

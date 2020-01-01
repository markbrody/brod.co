<?php

namespace App;

use App;
use App\Article;

class Disqus
{
    public $article;

    public function __construct(Article $article) {
        $this->article = $article;
    }

    public function comments() {
        if (App::environment() != "local")
            return view("disqus", ["article" => $this->article, ]);
        return;
    }

    public static function counter() {
        return '<script id="dsq-count-scr" src="//brod-co.disqus.com/count.js"'
             . ' async></script>';
    }

}


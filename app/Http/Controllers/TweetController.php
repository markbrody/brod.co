<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Twitter;

class TweetController extends Controller
{
    private $article;

    public function show(string $article_id) {
        $this->article = Article::findOrFail($article_id);
        $tweet = Twitter::postTweet([
            "status" => $this->status(),
            "format" => "json",
        ]);
        if ($tweet) {
            $this->article->is_shared = true;
            $this->article->save();
            return $tweet;
        }
        return;
    }

    private function status() {
        $status = [
            $this->article->headline,
            $this->hashtags(),
            "", // spacer
            $this->article->short_url,
        ];
        return implode("\n", $status);
    }

    private function hashtags() {
        $tags = [];
        foreach ($this->article->tags as $tag)
            $tags[] = "#" . preg_replace("/[\W]/", "-", strtolower($tag->name));
        return implode(" ", $tags);
    }
}

<?php

namespace App;

use App\Traits\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ArticleTag extends Pivot
{
    use WithoutTimestamps;

    protected $fillable = ["article_id", "tag_id"];

    protected $table = "article_tag";

    public function article() {
        return $this->belongsTo("App\Article");
    }

    public function tag() {
        return $this->belongsTo("App\Tag");
    }

}

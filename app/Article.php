<?php

namespace App;

use App\Images\Hero;
use App\Markdown;
use App\Traits\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\HtmlString;

use Carbon\Carbon;
use Storage;
use Str;

class Article extends Model
{
    use SoftDeletes, Uuid;

    protected $appends = ["created", "hero_url", "thumbnail_url", "url", ];

    protected $fillable = ["headline", "subheading", "markdown", "user_id"];

    protected $hidden = ["user_id", "created_at", "updated_at", "deleted_at",
                         "pivot", ];

    protected $with = ["user"];

    public static function boot() {
        parent::boot();
        self::saving(function($article) {
            $article->slug = Str::slug($article->headline, "-");
        });
    }

    public function tags() {
        return $this->belongsToMany("App\Tag");
    }

    public function user() {
        return $this->belongsTo("App\User");
    }

    public function getCreatedAttribute() {
        return Carbon::createFromTimeStamp(strtotime($this->created_at))->toFormattedDateString();
    }

    public function getHtmlAttribute() {
        return new HtmlString((new Markdown)->html($this->markdown));
    }

    public function getDescriptionAttribute() {
        $markdown = strstr(str_replace("\r", "", $this->markdown), "\n", true);
        $markdown = preg_replace("/^[\W]+/m", "", $this->markdown);
        return preg_replace("/\s[^\s]+$/", "", substr($markdown, 0, 512)) . "…";
    }

    public function getReadTimeAttribute() {
        return ceil(str_word_count($this->markdown) / 180);
    }

    public function getUrlAttribute() {
        return route("articles", $this->slug);
    }

    private function get_hero_extension() {
        if (Storage::exists(Hero::IMAGE_DIRECTORY . $this->id)) {
            $filename = Storage::path(Hero::IMAGE_DIRECTORY . $this->id);
            preg_match("/^image\/(\w+)$/", mime_content_type($filename), $match);
            return $match[1];
        }
        return null;
    }

    public function getHeroPathAttribute() {
        if (Storage::exists(Hero::IMAGE_DIRECTORY . $this->id))
            return Storage::path(Hero::IMAGE_DIRECTORY . $this->id);
        return null;
    }

    public function getHeroUrlAttribute() {
        if (Storage::exists(Hero::IMAGE_DIRECTORY . $this->id))
            return url(Hero::IMAGE_DIRECTORY . $this->slug . "."
                . $this->get_hero_extension());
        return null;
    }

    private function get_thumbnail_extension() {
        if (Storage::exists(Hero::THUMBNAIL_DIRECTORY . "/$this->id")) {
            $filename = Storage::path(Hero::THUMBNAIL_DIRECTORY . $this->id);
            preg_match("/^image\/(\w+)$/", mime_content_type($filename), $match);
            return $match[1];
        }
        return null;
    }

    public function getThumbnailPathAttribute() {
        if (Storage::exists(Hero::THUMBNAIL_DIRECTORY . $this->id))
            return Storage::path(Hero::THUMBNAIL_DIRECTORY . $this->id);
        return null;
    }

    public function getThumbnailUrlAttribute() {
        if (Storage::exists(Hero::THUMBNAIL_DIRECTORY . $this->id))
            return url(Hero::THUMBNAIL_DIRECTORY . $this->slug . "."
                . $this->get_thumbnail_extension());
        return asset("images/placeholder_250x130.jpg");
    }

}

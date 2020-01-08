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
        $markdown = preg_replace("/^#.+$/m", "", $this->markdown);
        $markdown = preg_replace("/( _)([^_]+)(_ )/", " $2 ", $markdown);
        $markdown = preg_replace("/^[\W]+/m", "", $markdown);
        return preg_replace("/\s[^\s]+$/", "", substr($markdown, 0, 512)) . "…";
    }

    public function getReadTimeAttribute() {
        return ceil(str_word_count($this->markdown) / 180);
    }

    public function getMoreAttribute() {
        $related = [];
        foreach ($this->tags as $tag) {
            $tag->articles->each(function($article) use (&$related) {
                if ($article->is_published) {
                    if (array_key_exists($article->id, $related))
                        $related[$article->id]++;
                    else
                        $related[$article->id] = 1;
                }
            });
        }
        arsort($related);

        // $recent = static::select(["id"])
        //       ->where("is_published", true)
        //       ->whereNotIn("id", array_keys($related))
        //       ->orderBy("created_at", "desc")
        //       ->limit(4)
        //       ->get()
        //       ->toArray();
        // $more = $related + array_flip($recent);

        foreach (collect($related)->slice(0, 3) as $article_id => $count)
            if ($article_id !== $this->id)
                yield static::find($article_id);
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

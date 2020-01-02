<?php

namespace App\Images;

use Illuminate\Http\UploadedFile;
use Storage;

class Hero extends Image
{

    const IMAGE_DIRECTORY = "images/heroes/";

    const IMAGE_WIDTH = 1200;

    const IMAGE_HEIGHT = 400;

    const THUMBNAIL_DIRECTORY = "images/thumbnails/";

    const THUMBNAIL_WIDTH = 260;

    const THUMBNAIL_HEIGHT = 65;

    private $id;

    public function __construct(string $id, UploadedFile $upload) {
        parent::__construct($upload);
        if (!Storage::exists(self::IMAGE_DIRECTORY))
            Storage::makeDirectory(self::IMAGE_DIRECTORY);
        if (!Storage::exists(self::THUMBNAIL_DIRECTORY))
            Storage::makeDirectory(self::THUMBNAIL_DIRECTORY);
        $this->id = $id;
    }

    public function save() {
        $this->_save(
            Storage::path(self::IMAGE_DIRECTORY) . $this->id,
            self::IMAGE_WIDTH,
            self::IMAGE_HEIGHT
        );
        $this->_save(
            Storage::path(self::THUMBNAIL_DIRECTORY) . $this->id,
            self::THUMBNAIL_WIDTH,
            self::THUMBNAIL_HEIGHT
        );
        imagedestroy($this->resource);
    }

}

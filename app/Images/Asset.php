<?php

namespace App\Images;

use Illuminate\Http\UploadedFile;
use Storage;

class Asset extends Image
{
    const IMAGE_DIRECTORY = "images/assets/";

    private $id;

    private $filename;

    public function __construct(string $id, UploadedFile $upload) {
        parent::__construct($upload);
        $this->id = $id;
        $this->filename = $upload->getClientOriginalName();
    }

    public function save() {
        $image_directory = self::IMAGE_DIRECTORY . "$this->id";
        if (!Storage::exists($image_directory))
            Storage::makeDirectory($image_directory);
        $this->_save(
            Storage::path(self::IMAGE_DIRECTORY) . "$this->id/$this->filename",
            $this->original_width,
            $this->original_height
        );
        imagedestroy($this->resource);
    }

}

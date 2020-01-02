<?php

namespace App;

use Parsedown;

class Markdown extends Parsedown
{
    public function __construct() {
        // parent::__construct();
    }

    public function html($markdown) {
        $filenames = [];
        preg_match_all("/^file(name)?=([\w\/.-]+)/m", $markdown, $file_match);
        if ($file_match) {
            foreach($file_match[0] as $i => $filename) {
                $markdown = str_replace($filename, "FILENAME_$i", $markdown);
                $filenames[$i] = $file_match[2][$i];
            }
        }
        $html = $this->setSafeMode(true)->text($markdown);
        foreach ($filenames as $i => $filename) {
            $title = " class='filename'>File: $filename";
            $html = str_replace(">FILENAME_$i", $title, $html);
        }
        return $html;
    }

}


<?php

namespace App;

use Parsedown;

class Markdown extends Parsedown
{
    public function __construct() {
        // parent::__construct();
    }

    public function html($markdown) {
        // html
        $html_blocks = [];
        preg_match_all("/(?<=<html>)(.*\n)*(?=<\/html>)/iU", $markdown, $html_match);
        if ($html_match) {
            foreach($html_match[0] as $i => $html_markup) {
                $markdown = str_replace($html_markup, "HTML_$i", $markdown);
                $html_blocks[$i] = $html_match[0][$i];
            }
        }

        // files
        $filenames = [];
        preg_match_all("/^file(name)?=([\w\/.*~-]+)/m", $markdown, $file_match);
        if ($file_match) {
            foreach($file_match[0] as $i => $filename) {
                $markdown = str_replace($filename, "FILENAME_$i", $markdown);
                $filenames[$i] = $file_match[2][$i];
            }
        }

        $html = $this->setSafeMode(true)->text($markdown);

        foreach ($html_blocks as $i => $html_markup) {
            $rendered ="<p>&lt;html&gt;HTML_$i&lt;/html&gt;</p>"; 
            $html = str_replace($rendered, $html_markup, $html);
        }

        foreach ($filenames as $i => $filename) {
            $title = " class='filename'>File: $filename<";
            $html = str_replace(">FILENAME_$i<", $title, $html);
        }

        return $html;
    }

}


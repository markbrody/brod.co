<?php

namespace App;

use App\AmazonAds;
use Parsedown;
use SimpleXMLElement;

class Markdown extends Parsedown
{
    public function __construct() {
        // parent::__construct();
    }

    public function html($markdown) {
        $amazon_ads = [];
        $pattern = "/<amazon\s*(.+)?>/i";
        preg_match_all($pattern, $markdown, $match);
        if ($match) {
            foreach ($match[0] as $index => $tag) {
                $markdown = str_replace($tag, "AMAZONADS_PLACEHOLDER_$index", $markdown);
                $xml_element = new SimpleXMLElement(preg_replace("/([^\/])>$/", "$1/>", $tag));
                $amazon_ads[$index] = $this->generate_amazon_ads($xml_element);
            }
        }
        $html = $this->setSafeMode(true)->text($markdown);
        foreach ($amazon_ads as $index => $ad)
            $html = str_replace("<p>AMAZONADS_PLACEHOLDER_$index</p>", $ad, $html);
        $html = str_replace("<a href", "<a target=\"_blank\" href", $html);

        return $html;
    }

    private function generate_amazon_ads(SimpleXMLElement $xml_element) {
        $vars = [];
        foreach ($xml_element->attributes() as $key => $value)
            $vars[$key] = $value;
        $amazon_ads = new AmazonAds($vars);
        // $display_class = $display_mobile ? "" : " d-none d-md-block";
        $display_class = "";
        return '<div class="rol"><div class="col-12' . $display_class . '">'
            . $amazon_ads->smart()->render()
            . '</div></div>';
    }

}


<?php

if (!function_exists('meta_tag_structure')) {
    function metaTagStructure($text): array|string
    {
        $text = trim($text);
        $text = str_replace(['،'], ',', $text);
        return str_replace([',,', '،،'], ',', $text);
    }
}

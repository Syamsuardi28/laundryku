<?php

namespace App\Helpers;

class HighlightHelper
{
    public static function highlight($text, $search)
    {
        if (!$search) {
            return e($text);
        }

        $escapedSearch = preg_quote($search, '/');
        return preg_replace(
            '/(' . $escapedSearch . ')/i',
            '<mark class="bg-primary/20 text-primary px-0.5 rounded font-bold">$1</mark>',
            e($text)
        );
    }
}

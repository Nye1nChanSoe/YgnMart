<?php

namespace App\Traits;

trait parseTrait
{
    /**
     * Parse the hyphens into whitespaces characters
     * 
     * @param array $arr Array of strings with hyphen separated values
     * 
     * @return array
     */
    public function parseHyphens($arr)
    {
        return array_map(fn($str) => str_replace('-', ' ', $str), $arr);
    }
}
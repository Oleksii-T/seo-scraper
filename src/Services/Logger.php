<?php

namespace App\Services;

class Logger
{
    public static function info($text)
    {
        if (!is_string($text)) {
            $text = json_encode($text);
        }

        echo ($text);
        echo ("\r\n");
    }
}
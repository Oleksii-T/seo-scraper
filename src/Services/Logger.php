<?php

namespace App\Services;

class Logger
{
    public static function console($text)
    {
        $text = self::formatData($text);

        echo ($text);
        echo ("\r\n");
    }

    public static function info($text)
    {
        self::writeToFile($text);
    }

    public static function error($text)
    {
        self::writeToFile($text, 'ERROR');
    }

    private static function formatData($text): string
    {
        if (!is_string($text)) {
            return json_encode($text);
        }

        return $text;
    }

    private static function writeToFile($text, $level='INFO')
    {
        $logsDir = __DIR__ . '/../../logs';

        if (!is_dir($logsDir)) {
            mkdir($logsDir, 0755, true);
        }

        $date = date('Y-m-d');
        $fileName = $logsDir . '/' . $date . '.log';
        $time = date('H:i:s');
        $text = '[' . $date . ' ' . $time . '] ' . $level . ' ' . $text . "\r\n";
        file_put_contents($fileName, $text, FILE_APPEND);
    }
}
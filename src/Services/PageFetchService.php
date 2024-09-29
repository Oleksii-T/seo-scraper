<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Services\Cache;
use App\Services\Logger;

class PageFetchService
{
    public static function get($uri, $usingBrowser=false)
    {
        // init cache
        $cache = new Cache();
        
        // get the cached html
        $cacheHtml = $cache->get($uri);
        
        // return html from the cache if it is exists
        if ($cacheHtml) {
            return $cacheHtml;
        }

        if ($usingBrowser) {
            $html = self::browserGet($uri);
        } else {
            $html = self::simpleGet($uri);
        }

        $cache->put($uri, $html);

        return $html;
    }

    private static function simpleGet($uri)
    {
        // Make a GET request to the provided URL
        $client = new Client();
        $response = $client->request('GET', $uri);
        
        // Get the body content of the response
        return $response->getBody()->getContents();
    }

    private static function browserGet($uri)
    {
        $command = escapeshellcmd("node fetchContent.js " . escapeshellarg($uri));
        $output = shell_exec($command);

        return $output; // This is the fully rendered HTML
    }
}

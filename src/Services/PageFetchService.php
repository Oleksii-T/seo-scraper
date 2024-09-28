<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Services\CacheService;

class PageFetchService
{
    public static function get($uri)
    {
        // init cache
        $cache = new CacheService();
        
        // get the cached html
        $cacheHtml = $cache->get($uri);
        
        // return html from the cache if it is exists
        if ($cacheHtml) {
            return $cacheHtml;
        }

        // Make a GET request to the provided URL
        $client = new Client();
        $response = $client->request('GET', $uri);
        
        // Get the body content of the response
        $html = $response->getBody()->getContents();

        // cache the html
        $cache->put($uri, $html);

        return $html;
    }
}

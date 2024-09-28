<?php

namespace App;

use Symfony\Component\DomCrawler\Crawler;
use App\Services\PageFetchService;

class Scraper
{
    private Crawler $crawler;
    private string $baseHtml;

    public function __construct($uri)
    {
        $this->baseHtml = PageFetchService::get($uri);
        $this->crawler = new Crawler($this->baseHtml);
    }

    public function run($url)
    {
        //todo
    }
}

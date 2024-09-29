<?php

namespace App;

use App\Scraper;

class Handler
{
    public function __construct()
    {
        (new ScraperRcasocal())->run();
        // (new ScraperTask1())->run();
    }
}

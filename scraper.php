<?php

require 'vendor/autoload.php';

use App\Scraper;

// Define the URL to scrape
$url = 'https://rcasocal.wildapricot.org/page-7745';

// Create a new Scraper instance
$scraper = new Scraper($url);

// Fetch the page content
$scraper->run();

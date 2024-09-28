<?php

require 'vendor/autoload.php';

use App\Scraper;

// Create a new Scraper instance
$scraper = new Scraper();

// Define the URL to scrape
$url = 'https://example.com';

// Fetch the page content
$scraper->fetchPage($url);

// Get the page title
$title = $scraper->getTitle();
echo "Page Title: " . $title . PHP_EOL;

// Get all links from the page
$links = $scraper->getLinks();
echo "Links: " . PHP_EOL;
foreach ($links as $link) {
    echo $link . PHP_EOL;
}

// Get content of a specific selector (e.g., paragraph tags)
$paragraphs = $scraper->getContent('p');
echo "Paragraphs: " . PHP_EOL;
foreach ($paragraphs as $paragraph) {
    echo $paragraph . PHP_EOL;
}

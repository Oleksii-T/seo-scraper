<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

// Create a new HTTP client
$client = new Client();

// Define the URL you want to scrape
$url = 'https://example.com';

// Make a GET request to fetch the page content
$response = $client->request('GET', $url);
$html = $response->getBody()->getContents();

// Create a new Crawler instance and pass the HTML content
$crawler = new Crawler($html);

// Example: Extract all the links from the page
$links = $crawler->filter('a')->each(function (Crawler $node) {
    return $node->attr('href');
});

// Print out all the extracted links
foreach ($links as $link) {
    echo $link . PHP_EOL;
}

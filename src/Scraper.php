<?php

namespace App;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Scraper
{
    private $client;
    private $crawler;

    public function __construct()
    {
        // Initialize the HTTP client
        $this->client = new Client();
    }

    public function fetchPage($url)
    {
        try {
            // Make a GET request to the provided URL
            $response = $this->client->request('GET', $url);
            
            // Get the body content of the response
            $html = $response->getBody()->getContents();
            
            // Initialize the crawler with the HTML content
            $this->crawler = new Crawler($html);
            
        } catch (\Exception $e) {
            // Handle exceptions such as network errors or invalid URLs
            echo 'Error fetching the page: ' . $e->getMessage();
        }
    }

    public function getLinks()
    {
        // Ensure that the crawler is initialized
        if (!$this->crawler) {
            return [];
        }

        // Extract all links from the page
        $links = $this->crawler->filter('a')->each(function (Crawler $node) {
            return $node->attr('href');
        });

        return $links;
    }

    public function getTitle()
    {
        // Ensure that the crawler is initialized
        if (!$this->crawler) {
            return null;
        }

        // Get the title of the page
        return $this->crawler->filter('title')->text();
    }

    public function getContent($selector)
    {
        // Ensure that the crawler is initialized
        if (!$this->crawler) {
            return null;
        }

        // Get the content of a specific HTML element
        return $this->crawler->filter($selector)->each(function (Crawler $node) {
            return $node->text();
        });
    }
}

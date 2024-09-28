<?php

namespace App;

use Symfony\Component\DomCrawler\Crawler;
use App\Services\PageFetchService;
use App\Services\CSVGenerator;

class Scraper
{
    private Crawler $crawler;
    private string $baseHtml;

    public function __construct($uri)
    {
        $this->baseHtml = PageFetchService::get($uri);
        $this->crawler = new Crawler($this->baseHtml);
    }

    public function run()
    {
        $cssSelectorOfTableRow = '#membersTable tbody tr';

        $nodes = $this->crawler->filter($cssSelectorOfTableRow);

        $allData = [];

        foreach ($nodes as $node) {
            $tableRowCrawler = new Crawler($node);
            $tableCells = $tableRowCrawler->filter('td');
            $tableCellData = [];

            foreach ($tableCells as $cell) {
                $tableCellData[] = $cell->nodeValue;
            }

            // $this->log($tableCellData);

            $allData[] = $tableCellData;
        }

        $headers = [
            'Name',
            'Organization',
            'Membership',
        ];

        // $this->log($allData);

        $csvGenerator = new CSVGenerator;
        $csvGenerator->generate($allData, $headers, 'members.csv');
    }

    public function log($text)
    {
        if (!is_string($text)) {
            $text = json_encode($text);
        }

        echo ($text);
        echo ("\r\n");
    }
}

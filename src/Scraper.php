<?php

namespace App;

use Symfony\Component\DomCrawler\Crawler;
use App\Services\PageFetchService;
use App\Services\CSVGenerator;
use App\Services\Logger;

class Scraper
{
    private Crawler $crawler;
    private string $baseHtml;

    public function __construct($uri)
    {
        $this->baseHtml = PageFetchService::get($uri, true);
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

            // Logger::info($tableCellData);

            $allData[] = $tableCellData;
        }

        $headers = [
            'Name',
            'Organization',
            'Membership',
        ];

        // Logger::info($allData);

        $csvGenerator = new CSVGenerator;
        $csvGenerator->generate($allData, $headers, 'members.csv');
    }
}

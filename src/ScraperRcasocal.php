<?php

namespace App;

use Symfony\Component\DomCrawler\Crawler;
use App\Services\PageFetchService;
use App\Services\CSVGenerator;
use App\Services\Logger;

class ScraperRcasocal
{
    public function run()
    {
        Logger::info('Start ScraperRcasocal...');
        $baseUrl = 'https://rcasocal.wildapricot.org/page-7745';
        $baseHtml = PageFetchService::get($baseUrl, true);
        $crawler = new Crawler($baseHtml);

        Logger::info(' Crawler inited');

        $cssSelectorOfTableRow = '#membersTable tbody tr';
        $nodes = $crawler->filter($cssSelectorOfTableRow);
        $allData = [];

        foreach ($nodes as $node) {
            $tableRowCrawler = new Crawler($node);
            $tableCells = $tableRowCrawler->filter('td');
            $tableCellData = [];

            foreach ($tableCells as $cell) {
                $tableCellData[] = $cell->nodeValue;
            }

            $allData[] = $tableCellData;
        }

        $headers = [
            'Name',
            'Organization',
            'Membership',
        ];

        Logger::info(' Scrapping ended');

        $csvGenerator = new CSVGenerator;
        $csvGenerator->generate($allData, $headers, 'members.csv');
    }
}

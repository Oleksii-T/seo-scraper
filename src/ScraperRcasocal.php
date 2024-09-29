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

        // обьявили просто переменную с навшей ссылкой
        $baseUrl = 'https://rcasocal.wildapricot.org/page-7745';

        // с помощью написанного сервиса мы получили html из ссылки
        $baseHtml = PageFetchService::get($baseUrl, true);
        
        // мы обьявляем вендоровский краулер для того что бы вызывать css селекторы на нашем html
        $crawler = new Crawler($baseHtml);
        
        Logger::info(' Crawler inited');
        
        // с браузера взяли нужный нам css селектор
        $cssSelectorOfTableRow = '#membersTable tbody tr';
        
        // мы получили все тани по селектору
        $nodes = $crawler->filter($cssSelectorOfTableRow);
        
        // обьявляем пустой масив для заполенения результата
        $allData = [];
        
        foreach ($nodes as $node) {
            
            // опять обьявляем краулер но уже ограничиваемся конкретной tr-шкой
            $tableRowCrawler = new Crawler($node);
            
            // получает все td-ки в tr-шке
            $tableCells = $tableRowCrawler->filter('td');

            // временный пустой масив для сбора значений конкретной tr-ки.
            // конечный результат: ['Afsharian, Andre', 'Roof Repair', 'Associate']
            $tableCellData = [];

            // проходис по всем td-шкам для получения рекзульата описанного выше
            foreach ($tableCells as $cell) {
                // $tableCellData[] = $cell->getAttribute('src');
                // $tableCellData[] = $cell->getAttribute('href');
                // $tableCellData[] = $cell->getAttribute('alt');
                
                // добавляем текст из tr-ки в наш масив
                $tableCellData[] = $cell->nodeValue;
            }

            // добавляем масив из 3х значений в общий масив результата
            $allData[] = $tableCellData;
        }

        Logger::console($allData);

        /*
            конечный резульата:
            [
                ['Afsharian12, Andre', 'Roof Repair', 'Associate'],
                ['Afsharian2, Andre', 'Roof Repair', 'Associate'],
                ['Afsharian3, Andre', 'Roof Repair', 'Associate'],
                ['Afsharian4, Andre', 'Roof Repair', 'Associate'],
                ['Afsharian5, Andre', 'Roof Repair', 'Associate'],
            ]
        */

        $headers = [
            'Name',
            'Organization',
            'Membership',
        ];

        Logger::info(' Scrapping ended');

        // create class variable from csv generator
        $csvGenerator = new CSVGenerator();

        // call the generator method on the created class
        $csvGenerator->generate($allData, $headers, 'members.csv');
    }
}

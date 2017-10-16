<?php

include "library/UrlAnalyser.php";
require_once realpath(__DIR__ . '/vendor/autoload.php');


$analyser = new UrlAnalyser();
$analyser::$NB_CRAWLED = 0;

\Spatie\Crawler\Crawler::create()
    ->setCrawlObserver($analyser)
    ->startCrawling("http://www.digitick.com");

echo $analyser::$NB_CRAWLED;






?>
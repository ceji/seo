<?php
/**
 * Created by IntelliJ IDEA.
 * User: cjimenez
 * Date: 10/10/2017
 * Time: 21:55
 */

require_once realpath(__DIR__ . '/../vendor/autoload.php');

use PHPHtmlParser\Dom;



class UrlAnalyser implements \Spatie\Crawler\CrawlObserver
{

    static $NB_CRAWLED;


    public function analyseHtml($html) {
        $dom = new Dom;
        $dom->loadStr($html, []);
        $title = $dom->getElementsByTag('title');
        if (count($title) > 0) {
            $this->analyseDomTitle($title[0]->innerHtml);
        }
    }

    public function analyseDomTitle($title)
    {
        $length = strlen($title);
        $sizeMax = 70;
        $sizeMin = 10;
        if (strlen($title) > $sizeMax) {
            throw new Exception("ERROR : Title is too long ($length > $sizeMax)");
        }
        if (strlen($title) < $sizeMin) {
            throw new Exception("ERROR : Title is too small ($length < $sizeMax)");
        }
    }

    /**
     * Called when the crawler will crawl the url.
     *
     * @param \Spatie\Crawler\Url $url
     *
     * @return void
     */
    public function willCrawl(\Spatie\Crawler\Url $url)
    {
        // TODO: Implement willCrawl() method.
        //echo "Starting crawl";
    }

    /**
     * Called when the crawler has crawled the given url.
     *
     * @param \Spatie\Crawler\Url $url
     * @param \Psr\Http\Message\ResponseInterface|null $response
     * @param \Spatie\Crawler\Url $foundOnUrl
     *
     * @return void
     */
    public function hasBeenCrawled(\Spatie\Crawler\Url $url, $response, \Spatie\Crawler\Url $foundOnUrl = null)
    {
        self::$NB_CRAWLED++;
        try {
            $this->analyseHtml($response->getBody()->getContents());
            echo "\n" . self::$NB_CRAWLED . ': ' . $url;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Called when the crawl has ended.
     *
     * @return void
     */
    public function finishedCrawling()
    {
        // TODO: Implement finishedCrawling() method.
    }


}
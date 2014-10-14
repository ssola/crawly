<?php namespace Crawly\Discover;

use \Crawly\Http\Uri as Uri;
use \Crawly\Crawly as Crawly;
use \Symfony\Component\DomCrawler\Crawler as DomCrawler;

class CssSelector implements Discoverable
{
    private $cssSelector;

    public function __construct($cssSelector) 
    {
        $this->cssSelector = $cssSelector;
    }

    public function find(Crawly &$crawler, \GuzzleHttp\Message\Response $response)
    {
        $domCrawler = new DomCrawler($response->__toString());
        $links = $domCrawler->filter($this->cssSelector);

        foreach($links as $node) {
            $uri = new Uri($node->getAttribute('href'), $crawler->getHost());

            if(!$crawler->getVisitedUrl()->seen($uri->toString())) {
                $crawler->getUrlQueue()->push($uri);
            }
        }
    }
}
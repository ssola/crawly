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

    public function find(Crawly &$crawler, $response, \Closure $excluder = null)
    {
        $domCrawler = new DomCrawler($response);
        $links = $domCrawler->filter($this->cssSelector);

        foreach($links as $node) {
            $uri = new Uri($node->getAttribute('href'), $crawler->getHost());

            if(!$crawler->getVisitedUrl()->seen($uri->toString())) {
                // before push to queue, pass this excluder
                if ($excluder !== null) {
                    if (!$excluder($uri->toString())) {
                        continue;
                    }
                }

                $crawler->getUrlQueue()->push($uri);
            }
        }
    }
}
<?php namespace Crawly\Discovers;

use \Crawly\Http\Uri as Uri;

class CssSelector implements Contract
{
    private $cssSelector;

    public function __construct($cssSelector) 
    {
        $this->cssSelector = $cssSelector;
    }

    public function find(
        \GuzzleHttp\Message\Response $response, 
        &$queue, 
        \Crawly\Queues\Visited &$visited, 
        $host = null
    )
    {
        $crawler = new \Symfony\Component\DomCrawler\Crawler($response->__toString());
        $links = $crawler->filter($this->cssSelector);

        foreach($links as $node) {
            $uri = new Uri($node->getAttribute('href'), $host);

            if(!$visited->seen($uri->toString())) {
                $queue->push($uri);
            }
        }
    }
}
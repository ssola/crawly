<?php namespace Crawly;

use Crawly\Extractor\Extractor;
use Crawly\Http\Client;
use Crawly\Archive\Url as UrlArchive;
use Crawly\Archive\Visited as UrlVisitedArchive;
use Crawly\Discover\Discoverable as Discoverable;
use Crawly\Limiter\Limitable;
use Crawly\Discover\Discover;
use Crawly\Limiter\Limiter;

/**
 * Class Crawly
 * @package Crawly
 */
class Crawly
{
    /**
     * Http client that handle all the requests
     *
     * @var Http\Client
     */
    private $client;

    /**
     * Limiter handler
     *
     * @var array
     */
    private $limiter;

    /**
     * Queue of pending urls to visit
     *
     * @var Archive\Url
     */
    private $urlQueue;

    /**
     * Seed url
     *
     * @var
     */
    private $seed;

    /**
     * Seed host
     *
     * @var
     */
    private $seedHost;

    /**
     * List of already visited urls
     * @var Archive\Visited
     */
    private $visited;

    /**
     * Extractor collection
     *
     * @var array
     */
    private $extractor;

    /**
     * Main constructor
     *
     * @param Http\Client $client
     * @param Archive\Url $urlQueue
     * @param Archive\Visited $visited
     */
    public function __construct(
        Client $client,
        UrlArchive $urlQueue,
        UrlVisitedArchive $visited
    )
    {
        $this->client = $client;
        $this->urlQueue = $urlQueue;
        $this->visited = $visited;

        $this->discover = new Discover($this);
        $this->limiter = new Limiter();
        $this->extractor = new Extractor();
    }

    /**
     * Run the crawler
     */
    public function run()
    {
        // TODO refactor this
        while(!$this->urlQueue->isEmpty()) {
            foreach($this->urlQueue->getItems() as $key => $url) {
                echo sprintf("Analyzing %s\r\n", $url->toString());

                // retrieve page data
                $response = $this->client->request($url->toString());

                // add / delete from lists
                $this->urlQueue->delete($key);
                $this->visited->add($url->toString());

                // no data
                if($response == null) {
                    // log this!
                    continue;
                }

                // find more urls to parse
                $this->discover->process($response);

                // extract data
                $this->extractor->extract($response);

                // set limiters
                $this->limiter->check($response);

                echo sprintf("Queue size: %d\r\n", $this->urlQueue->count());
            }
        }
    }

    /**
     * Set seed url
     *
     * @param $url
     */
    public function setSeed($url)
    {
        $this->seed = new Http\Uri($url);
        $this->seedHost = $this->seed->getHost();
        $this->urlQueue->push($this->seed);
    }

    /**
     * Return URL host
     *
     * @return mixed
     */
    public function getHost()
    {
        return $this->seedHost;
    }

    /**
     * Get all visited urls
     *
     * @return Archive\Visited
     */
    public function getVisitedUrl()
    {
        return $this->visited;
    }

    /**
     * Get url queue
     *
     * @return UrlArchive
     */
    public function getUrlQueue()
    {
        return $this->urlQueue;
    }

    /**
     * Include new extractor
     *
     * @param callable $extractor
     */
    public function attachExtractor(\Closure $extractor)
    {
        $this->extractor->add ($extractor);
    }

    /**
     * Include new discover
     *
     * @param Discoverable $discover
     */
    public function attachDiscover(Discoverable $discover)
    {
        $this->discover->add ($discover);
    }

    /**
     * Include new limiter
     *
     * @param Limitable $limiter
     */
    public function attachLimiter(Limitable $limiter)
    {
        $this->limiter->add ($limiter);
    }
}
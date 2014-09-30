<?php namespace Crawly;

class Crawly
{
    private $client;
    private $limiter;
    private $seed;
    private $urlQueue;
    private $discovers;
    private $seedHost;
    private $visited;
    private $extractors;

    // DI for testing
    public function __construct(
        Http\Contract $client,
        Limiters\Contracts\Collection $limiter,
        Queues\Url $urlQueue,
        Queues\Visited $visited
    )
    {
        $this->client = $client;
        $this->limiter = $limiter;
        $this->urlQueue = $urlQueue;
        $this->visited = $visited;
        $this->extractors = [];
    }

    public function run()
    {
        while(!$this->urlQueue->isEmpty()) {
            foreach($this->urlQueue->getItems() as $key => $url) {
                echo sprintf("Analyzing %s\r\n", $url->toString());
                $this->urlQueue->delete($key);
                $response = $this->client->request($url->toString());
                $this->visited->add($url->toString());

                // find more urls to parse
                $this->discover($response);

                // extract data
                $this->extract($response);
                echo sprintf("Queue size: %d\r\n", $this->urlQueue->count());
            }
        }
    }

    public function setSeed($url)
    {
        $this->seed = new Http\Uri($url);
        $this->seedHost = $this->seed->getHost();
        $this->urlQueue->push($this->seed);
    }

    public function extract(\GuzzleHttp\Message\Response $response)
    {
        foreach($this->extractors as $extractor) {
            call_user_func($extractor, $response);
        }
    }

    public function attachExtractor(\Closure $extractor)
    {
        $this->extractors[] = $extractor;
    }

    public function attachDiscover(Discovers\Contract $discover)
    {
        $this->discovers[] = $discover;
    }

    public function discover(\GuzzleHttp\Message\Response $response)
    {
        foreach($this->discovers as $discover) {
            $discover->find($response, $this->urlQueue, $this->visited, $this->seedHost);
        }
    }

    public function attachLimiter(Limiters\Contract $limiter)
    {
        $this->limiter->attach($limiter);
    }

    public static function factory ()
    {
        return new Crawly(
            new Http\Guzzle(),
            new Limiters\Collection(),
            new Queues\Url(),
            new Queues\Visited()
        );
    }
}
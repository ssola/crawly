<?php namespace Crawly;

class Crawly
{
    private $client;
    private $limiter;
    private $seed;
    private $urlQueue;

    // DI for testing
    public function __construct(
        Http\Contract $client,
        Limiters\Contracts\Collection $limiter,
        Queues\Url $urlQueue
    )
    {
        $this->client = $client;
        $this->limiter = $limiter;
        $this->urlQueue = $urlQueue;

        $this->urlQueue->setItem($this->seed);
    }

    public function run()
    {
        while(!$this->urlQueue->isEmpty()) {
            foreach($this->urlQueue->getQueue() as $url) {
                var_dump($url);die;
            }
        }

       // $response = $this->client->request("http://www.gumtree.com");
       // $this->limiter->process($response);
    }

    public function setSeed($url)
    {
        $this->seed = $url;
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
            new Queues\Url()
        );
    }
}
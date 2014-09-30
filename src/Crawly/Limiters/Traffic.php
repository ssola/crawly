<?php namespace Crawly\Limiters;

class Traffic implements Contract
{
    private $amount = 0;
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function process(\GuzzleHttp\Message\Response $response)
    {
        $responseSize = $response->getBody()->getSize();
        $this->amount += $responseSize;
    }

    public function shouldStop()
    {
        if($this->amount > $this->config['max_traffic']) {
            return true;
        }
    }
}
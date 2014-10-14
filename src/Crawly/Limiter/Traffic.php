<?php namespace Crawly\Limiter;

use \GuzzleHttp\Message\Response as Response;

class Traffic extends Base implements Limitable
{
    private $amount = 0;

    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    public function process(Response $response)
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
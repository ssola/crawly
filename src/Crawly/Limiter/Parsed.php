<?php namespace Crawly\Limiter;

use \GuzzleHttp\Message\Response as Response;

class Parsed extends Base implements Limitable
{
    private $amount = 0;

    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    public function process(Response $response)
    {
        $this->amount += 1;
    }

    public function shouldStop()
    {
        if($this->amount >= $this->config['num_links']) {
            return true;
        }
    }
}
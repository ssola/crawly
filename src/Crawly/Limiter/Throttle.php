<?php namespace Crawly\Limiter;

use \GuzzleHttp\Message\Response as Response;

class Throttle extends Base implements Limitable
{
    private $times = [];
    private $average = 1.0;
    private $previousRequestTime = 0;
    private $currentRequestTime = 0;

    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->previousRequestTime = microtime();
    }

    public function process(Response $response)
    {
        $this->currentRequestTime = microtime();
 
        $this->times[] = abs($this->currentRequestTime - $this->previousRequestTime) * 2;

        // recalculate average
        $this->average = array_sum($this->times) / count($this->times);

        $this->previousRequestTime = $this->currentRequestTime;
    }

    public function shouldStop()
    {
        $numPerMinute = $this->config['num_request_per_minute'];
        $timeToSleep = ($this->average * 60 / $numPerMinute);
        echo $timeToSleep;
        usleep(intval($timeToSleep*1000000));
    }
}
<?php namespace Crawly\Limiters;

class Collection implements Contracts\Collection
{
    private $limiters = array();

    public function attach(Contract $limiter)
    {
        $this->limiters[] = $limiter;
    }

    public function process(\GuzzleHttp\Message\Response $response)
    {
        if(empty($this->limiters)) {
            return true;
        }

        foreach($this->limiters as $limiter) {
            $limiter->process($response);

            if($limiter->shouldStop()) {
                die(sprintf("Stopped by %s limiter", get_class($limiter)));
            }
        }
    }
}
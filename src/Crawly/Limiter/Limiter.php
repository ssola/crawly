<?php
/**
 * Created by PhpStorm.
 * User: ssola
 * Date: 14/10/14
 * Time: 15:21
 */

namespace Crawly\Limiter;

use GuzzleHttp\Message\Response as Response;

class Limiter
{
    private $limiters = [];

    public function __construct() {}

    public function add (Limitable $limiter)
    {
        $this->limiters[] = $limiter;
    }

    public function check (Response $response)
    {
        /* @var $limiter Limiter */
        foreach($this->limiters as $limiter) {
            $limiter->process($response);
            if($limiter->shouldStop()) {
                throw new \RuntimeException(
                    sprintf("Process %s has terminated this crawler (%s)", get_class($limiter), $limiter->getConfig())
                );
            }
        }
    }
} 
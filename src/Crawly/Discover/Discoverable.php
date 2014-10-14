<?php namespace Crawly\Discover;

use \Crawly\Crawly as Crawly;
use \GuzzleHttp\Message\Response as Response;

interface Discoverable
{
    public function find(Crawly &$crawler, Response $response);
}
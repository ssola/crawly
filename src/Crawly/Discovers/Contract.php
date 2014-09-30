<?php namespace Crawly\Discovers;

interface Contract
{
    public function find(\GuzzleHttp\Message\Response $response, &$queue, \Crawly\Queues\Visited &$visited, $host = null);
}
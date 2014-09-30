<?php namespace Crawly\Limiters\Contracts;

interface Collection
{
    public function process(\GuzzleHttp\Message\Response $response);
}
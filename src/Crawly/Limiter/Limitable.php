<?php namespace  Crawly\Limiter;

interface Limitable
{
    public function process(\GuzzleHttp\Message\Response $response);
    public function shouldStop();
}
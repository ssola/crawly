<?php namespace  Crawly\Limiters;

interface Contract
{
    public function process(\GuzzleHttp\Message\Response $response);
    public function shouldStop();
}
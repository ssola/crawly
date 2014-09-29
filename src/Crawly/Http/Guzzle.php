<?php namespace Crawly\Http;


class Guzzle implements Contract
{
     private $client = null;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    public function request($url)
    {
        echo "request";
    }

    public function getContents()
    {
        
    }
}
<?php namespace Crawly\Http;

use GuzzleHttp\Message\Response as Response;
use \GuzzleHttp\Client as GuzzleClient;

class Guzzle implements Client
{
    private $client = null;
    private $response = null;

    public function __construct()
    {
        $this->client = new GuzzleClient();
    }

    public function request($url)
    {
        $this->response = $this->client->get($url);

        if(!$this->response instanceof Response) {
            throw new \RuntimeException("Response is not instance of Response");
        }

        if($this->response->getStatusCode() == Client::SUCCESS_REQUEST) {
            return $this->response;
        }

        return false;
    }

    public function getContent()
    {
        return $this->response->getBody();
    }

    public function getSize()
    {
        return $this->response->getBody()->getSize();
    }
}
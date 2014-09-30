<?php namespace Crawly\Http;

use GuzzleHttp\Message\Response as Response;

class Guzzle implements Contract
{
    private $client = null;
    private $response = null;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    public function request($url)
    {
        $this->response = $this->client->get($url);

        if(!$this->response instanceof Response) {
            throw new \RuntimeException("Response is not instance of Response");
        }

        if($this->response->getStatusCode() == Contract::SUCCESS_REQUEST) {
            return $this->response;
        }

        return null;
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
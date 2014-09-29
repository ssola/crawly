<?php namespace Crawly;

class Crawly
{
    private $client;

    // DI for testing
    public function __construct(Http\Contract $client)
    {
        $this->client = $client;
    }

    public static function factory ()
    {
        return new Crawly(
            new Http\Guzzle()
        );
    }
}
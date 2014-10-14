<?php namespace Crawly;

use Crawly\Http\Client;
use Crawly\Archive\Url as UrlArchive;
use Crawly\Archive\Visited as UrlVisitedArchive;

class Factory
{
    public static function generic()
    {
        return self::create (
            new Http\Guzzle(),
            new Archive\Url(),
            new Archive\Visited()
        );
    }

    public static function create (Client $client, UrlArchive $urlQueue, UrlVisitedArchive $visited)
    {
        return new Crawly(
            $client,
            $urlQueue,
            $visited
        );
    }
}
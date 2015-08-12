<?php
/**
 * Created by PhpStorm.
 * User: ssola
 * Date: 14/10/14
 * Time: 15:29
 */

namespace Crawly\Extractor;

use GuzzleHttp\Message\Response as Response;
use Closure;

class Extractor
{
    private $extractors = [];
    private $crawler;

    /**
     * @param $crawler
     */
    public function __construct($crawler)
    {
        $this->crawler = $crawler;
    }

    public function add (Closure $callback)
    {
        $this->extractors[] = $callback;
    }

    public function extract ($response)
    {
        foreach($this->extractors as $extractor) {
            call_user_func($extractor, $response);
        }
    }
} 
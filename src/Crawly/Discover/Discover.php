<?php
/**
 * Created by PhpStorm.
 * User: ssola
 * Date: 14/10/14
 * Time: 14:49
 */

namespace Crawly\Discover;

use GuzzleHttp\Message\Response as Response;

class Discover
{
    private $discovers = [];
    private $crawler = null;

    public function __construct($crawler)
    {
        $this->crawler = $crawler;
    }

    public function add (Discoverable $discover, \Closure $excluder = null)
    {
        $this->discovers[] = [
            'discover' => $discover,
            'excluder' => $excluder
        ];
    }

    public function process ($response)
    {
        foreach($this->discovers as $discover) {
            $discover['discover']->find($this->crawler, $response, $discover['excluder']);
        }
    }
} 
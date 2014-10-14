<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once("vendor/autoload.php");

$crawler = Crawly\Factory::generic();

$crawler->attachLimiter(
  new \Crawly\Limiter\Traffic(['max_traffic' => 8000000000]) // 1 Gb
);

$crawler->attachLimiter(
  new \Crawly\Limiter\Parsed(['num_links' => 60]) // 1 Gb
);

$crawler->attachLimiter(
    new \Crawly\Limiter\Throttle(['num_request_per_minute' => 10])
);

$crawler->attachDiscover(
    new Crawly\Discover\CssSelector('nav.pagination > ul > li > a')
);

$crawler->attachExtractor(
    function(\GuzzleHttp\Message\Response $response) {
        // here we have the response, work with it!
    }
);

$crawler->setSeed("http://www.gumtree.com/flatshare-offered/england/page1");
$crawler->run();
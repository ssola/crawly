<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once("vendor/autoload.php");

$crawler = Crawly\Crawly::factory();

$crawler->attachDiscover(
    new Crawly\Discovers\CssSelector('nav.pagination > ul > li > a')
);

$crawler->attachExtractor(
    function($response) {
        // here we have the response, work with it!
    }
);

$crawler->setSeed("http://www.gumtree.com/flatshare-offered/england/");
$crawler->run();
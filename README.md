Crawly
======

Crawly is a simple web crawler able to extract and follow discovered links.

###Example

```php
require_once("vendor/autoload.php");

// Create a new Crawly object
$crawler = Crawly\Crawly::factory();

// Discovers are allows you to extract links to follow
$crawler->attachDiscover(
    new Crawly\Discovers\CssSelector('nav.pagination > ul > li > a')
);

// After we scrapped and discovered links you can add your own closures to handle the data
$crawler->attachExtractor(
    function($response) {
        // here we have the response, work with it!
    }
);

// set seed page
$crawler->setSeed("http://www.gumtree.com/flatshare-offered/england/");

// start the crawler
$crawler->run();
```

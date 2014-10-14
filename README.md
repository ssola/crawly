Crawly
======

Crawly is a simple web crawler able to extract and follow links depending on the discovers.

### Simple Example

```php
require_once("vendor/autoload.php");

// Create a new Crawly object
$crawler = Crawly\Factory::generic();

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
$crawler->setSeed("http://www.webpage.com/test/");

// start the crawler
$crawler->run();
```

## Crawler object

You can create a simple crawler with the Crawler Factory, it will generate a Crawly object using Guzzle as Http client.

```php
$crawler = Crawly\Factory::generic();
```

You can create a personalized crawler specified which Http client, Url queue and Visited link collection to use.

```php
$crawler = Crawly\Factory::create(new MyHttpClass(), new MyUrlQueue(), new MyVisitedCollection());
```

## Discovers

Discovers are used to extract from the html a set of links to include to the queue. You can include as many discovers as you want and you can create your own discovers classes too.

At the moment Crawly only includes a Css Selector discover.

### Create your own discover

Just create a new class that implements the **Discoverable** interface. This new class should look like this example:

```php
class MyOwnDiscover implements Discoverable
{
    private $configuration;

    public function __construct($configuration) 
    {
        $this->configuration = $configuration;
    }

    public function find(Crawly &$crawler,  $response)
    {
        // $response has the crawled url content
        // do some magin on the response and get a colleciton of links
        
        foreach($links as $node) {
            $uri = new Uri($node->getAttribute('href'), $crawler->getHost());

            // if url was not visited we should include this new links to the Url Queue
            if(!$crawler->getVisitedUrl()->seen($uri->toString())) {
                $crawler->getUrlQueue()->push($uri);
            }
        }
    }
}
```

## Limiters

## Extractors

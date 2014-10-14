<?php namespace Crawly\Http;

class Uri
{
    private $url;
    private $parts;

    public function __construct($url, $host = null)
    {
        $this->url = $url;
        $this->parts = parse_url($url);

        if($host !== null) {
            $this->setHost($host);
        }
    }

    public function setHost($host)
    {
        $this->parts['host'] = $host;
    }

    public function getHost()
    {
        return $this->parts['host'];
    }

    public function getScheme()
    {
        if(!isset($this->parts['scheme'])) {
            $this->parts['scheme'] = "http";
        }

        return $this->parts['scheme'];
    }

    public function toString()
    {
        return sprintf("%s://%s%s",$this->getScheme(), $this->getHost(), $this->parts['path']);
    }
}
<?php namespace Crawly\Archive;

class Visited
{
    private $visited = [];

    public function __construct()
    {
        $this->visited = [];
    }

    public function seen($url)
    {
        if(isset($this->visited[$url])) {
            return true;
        }

        return false;
    }

    public function count()
    {
        return count($this->visited);
    }

    public function add($url)
    {
        if($this->seen($url)) {
            return false;
        }

        $this->visited[$url] = true;

        return true;
    }
}
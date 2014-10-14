<?php namespace Crawly\Archive;

class Url
{
    private $stack;

    public function __construct()
    {
        $this->stack = [];
    }

    public function push($item)
    {
        foreach($this->stack as $url) {
            if($item->toString() == $url->toString()) {
                return false;
            }
        }

        $this->stack[] = $item;
    }

    public function delete($key)
    {
        unset($this->stack[$key]);
    }

    public function isEmpty()
    {
        if(count($this->stack) > 0) {
            return false;
        }

        return true;
    }

    public function count()
    {
        return count($this->stack);
    }

    public function getItems()
    {
        ksort($this->stack);

        return $this->stack;
    }

}
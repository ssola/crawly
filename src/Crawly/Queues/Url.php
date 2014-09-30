<?php namespace Crawly\Queues;

class Url
{
    private $queue;

    public function __construct()
    {
        $this->queue = new \SplQueue();
    }

    public function isEmpty()
    {
        return $this->queue->isEmpty();
    }

    public function getQueue()
    {
        return $this->queue;
    }

    public function setItem($url)
    {
        $this->queue->enqueue($url);
    }
}
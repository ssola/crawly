<?php namespace  Crawly\Http;

interface Client
{
    const SUCCESS_REQUEST = 200;

    public function request($url);
    public function getContent();
    public function getSize();
}
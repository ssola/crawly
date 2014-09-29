<?php namespace  Crawly\Http;

interface Contract
{
    public function request($url);
    public function getContents();
}
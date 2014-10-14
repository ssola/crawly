<?php
/**
 * Created by PhpStorm.
 * User: ssola
 * Date: 14/10/14
 * Time: 14:32
 */

namespace Crawly\Limiter;


class Base
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return serialize($this->config);
    }
} 
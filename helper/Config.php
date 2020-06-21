<?php

class Config
{
    private $config;

    public function __construct($configPath)
    {
        $this->config = parse_ini_file($configPath, true);
    }

    public function get($section, $key)
    {
        return $this->config[$section][$key];
    }
}
<?php

class SitePackConnect
{

    private static $instance;

    public static function getInstance(): SitePackConnect
    {
        if (!isset(self::$instance)) {
            self::$instance = new SitePackConnect();

            self::$instance->init();
        }

        return self::$instance;
    }

    public static function init()
    {

    }

    public function fetchLiveStock(string $importSource, string $ean): array
    {


    }

}
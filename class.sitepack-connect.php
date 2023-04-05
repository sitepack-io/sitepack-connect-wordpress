<?php

include SITEPACK_CONNECT_PLUGIN_DIR . '/models/class.sitepack-stock.php';

class SitePackConnect
{

    private static ?SitePackConnect $instance = null;

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

    public function fetchLiveStock(string $siteUuid, string $importSource, string $ean): SitePackStock
    {
        $url = 'https://api.sitepack.nl/%s/%s/%s';
        $url = sprintf(
            $url,
            $siteUuid,
            $importSource,
            $ean
        );

        $response = wp_remote_post($url);

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();

            return new SitePackStock(
                false,
                0,
                0,
                0,
                false,
                []
            );
        }

//        dump($response);
//        exit;

    }

}
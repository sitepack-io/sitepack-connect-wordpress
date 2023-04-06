<?php

include SITEPACK_CONNECT_PLUGIN_DIR . '/models/class.sitepack-stock.php';
include SITEPACK_CONNECT_PLUGIN_DIR . '/models/class.sitepack-stock-location.php';

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
        $sitePackApiHost = apply_filters('sitepack_api_hostname', 'https://api.sitepack.nl');
        $url = $sitePackApiHost . '/api/v2/products/%s/%s/%s/connect/stock';
        $url = sprintf(
            $url,
            $siteUuid,
            $importSource,
            $ean
        );

        $response = wp_remote_post($url);

        if (is_wp_error($response)) {
            $errorMessage = $response->get_error_message();

            return new SitePackStock(
                false,
                0,
                0,
                0,
                false,
                [],
                null,
                $errorMessage
            );
        }


        if (empty($response['body'])) {
            return new SitePackStock(
                false,
                0,
                0,
                0,
                false,
                [],
                null,
                'Empty body response'
            );
        }

        $data = json_decode($response['body'], true);

        $locations = [];
        if (is_array($data['stock']['locations'])) {
            foreach ($data['stock']['locations'] as $dataLocation) {
                $locations[] = SitePackStockLocation::fromSitePackConnectData($dataLocation);
            }
        }

        return new SitePackStock(
            $data['stock']['inStock'],
            $data['stock']['quantityAvailable'],
            $data['stock']['quantitySupplier'],
            0, // TODO in SP API
            $data['stock']['allowBackorder'],
            $locations,
            ($data['stock']['deliveryDate'] !== null) ? new DateTimeImmutable($data['stock']['deliveryDate']) : null,
            $data['stock']['errorReason'],
        );
    }

}
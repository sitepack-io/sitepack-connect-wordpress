<?php
/**
 * @package SitePack Connect
 */

/*
Plugin Name: SitePack Connect
Plugin URI: https://sitepack.nl/integraties
Description: Connect your eCommerce store with external APIs, using SitePack Connect. Import products with stock information and export orders to your favorite third party software.
Version: 1.1.0
Author: SitePack B.V.
Author URI: https://sitepack.nl
License: GPLv2 or later
Text Domain: sitepack
*/

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, please visit our site if you want to: sitepack.nl.';
    exit;
}

define('SITEPACK_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('SITEPACK_CONNECT_VERSION', '1.0.0');
define('SITEPACK_CONNECT_PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once(SITEPACK_CONNECT_PLUGIN_DIR . 'class.sitepack-connect.php');
require_once(SITEPACK_CONNECT_PLUGIN_DIR . 'class.sitepack-connect-rest-api.php');

add_action('init', ['SitePackConnect', 'init']);

$sitePackRestApi = new SitePackConnectRestApi();
add_action('rest_api_init', [$sitePackRestApi, 'init']);

if (is_admin() || (defined('WP_CLI') && WP_CLI)) {
    require_once(SITEPACK_CONNECT_PLUGIN_DIR . 'class.sitepack-connect-admin.php');
    $admin = new SitePackConnectAdmin();
    $admin->init();
}

if (!function_exists('spWooIsActive')) {
    function spWooIsActive()
    {
        if (class_exists('woocommerce')) {
            return true;
        }

        return false;
    }
}

if (!function_exists('spGetProductStockInformation')) {
    /**
     * Fetch the live stock information
     *
     * @param int $productId
     * @return array
     */
    function spGetProductStockInformation(int $productId): ?SitePackStock
    {
        $connect = SitePackConnect::getInstance();
        $product = wc_get_product($productId);

        if (!$product instanceof WC_Product) {
            return null;
        }

        if (empty($product->get_meta('site'))
            || empty($product->get_meta('import_source'))
            || empty($product->get_meta('ean'))
        ) {
            return null;
        }

        return $connect->fetchLiveStock(
            $product->get_meta('site'),
            $product->get_meta('import_source'),
            $product->get_meta('ean')
        );
    }
}

add_action('init', 'spFetchstock');

function spFetchstock()
{
    if (is_admin()) {
        return;
    }

    $ajaxStock = (bool)apply_filters('sitepack_fetch_live_stock', true);
    // TODO: build in stock info
}





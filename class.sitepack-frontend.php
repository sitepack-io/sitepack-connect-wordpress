<?php

class SitePackFrontend
{

    public function init()
    {
        add_action('woocommerce_single_product_summary', [$this, 'sitepackCustomProductCode'], 33);
        add_filter('woocommerce_get_availability_text', [$this, 'sitepackProductAvailability'], 99, 2);
        add_action('wp_enqueue_scripts', [$this, 'sitepackEnqueueScripts']);
        add_action('wp_enqueue_scripts', [$this, 'sitepackEnqueueStyles']);
    }

    public function sitepackProductAvailability($availability, $product): string
    {
        return $availability;
    }

    public function sitepackCustomProductCode(): void
    {
        global $product;

        echo '<div id="sitePackStockLocations"></div>';
        echo '<script>
var ajaxurl = "' . admin_url('admin-ajax.php') . '";
var data = {
    action: "sitepack_product_stock",
    product_id: ' . $product->get_id() . ',
    nonce: "' . wp_create_nonce('sitepack_product_stock') . '",
};

fetch(ajaxurl, {
    method: "POST",
    headers: {
        "Content-Type": "application/x-www-form-urlencoded",
    },
    body: new URLSearchParams(data),
})
.then(function(response) {
    if (response.ok) {
        return response.json();
    } else {
        throw new Error("Error: " + response.status);
    }
})
.then(function(data) {
    sitePackDisplayStockLocations(data.data.stock);
})
.catch(function(error) {
    console.log(error);
});
</script>';
    }

    public function sitepackEnqueueScripts()
    {
        wp_enqueue_script(
            'sitepack-stock',
            plugins_url('/assets/sitepack_stock.js', SITEPACK_PLUGIN_FILE),
            ['jquery'],
            1.0,
            true
        );
        wp_localize_script('sitpack-connect', 'productStockNonce', array(
            'ajax_nonce_sitepack' => wp_create_nonce('sitepack_product_stock'),
        ));
    }

    public function sitepackEnqueueStyles()
    {
        wp_enqueue_style('sitepack-stock-styles', plugins_url('/assets/sitepack_stock.css', SITEPACK_PLUGIN_FILE));
    }

}


<?php

require_once(SITEPACK_CONNECT_PLUGIN_DIR . 'models/class.sitepack-category.php');

class SitePackWooCommerceService
{

    public function getCategories()
    {
        return [
            SitePackCategory::fromWooCommerce([
                'id' => 2431,
                'name' => 'Test',
            ]),
        ];
    }

}
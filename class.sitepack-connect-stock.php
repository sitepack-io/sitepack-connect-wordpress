<?php

require_once(SITEPACK_CONNECT_PLUGIN_DIR . 'services/class.sitepack-woocommerce.php');

class SitePackConnectStock
{

    private SitePackConnect $sitePackConnect;

    public function __construct(SitePackConnect $sitePackConnect)
    {
        $this->sitePackConnect = $sitePackConnect;
    }


}
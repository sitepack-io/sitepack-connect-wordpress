<?php

require_once(SITEPACK_CONNECT_PLUGIN_DIR . 'services/class.sitepack-woocommerce.php');

class SitePackConnectRestApi
{
    /** @var SitePackWooCommerceService */
    private $wooCommerceService = null;

    public function init()
    {
        if (spWooIsActive() === false) {
            return;
        }

        $this->wooCommerceService = new SitePackWooCommerceService();

        register_rest_route('sitepack-connect/v1', '/categories', [
            'methods' => 'GET',
            'callback' => [$this, 'renderCategories'],
        ]);
        register_rest_route('sitepack-connect/v1', '/categories/(?P<id>\d+)', [
            'methods' => 'GET',
            'callback' => [$this, 'renderCategoryUpdate'],
        ]);
    }

    public function renderCategories(WP_REST_Request $request)
    {
        return [
            'status' => 'success',
            'categories' => $this->wooCommerceService->getCategories(),
        ];
    }

    public function renderCategoryUpdate(WP_REST_Request $request)
    {
        $id = $request['id'];
        if (empty($id)) {
            return $this->renderError('Empty category id!');
        }

        return ['test' => $id];
    }

    private function renderError(string $message): array
    {
        return [
            'status' => 'failed',
            'message' => $message,
        ];
    }

}
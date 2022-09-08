<?php

require_once(SITEPACK_CONNECT_PLUGIN_DIR . 'services/class.sitepack-woocommerce.php');

class SitePackConnectRestApi
{
    const MESSAGE_UNAUTHORIZED = 'UNAUTHORIZED';

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
        register_rest_route('sitepack-connect/v1', '/categories/create', [
            'methods' => 'POST',
            'callback' => [$this, 'renderCategoriesCreate'],
        ]);
        register_rest_route('sitepack-connect/v1', '/categories/(?P<id>\d+)', [
            'methods' => 'GET',
            'callback' => [$this, 'renderCategoryUpdate'],
        ]);
        register_rest_route('sitepack-connect/v1', '/orders', [
            'methods' => 'GET',
            'callback' => [$this, 'renderOrders'],
        ]);
        register_rest_route('sitepack-connect/v1', '/products/create', [
            'methods' => 'POST',
            'callback' => [$this, 'renderCreateProduct'],
        ]);
        register_rest_route('sitepack-connect/v1', '/products/(?P<id>\d+)/update', [
            'methods' => 'POST',
            'callback' => [$this, 'renderUpdateProduct'],
        ]);
        register_rest_route('sitepack-connect/v1', '/products/(?P<id>\d+)/archive', [
            'methods' => 'POST',
            'callback' => [$this, 'renderArchiveProduct'],
        ]);
        register_rest_route('sitepack-connect/v1', '/products/(?P<id>\d+)/image', [
            'methods' => 'POST',
            'callback' => [$this, 'renderImageProduct'],
        ]);
    }

    public function renderCategories(WP_REST_Request $request)
    {
        try {
            $this->authenticateRequest($request);

            return [
                'status' => 'success',
                'categories' => $this->wooCommerceService->getCategories(),
            ];
        } catch (\Exception $exception) {
            return $this->renderError($exception->getMessage());
        }
    }

    public function renderCategoriesCreate(WP_REST_Request $request)
    {
        try {
            $this->authenticateRequest($request);

//            $data['uuid'],
//            $data['name'],
//            $data['slug'],
//            $data['parentUuid'],

            return [
                'status' => 'success',
                'category' => [],// return data
            ];
        } catch (\Exception $exception) {
            return $this->renderError($exception->getMessage());
        }
    }

    public function renderOrders(WP_REST_Request $request)
    {
        try {
            $this->authenticateRequest($request);

            return [
                'status' => 'success',
                'orders' => $this->wooCommerceService->getOrders(),
            ];
        } catch (\Exception $exception) {
            return $this->renderError($exception->getMessage());
        }
    }

    public function renderCategoryUpdate(WP_REST_Request $request)
    {
        try {
            $this->authenticateRequest($request);

            $id = $request['id'];
            if (empty($id)) {
                return $this->renderError('Empty category id!');
            }

            return [
                'status' => 'success',
            ];
        } catch (\Exception $exception) {
            return $this->renderError($exception->getMessage());
        }
    }

    public function renderCreateProduct(WP_REST_Request $request)
    {
        try {
            $this->authenticateRequest($request);

            $product = $this->wooCommerceService->mapProductFromData(
                $request
            );
            $productId = $this->wooCommerceService->saveProduct($product);

            return [
                'status' => 'success',
                'product_id' => $productId,
            ];
        } catch (\Exception $exception) {
            return $this->renderError($exception->getMessage());
        }
    }

    public function renderUpdateProduct(WP_REST_Request $request)
    {
        try {
            $this->authenticateRequest($request);

            $product = $this->wooCommerceService->mapProductFromData(
                $request
            );

            $productId = $this->wooCommerceService->saveProduct($product);

            return [
                'status' => 'success',
                'product_id' => $productId,
            ];
        } catch (\Exception $exception) {
            return $this->renderError($exception->getMessage());
        }
    }

    public function renderImageProduct(WP_REST_Request $request)
    {
        try {
            $this->authenticateRequest($request);

            $product = $this->wooCommerceService->findProduct($request['productId']);

            return [
                'status' => 'success',
                'image_id' => 1,
            ];
        } catch (\Exception $exception) {
            return $this->renderError($exception->getMessage());
        }
    }

    private function renderError(string $message)
    {
        if ($message === self::MESSAGE_UNAUTHORIZED) {
            return new WP_Error(
                'rest_forbidden',
                'You do not have permissions to view this data.', ['status' => 401]
            );
        }

        return new WP_Error(
            500,
            $message,
            ['status' => 'failed']
        );
    }

    private function authenticateRequest(WP_REST_Request $request)
    {
//        throw new Exception(self::MESSAGE_UNAUTHORIZED);
    }

}
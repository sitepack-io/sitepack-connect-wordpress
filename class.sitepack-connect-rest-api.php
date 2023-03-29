<?php

require_once(SITEPACK_CONNECT_PLUGIN_DIR . 'services/class.sitepack-woocommerce.php');
require_once(SITEPACK_CONNECT_PLUGIN_DIR . 'class.sitepack-connect-admin.php');

class SitePackConnectRestApi
{
    const MESSAGE_UNAUTHORIZED = 'UNAUTHORIZED';

    /** @var SitePackWooCommerceService */
    private $eCommerceService = null;

    public function init()
    {
        if (spWooIsActive() === false) {
            return;
        }

        $this->eCommerceService = new SitePackWooCommerceService();

        register_rest_route('sitepack-connect/v1', '/categories', [
            'methods' => 'GET',
            'callback' => [$this, 'renderCategories'],
        ]);
        register_rest_route('sitepack-connect/v1', '/categories/create', [
            'methods' => 'POST',
            'callback' => [$this, 'renderCategoriesCreate'],
        ]);
        register_rest_route('sitepack-connect/v1', '/categories/update/(?P<id>\d+)', [
            'methods' => 'POST',
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
            'args' => [
                'id' => [
                    'validate_callback' => function ($param) {
                        return is_numeric($param);
                    }
                ],
            ],
        ]);
        register_rest_route('sitepack-connect/v1', '/products/(?P<id>\d+)/image', [
            'methods' => 'POST',
            'callback' => [$this, 'renderImageProduct'],
            'args' => [
                'id' => [
                    'validate_callback' => function ($param) {
                        return is_numeric($param);
                    }
                ],
            ],
        ]);
        register_rest_route('sitepack-connect/v1', '/products/(?P<id>\d+)/archive', [
            'methods' => 'POST',
            'callback' => [$this, 'renderArchiveProduct'],
            'args' => [
                'id' => [
                    'validate_callback' => function ($param) {
                        return is_numeric($param);
                    }
                ],
            ],
        ]);
    }

    public function renderCategories(WP_REST_Request $request)
    {
        try {
            $this->authenticateRequest($request);

            return [
                'status' => 'success',
                'categories' => $this->eCommerceService->getCategories(),
            ];
        } catch (\Exception $exception) {
            return $this->renderError($exception->getMessage());
        }
    }

    public function renderCategoriesCreate(WP_REST_Request $request)
    {
        try {
            $this->authenticateRequest($request);
            $this->validateRequiredFields($request, [
                'import_source',
                'name',
                'slug',
                'parentId',
            ]);

            $category = $this->eCommerceService->createCategory(
                $request['import_source'],
                $request['name'],
                $request['slug'],
                $request['parentId'],
            );

            return [
                'status' => 'success',
                'category' => [
                    'id' => $category->term_id,
                    'name' => $category->name,
                    'url' => get_term_link($category),
                    'parent' => $category->parent,
                ],
            ];
        } catch (\Exception $exception) {
            return $this->renderError($exception->getMessage());
        }
    }

    public function renderCategoryUpdate(WP_REST_Request $request)
    {
        try {
            $this->authenticateRequest($request);
            $this->validateRequiredFields($request, [
                'name',
                'parentId',
            ]);

            $category = $this->eCommerceService->findCategory((int)$request['id']);

            if (!$category instanceof WP_Term) {
                throw new Exception('Invalid category!');
            }

            $this->eCommerceService->updateCategory(
                $category,
                $request['name'],
                $request['parentId'],
            );

            return [
                'status' => 'success',
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
                'orders' => $this->eCommerceService->getOrders(),
            ];
        } catch (\Exception $exception) {
            return $this->renderError($exception->getMessage());
        }
    }

    public function renderCreateProduct(WP_REST_Request $request)
    {
        try {
            $this->authenticateRequest($request);
            $this->validateRequiredFields($request, [
                'name',
                'ean',
                'site',
                'importSource',
                'salesPrice',
                'shortDescription',
                'longDescription',
                'categoryId',
                'inStock',
                'stockSupplier',
                'hasStock',
            ]);

            $product = $this->eCommerceService->mapProductFromData(
                $request
            );
            $productId = $this->eCommerceService->saveProduct($request, $product);

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
            $this->validateRequiredFields($request, [
                'name',
                'ean',
                'site',
                'importSource',
                'salesPrice',
                'shortDescription',
                'longDescription',
                'categoryId',
                'id',
                'inStock',
                'stockSupplier',
                'hasStock',
            ]);

            $product = $this->eCommerceService->mapProductFromData(
                $request
            );

            $productId = $this->eCommerceService->saveProduct($request, $product);

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
            $this->validateRequiredFields($request, [
                'id',
                'imageContent',
                'alt',
            ]);

            $product = $this->eCommerceService->findProduct($request['id']);

            $mediaId = $this->eCommerceService->saveProductImage(
                $product,
                $request
            );

            if (is_array($request['imageGallery'])) {
                $images = array_merge($request['imageGallery'], [$mediaId]);
            } else {
                $images = [$mediaId];
            }

            $mainImage = current($images);

            foreach ($images as $key => $id) {
                if ((int)$mainImage === (int)$id || (int)$id === 0 || empty($id)) {
                    unset($images[$key]);
                }
            }

            set_post_thumbnail($product->get_id(), $mainImage);
            $product->set_gallery_image_ids($images);
            $product->set_image_id($mainImage);

            if (count($images) >= 1) {
                update_post_meta(
                    $product->get_id(),
                    '_product_image_gallery',
                    implode(',', $images)
                );
            } else {
                update_post_meta(
                    $product->get_id(),
                    '_product_image_gallery',
                    null
                );
            }

            $product->save();

            return [
                'status' => 'success',
                'product' => [
                    'main' => $product->get_image(),
                    'gallery' => $product->get_gallery_image_ids(),
                    'thumb' => get_post_thumbnail_id($product),
                    'debug' => $images,
                ],
                'image_id' => $mediaId,
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
            esc_attr($message),
            ['status' => 'failed']
        );
    }

    private function authenticateRequest(WP_REST_Request $request)
    {
        $request->get_header('x-api-key');
        $request->get_header('x-api-secret');

        if (empty($request->get_header('x-api-key'))
            || $request->get_header('x-api-key') !== get_option(SitePackConnectAdmin::SITEPACK_API_KEY)) {
            throw new Exception(self::MESSAGE_UNAUTHORIZED);
        }

        if (empty($request->get_header('x-api-secret'))
            || $request->get_header('x-api-secret') !== get_option(SitePackConnectAdmin::SITEPACK_API_SECRET)) {
            throw new Exception(self::MESSAGE_UNAUTHORIZED);
        }
    }

    private function validateRequiredFields(WP_REST_Request $request, array $fields): void
    {
        foreach ($fields as $field) {
            if (!isset($request[$field])) {
                throw new Exception('Missing data field: ' . esc_attr($field));
            }
        }
    }

}
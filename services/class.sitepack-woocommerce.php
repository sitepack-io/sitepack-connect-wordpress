<?php

require_once(SITEPACK_CONNECT_PLUGIN_DIR . 'models/class.sitepack-category.php');

class SitePackWooCommerceService
{

    public function getCategories(): array
    {
        $cat_args = [
            'orderby' => 'name',
            'order' => 'asc',
            'hide_empty' => false,
        ];

        $product_categories = get_terms('product_cat', $cat_args);

        $categories = [];

        if (!empty($product_categories)) {
            foreach ($product_categories as $key => $category) {
                $categories[$category->term_id] = $category;
            }
        }

        $wooCategories = [];
        foreach ($categories as $category) {
            $wooCategories[] = SitePackCategory::fromWooCommerce($categories, $category);
        }

        return $wooCategories;
    }

    public function getOrders(): array
    {
    }

    public function mapProductFromData(WP_REST_Request $data): WC_Product_Simple
    {
        $product = new WC_Product_Simple();
        if (!empty($data['productId'])) {
            $product = $this->findProduct($data['productId']);
        }

        $product->set_name($data['name']);
        $product->set_slug($data['slug']);

        $product->set_regular_price(\number_format($data['salesPrice'], 2, '.', ''));

        if (!empty($data['promoSalesPrice'])) {
            $product->set_sale_price(\number_format($data['promoSalesPrice'], 2, '.', ''));
        }

        $product->set_date_on_sale_from(null);
        $product->set_date_on_sale_to(null);
        if (!empty($data['promoStart']) && !empty($data['promoEnd'])) {
            $product->set_date_on_sale_from((new DateTimeImmutable($data['promoStart']))->format('Y-m-d H:i:s'));
            $product->set_date_on_sale_to((new DateTimeImmutable($data['promoEnd']))->format('Y-m-d H:i:s'));
        }

        $product->set_short_description($data['shortDescription']);
        if (!empty($data['longDescription'])) {
            $product->set_description($data['longDescription']);
        }


        // let's suppose that our 'Accessories' category has ID = 19
        $product->set_category_ids(array(19));
        // you can also use $product->set_tag_ids() for tags, brands etc

        $metaData = [];
        if (!empty($data['metadata'])) {
            $json = \json_decode($data['metadata'], true);

            if (is_array($json)) {
                $metaData = $json;
            }
        }

        if ($product->get_date_created() === null) {
            $product->set_date_created((new DateTimeImmutable())->format('Y-m-d H:i:s'));
        }

        $metaData = $metaData + [
                'import_source' => 'SITEPACK',
                'site' => $data['site'],
                'ean' => $data['ean'],
            ];

        $product->set_meta_data($metaData);

        return $product;
    }

    public function saveProduct(WC_Product_Simple $product): int
    {
        $product->set_date_modified((new DateTimeImmutable())->format('Y-m-d H:i:s'));
        $productId = $product->save();
        // TODO: add filter / remove cache

        return $productId;
    }

    public function findProduct(mixed $productId): WC_Product_Simple
    {
        // TODO: search product

        return new WC_Product_Simple();
    }

}
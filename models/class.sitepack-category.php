<?php

class SitePackCategory implements \JsonSerializable
{
    private $source;
    private $id;
    private $categoryMain;
    private $categorySub;
    private $categorySubSub;
    private $url;

    public function __construct(
        string $source,
        int $id,
        string $categoryMain,
        string $categorySub,
        string $categorySubSub,
        string $url
    ) {
        $this->source = $source;
        $this->id = $id;
        $this->categoryMain = $categoryMain;
        $this->categorySub = $categorySub;
        $this->categorySubSub = $categorySubSub;
        $this->url = $url;
    }

    public static function fromWooCommerce(array $categories, WP_Term $data)
    {
        $parent = null;
        $parentsParent = null;

        if (!empty($data->parent)) {
            $parent = $categories[$data->parent];
        }
        if (!empty($parent->parent)) {
            $parentsParent = $categories[$parent->parent];
        }

        if (!empty($parentsParent) && !empty($parent)) {
            return new SitePackCategory(
                'WOOCOMMERCE',
                $data->term_id,
                $parentsParent->name,
                $parent->name,
                $data->name,
                get_term_link($data)
            );
        }

        if (empty($parentsParent) && !empty($parent)) {
            return new SitePackCategory(
                'WOOCOMMERCE',
                $data->term_id,
                $parent->name,
                $data->name,
                '',
                get_term_link($data)
            );
        }

        return new SitePackCategory(
            'WOOCOMMERCE',
            $data->term_id,
            $data->name,
            '',
            '',
            get_term_link($data)
        );
    }

    public function jsonSerialize()
    {
        return \get_object_vars($this);
    }
}
<?php

class SitePackCategory implements \JsonSerializable
{
    private $id;
    private $name;
    private $source;

    public function __construct($id, $name, $source)
    {
        $this->id = $id;
        $this->name = $name;
        $this->source = $source;
    }

    public static function fromWooCommerce(array $data)
    {
        return new SitePackCategory(
            $data['id'],
            $data['name'],
            'WOOCOMMERCE'
        );
    }

    public function jsonSerialize()
    {
        return \get_object_vars($this);
    }
}
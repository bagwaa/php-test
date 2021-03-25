<?php

namespace App;

class Product implements ProductInterface
{
    protected $sku;
    protected $price;

    public function __construct(string $sku, int $price)
    {
        $this->sku = $sku;
        $this->price = $price;
    }

    public function getSku() : string
    {
        return $this->sku;
    }

    public function getPrice() : int
    {
        return $this->price;
    }
}

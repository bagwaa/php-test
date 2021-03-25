<?php

namespace App;

class Discount
{
    protected $sku;

    protected $quantityDiscountAppliedAt;

    protected $discount;

    public function __construct(string $sku, int $quantityDiscountAppliedAt, int $discount)
    {
        $this->sku = $sku;
        $this->quantityDiscountAppliedAt = $quantityDiscountAppliedAt;
        $this->discount = $discount;
    }
}

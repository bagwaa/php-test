<?php

namespace App;

class Checkout implements CheckoutInterface
{
    /**
     * @var array $cart
     */
    protected $cart = [];

    /**
     * @var array $discounts
     */
    protected $discounts = [];

    /**
     * @var array
     */
    protected $stats = [];

    public function __construct()
    {
        $this->stats = [
            'A' => 0,
            'B' => 0,
            'C' => 0,
            'D' => 0,
        ];

        $this->discounts = [
            'A' => new Discount(3, 20),
            'B' => new Discount(2, 15)
        ];
    }

    /**
     * Adds an item to the checkout
     *
     * @param Product $product
     */
    public function scan(Product $product)
    {
        $this->stats[$product->getSku()]++;

        $this->cart[] = $product;
    }

    /**
     * Calculates the total price of all items in this checkout
     *
     * @return int
     */
    public function total(): int
    {
        $standardPrices = array_reduce($this->cart, function ($total, Product $product) {
            $total += $product->getPrice();
            return $total;
        }) ?? 0;

        $totalDiscount = $this->calculateDiscount();

        return $standardPrices - $totalDiscount;
    }

    /**
     * @return int
     */
    private function calculateDiscount()
    {
        $totalDiscount = 0;

        foreach ($this->discounts as $key => $discount) {
            if ($this->stats[$key] >= $discount->getThreshold()) {
                $numberOfSets = floor($this->stats[$key] / $discount->getThreshold());
                $totalDiscount += ($discount->getAmount() * $numberOfSets);
            }
        }

        return $totalDiscount;
    }
}

<?php

namespace App;

class Checkout implements CheckoutInterface
{
    /**
     * @var int[]
     */
    protected $pricing = [
        'A' => 50,
        'B' => 30,
        'C' => 20,
        'D' => 15
    ];

    protected $discounts = [
        'A' => [3, 20],
        'B' => [2, 15]
    ];

    /**
     * @var array
     */
    protected $cart = [];

    /**
     * Adds an item to the checkout
     *
     * @param $sku string
     */
    public function scan(string $sku)
    {
        // I am checking the SKU exists in our price list first, in reality I would probably raise
        // an exception here so that we can log it and notify an admin if someone has somehow attempted this.
        if (!array_key_exists($sku, $this->pricing)) {
            return;
        }

        $this->cart[] = new Product($sku, $this->pricing[$sku]);
    }

    /**
     * Calculates the total price of all items in this checkout
     *
     * @return int
     */
    public function total(): int
    {
        // I am using the null coalescing operator here, this way if we have no products
        // to iterate through, we return a total of 0 instead of null
        //
        // I am also using array_reduce to essentially reduce the cart down to a single value which
        // represents the total value
        return array_reduce($this->cart, function ($total, Product $product) {
            $total += $product->getPrice();
            return $total;
        }) ?? 0;
    }
}

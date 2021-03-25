<?php

namespace Tests;

use App\Checkout;
use App\Product;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
    public function test_scanning_sku_a_returns_total_of_50()
    {
        $checkout = new Checkout();

        $checkout->scan(new Product('A', 50));

        $this->assertEquals(50, $checkout->total(), 'Checkout total does not equal expected value of 50');
    }

    public function test_an_empty_checkout_returns_a_total_of_zero()
    {
        $checkout = new Checkout();

        $this->assertEquals(0, $checkout->total(), 'Checkout total does not equal expected value of 0');
    }

    /**
     * @dataProvider basketProvider
     */
    public function test_scanning_multiple_skus_returns_the_expected_totals($expectedTotal, $itemsToAdd)
    {
        $checkout = new Checkout();

        array_map(function (Product $product) use ($checkout) {
            $checkout->scan($product);
        }, $itemsToAdd);

        $this->assertEquals(
            $expectedTotal,
            $checkout->total(),
            'Checkout total does not equal expected value of ' . $expectedTotal
        );
    }

    /**
     * Provide various baskets full of items along with what the total of these items should be
     *
     * @return array
     */
    public function basketProvider()
    {
        $product_a = new Product('A', 50);
        $product_b = new Product('B', 30);
        $product_c = new Product('C', 20);
        $product_d = new Product('D', 15);

        return [
            [
                100,
                [$product_a, $product_a]
            ],
            [
                130,
                [$product_a, $product_a, $product_a]
            ],
            [
                130,
                [$product_a, $product_b, $product_a]
            ],
            [
                85,
                [$product_a, $product_c, $product_d]
            ],
        ];
    }

    public function test_the_price_is_discounted_when_ordering_three_times_a()
    {
        $checkout = new Checkout();

        $product_a = new Product('A', 50);

        $checkout->scan($product_a);
        $checkout->scan($product_a);
        $checkout->scan($product_a);

        $this->assertEquals(130, $checkout->total(), 'Checkout total does not equal expected value of 130');
    }

    public function test_the_price_is_discounted_multiple_times_when_ordering_six_times_a()
    {
        $checkout = new Checkout();

        $product_a = new Product('A', 50);

        $checkout->scan($product_a);
        $checkout->scan($product_a);
        $checkout->scan($product_a);

        $checkout->scan($product_a);
        $checkout->scan($product_a);
        $checkout->scan($product_a);

        $this->assertEquals(260, $checkout->total(), 'Checkout total does not equal expected value of 260');
    }

    public function test_the_price_is_discounted_multiple_times_when_ordering_seven_times_a()
    {
        $checkout = new Checkout();

        $product_a = new Product('A', 50);

        $checkout->scan($product_a);
        $checkout->scan($product_a);
        $checkout->scan($product_a);

        $checkout->scan($product_a);
        $checkout->scan($product_a);
        $checkout->scan($product_a);

        $checkout->scan($product_a);

        $this->assertEquals(310, $checkout->total(), 'Checkout total does not equal expected value of 310');
    }

    public function test_the_price_is_discounted_when_ordering_two_times_b()
    {
        $checkout = new Checkout();

        $product_b = new Product('B', 30);

        $checkout->scan($product_b);
        $checkout->scan($product_b);

        $this->assertEquals(45, $checkout->total(), 'Checkout total does not equal expected value of 45');
    }
}

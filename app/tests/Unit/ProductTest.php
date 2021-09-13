<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Product;

class ProductTest extends TestCase
{
    protected $product;

    protected function setUp(): void
    {
        $this->product = new Product('Fallout 4', 59);
    }

    function test_a_product_has_a_name()
    {
        $this->assertEquals('Fallout 4', $this->product->name());
    }

    function test_a_product_has_a_cost()
    {
        $this->assertEquals(59, $this->product->cost());
    }
}

<?php

namespace Tests\Unit\Models\Products;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_it_uses_the_slug_for_the_route_key_name(): void
    {
        $product = new Product();

        $this->assertEquals('slug', $product->getRouteKeyName());
    }
}

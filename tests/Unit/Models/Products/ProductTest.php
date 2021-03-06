<?php

namespace Tests\Unit\Models\Products;

use App\Cart\Money;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Stock;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_it_uses_the_slug_for_the_route_key_name(): void
    {
        $product = new Product();

        $this->assertEquals('slug', $product->getRouteKeyName());
    }

    public function test_it_has_many_categories(): void
    {
        $product = Product::factory()->create();

        $product->categories()->save(
            Category::factory()->create()
        );

        $this->assertInstanceOf(Category::class, $product->categories->first());
    }

    public function test_it_has_many_variations(): void
    {
        $product = Product::factory()->create();

        $product->variations()->save(
            ProductVariation::factory()->create()
        );

        $this->assertInstanceOf(ProductVariation::class, $product->variations->first());
    }

    public function test_it_returns_a_money_instance_for_the_price(): void
    {
        $product = Product::factory()->create();

        $this->assertInstanceOf(Money::class, $product->price);
    }

    public function test_it_returns_a_formatted_price(): void
    {
        $product = Product::factory()->create([
            'price' => 1000
        ]);

        $this->assertEquals($product->formattedPrice, '£10.00');
    }

    public function test_it_can_check_if_its_in_stock(): void
    {
        $product = Product::factory()->create();

        $product->variations()->save(
            $variation = ProductVariation::factory()->create()
        );

        $variation->stocks()->save(
            Stock::factory()->make()
        );

        $this->assertTrue((bool) $product->inStock());
    }

    public function test_it_can_get_the_stock_count(): void
    {
        $product = Product::factory()->create();

        $product->variations()->save(
            $variation = ProductVariation::factory()->create()
        );

        $variation->stocks()->save(
            Stock::factory()->make([
                'quantity' => $quantity = 5
            ])
        );

        $this->assertEquals($product->stockCount(), $quantity);
    }
}

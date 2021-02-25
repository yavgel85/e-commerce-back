<?php

namespace Tests\Unit\Models\Products;

use App\Cart\Money;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use App\Models\Stock;
use Tests\TestCase;

class ProductVariationTest extends TestCase
{
    public function test_it_has_one_variation_type(): void
    {
        $variation = ProductVariation::factory()->create();

        $this->assertInstanceOf(ProductVariationType::class, $variation->type);
    }

    public function test_it_belongs_to_a_product(): void
    {
        $variation = ProductVariation::factory()->create();

        $this->assertInstanceOf(Product::class, $variation->product);
    }

    public function test_it_returns_a_money_instance_for_the_price(): void
    {
        $variation = ProductVariation::factory()->create();

        $this->assertInstanceOf(Money::class, $variation->price);
    }

    public function test_it_returns_a_formatted_price(): void
    {
        $variation = ProductVariation::factory()->create([
            'price' => 1000
        ]);

        $this->assertEquals($variation->formattedPrice, '£10.00');
    }

    public function test_it_returns_the_product_price_if_price_is_null(): void
    {
        $product = Product::factory()->create([
            'price' => 1000
        ]);

        $variation = ProductVariation::factory()->create([
            'price' => null,
            'product_id' => $product->id
        ]);

        $this->assertEquals($product->price->amount(), $variation->price->amount());
    }

    public function test_it_can_check_if_the_variation_price_is_different_to_the_product(): void
    {
        $product = Product::factory()->create([
            'price' => 1000
        ]);

        $variation = ProductVariation::factory()->create([
            'price' => 2000,
            'product_id' => $product->id
        ]);

        $this->assertTrue($variation->priceVaries());
    }

    public function test_it_has_many_stocks(): void
    {
        $variation = ProductVariation::factory()->create();

        $variation->stocks()->save(
            Stock::factory()->make()
        );

        $this->assertInstanceOf(Stock::class, $variation->stocks->first());
    }

    public function test_it_has_stock_information(): void
    {
        $variation = ProductVariation::factory()->create();

        $variation->stocks()->save(
            Stock::factory()->make()
        );

        $this->assertInstanceOf(ProductVariation::class, $variation->stock->first());
    }

    public function test_it_has_stock_count_pivot_within_stock_information(): void
    {
        $variation = ProductVariation::factory()->create();

        $variation->stocks()->save(
            Stock::factory()->make([
                'quantity' => $quantity = 5
            ])
        );

        $this->assertEquals($variation->stock->first()->pivot->stock, $quantity);
    }

    public function test_it_has_in_stock_pivot_within_stock_information(): void
    {
        $variation = ProductVariation::factory()->create();

        $variation->stocks()->save(
            Stock::factory()->make()
        );

        $this->assertTrue((bool) $variation->stock->first()->pivot->in_stock);
        //$this->assertSame(1, $variation->stock->first()->pivot->in_stock);
    }

    public function test_it_can_check_if_its_in_stock(): void
    {
        $variation = ProductVariation::factory()->create();

        $variation->stocks()->save(
            Stock::factory()->make()
        );

        $this->assertTrue((bool) $variation->inStock());
    }

    public function test_it_can_get_stock_count(): void
    {
        $variation = ProductVariation::factory()->create();

        $variation->stocks()->save(
            Stock::factory()->make([
                'quantity' => 5
            ])
        );

        $variation->stocks()->save(
            Stock::factory()->make([
                'quantity' => 5
            ])
        );

        $this->assertEquals($variation->stockCount(), 10);
    }

//    public function test_it_can_get_the_minimum_stock_for_a_given_value(): void
//    {
//        $variation = ProductVariation::factory()->create();
//
//        $variation->stocks()->save(
//            Stock::factory()->make([
//                'quantity' => $quantity = 5
//            ])
//        );
//
//        $this->assertEquals($variation->minStock(200), $quantity);
//    }
}

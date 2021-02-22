<?php

namespace Tests\Feature\Products;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductScopingTest extends TestCase
{
    public function test_it_can_scope_by_category(): void
    {
        $product = Product::factory()->create();

        $product->categories()->save(
            $category = Category::factory()->create()
        );

        $anotherProduct = Product::factory()->create();

        $this->json('GET', "api/products?category={$category->slug}")
            ->assertJsonCount(1, 'data');
    }
}

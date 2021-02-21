<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    public function test_it_shows_a_collection_of_products(): void
    {
        $product = Product::factory()->create();

        $this->json('GET', 'api/products')
            ->assertJsonFragment([
                'id' => $product->id
            ]);
    }

    public function test_it_has_paginated_data(): void
    {
        $this->json('GET', 'api/products')
            ->assertJsonStructure([
                'meta'
            ]);
    }
}

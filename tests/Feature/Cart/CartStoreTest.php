<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\User;
use Tests\TestCase;

class CartStoreTest extends TestCase
{
    public function test_it_fails_if_unauthenticated(): void
    {
        $this->json('POST', 'api/cart')
            ->assertStatus(401);
    }

    public function test_it_requires_products(): void
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', 'api/cart')
            ->assertJsonValidationErrors(['products']);
    }

    public function test_it_requires_products_to_be_an_array(): void
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', 'api/cart', [
            'products' => 1
        ])
            ->assertJsonValidationErrors(['products']);
    }

    public function test_it_requires_products_to_have_an_id(): void
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', 'api/cart', [
            'products' => [
                ['quantity' => 1]
            ]
        ])
            ->assertJsonValidationErrors(['products.0.id']);
    }

    public function test_it_requires_products_to_exist(): void
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', 'api/cart', [
            'products' => [
                ['id' => 1, 'quantity' => 1]
            ]
        ])
            ->assertJsonValidationErrors(['products.0.id']);
    }

    public function test_it_requires_products_quantity_to_be_numeric(): void
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', 'api/cart', [
            'products' => [
                ['id' => 1, 'quantity' => 'one']
            ]
        ])
            ->assertJsonValidationErrors(['products.0.quantity']);
    }

    public function test_it_requires_products_quantity_to_be_at_least_one(): void
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', 'api/cart', [
            'products' => [
                ['id' => 1, 'quantity' => 0]
            ]
        ])
            ->assertJsonValidationErrors(['products.0.quantity']);
    }

    public function test_it_can_add_products_to_the_users_cart(): void
    {
        $user = User::factory()->create();

        $product = ProductVariation::factory()->create();

        $this->jsonAs($user, 'POST', 'api/cart', [
            'products' => [
                ['id' => $product->id, 'quantity' => 2]
            ]
        ]);

        $this->assertDatabaseHas('cart_user', [
            'product_variation_id' => $product->id,
            'quantity' => 2
        ]);
    }
}

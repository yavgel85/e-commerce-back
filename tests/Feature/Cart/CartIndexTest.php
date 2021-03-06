<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\ShippingMethod;
use App\Models\User;
use Tests\TestCase;

class CartIndexTest extends TestCase
{
    public function test_it_fails_if_unauthenticated(): void
    {
        $this->json('GET', 'api/cart')
            ->assertStatus(401);
    }

    public function test_it_shows_products_in_the_user_cart(): void
    {
        $user = User::factory()->create();

        $user->cart()->sync(
            $product = ProductVariation::factory()->create()
        );

        $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'id' => $product->id
            ]);
    }

    public function test_it_shows_if_the_cart_is_empty(): void
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'empty' => true
            ]);
    }

    public function test_it_shows_a_formatted_subtotal(): void
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'subtotal' => '£0.00'
            ]);
    }

    public function test_it_shows_a_formatted_total(): void
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'total' => '£0.00'
            ]);
    }

    public function test_it_syncs_the_cart(): void
    {
        $user = User::factory()->create();

        $user->cart()->attach(
            $product = ProductVariation::factory()->create(), [
                'quantity' => 2
            ]
        );

        $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'changed' => true
            ]);
    }

    public function test_it_shows_a_formatted_total_with_shipping(): void
    {
        $user = User::factory()->create();

        $shipping = ShippingMethod::factory()->create([
            'price' => 1000
        ]);

        $this->jsonAs($user, 'GET', "api/cart?shipping_method_id={$shipping->id}")
            ->assertJsonFragment([
                'total' => '£10.00'
            ]);
    }
}

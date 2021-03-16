<?php

namespace Tests\Feature\PaymentMethods;

use App\Models\User;
use Tests\TestCase;

class PaymentMethodStoreTest extends TestCase
{
    public function test_it_fails_if_not_authenticated(): void
    {
        $this->json('POST', 'api/payment-methods')
            ->assertStatus(401);
    }

    public function test_it_require_a_token(): void
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', 'api/payment-methods')
            ->assertJsonValidationErrors(['token']);
    }

    public function test_it_can_successfully_add_a_card(): void
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', 'api/payment-methods', [
            'token' => 'tok_visa'
        ]);

        $this->assertDatabaseHas('payment_methods', [
            'user_id' => $user->id,
            'card_type' => 'Visa',
            'last_four' => '4242'
        ]);
    }

    public function test_it_returns_the_created_card(): void
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', 'api/payment-methods', [
            'token' => 'tok_visa'
        ])
            ->assertJsonFragment([
                'card_type' => 'Visa'
            ]);
    }

    public function test_it_sets_the_created_card_as_default(): void
    {
        $user = User::factory()->create();

        $response = $this->jsonAs($user, 'POST', 'api/payment-methods', [
            'token' => 'tok_visa'
        ]);

        $this->assertDatabaseHas('payment_methods', [
            'id' => json_decode($response->getContent())->data->id,
            'default' => true
        ]);
    }
}

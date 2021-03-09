<?php

namespace Tests\Feature\Addresses;

use App\Models\Address;
use App\Models\Country;
use App\Models\ShippingMethod;
use App\Models\User;
use Tests\TestCase;

class AddressShippingTest extends TestCase
{
    public function test_it_fails_if_the_user_is_not_authenticated(): void
    {
        $this->json('GET', 'api/addresses/1/shipping')
            ->assertStatus(401);
    }

    public function test_it_fails_if_the_address_cant_be_found(): void
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'GET', 'api/addresses/1/shipping')
            ->assertStatus(404);
    }

    public function test_it_fails_if_the_address_does_not_belong_to_the_user(): void
    {
        $user = User::factory()->create();

        $address = Address::factory()->create([
            'user_id' => User::factory()->create()->id
        ]);

        $this->jsonAs($user, 'GET', "api/addresses/{$address->id}/shipping")
            ->assertStatus(403);
    }

    public function test_it_shows_shipping_methods_for_the_given_address(): void
    {
        $user = User::factory()->create();

        $address = Address::factory()->create([
            'user_id' => $user->id,
            'country_id' => ($country = Country::factory()->create())->id
        ]);

        $country->shippingMethods()->save(
            $shipping = ShippingMethod::factory()->create()
        );

        $this->jsonAs($user, 'GET', "api/addresses/{$address->id}/shipping")
            ->assertJsonFragment([
                'id' => $shipping->id
            ]);
    }
}

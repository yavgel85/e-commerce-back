<?php

namespace Tests\Feature\Countries;

use App\Models\Country;
use Tests\TestCase;

class CountryIndexTest extends TestCase
{
    public function test_it_returns_countries(): void
    {
        $country = Country::factory()->create();

        $this->json('GET', 'api/countries')
            ->assertJsonFragment([
                'id' => $country->id
            ]);
    }
}

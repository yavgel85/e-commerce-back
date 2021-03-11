<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountryShippingMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Country::findOrFail(235)->shippingMethods()->sync([2, 3]);
        Country::findOrFail(236)->shippingMethods()->sync(1);
    }
}

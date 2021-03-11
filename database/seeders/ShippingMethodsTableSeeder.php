<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;

class ShippingMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $shippingMethods = [
            [
                'id'   => 1,
                'name' => 'UPS',
                'price' => 1000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'   => 2,
                'name' => 'Royal Mail 1st Class',
                'price' => 1100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'   => 3,
                'name' => 'Royal Mail 2nd Class',
                'price' => 550,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        ShippingMethod::insert($shippingMethods);
    }
}

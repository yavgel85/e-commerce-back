<?php

namespace Database\Seeders;

use App\Models\ProductVariationType;
use Illuminate\Database\Seeder;

class ProductVariationTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $productVariationTypes = [
            [
                'id'   => 1,
                'name' => 'Ground',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'   => 2,
                'name' => 'Whole bean',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        ProductVariationType::insert($productVariationTypes);
    }
}

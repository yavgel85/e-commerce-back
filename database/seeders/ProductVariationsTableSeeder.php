<?php

namespace Database\Seeders;

use App\Models\ProductVariation;
use Illuminate\Database\Seeder;

class ProductVariationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $productVariations = [
            [
                'id' => 1,
                'product_id' => 1,
                'product_variation_type_id' => 1,
                'name' => '250g',
                'price' => null,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'product_id' => 1,
                'product_variation_type_id' => 1,
                'name' => '500g',
                'price' => 1500,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'product_id' => 1,
                'product_variation_type_id' => 1,
                'name' => '1kg',
                'price' => 2000,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'product_id' => 1,
                'product_variation_type_id' => 2,
                'name' => '250g',
                'price' => null,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'product_id' => 1,
                'product_variation_type_id' => 2,
                'name' => '500g',
                'price' => 1500,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'product_id' => 1,
                'product_variation_type_id' => 2,
                'name' => '1kg',
                'price' => 2000,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        ProductVariation::insert($productVariations);
    }
}

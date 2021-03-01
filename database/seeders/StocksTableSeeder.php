<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Seeder;

class StocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $stocks = [
            [
                'id' => 1,
                'quantity' => 10,
                'product_variation_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'quantity' => 15,
                'product_variation_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'quantity' => 25,
                'product_variation_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Stock::insert($stocks);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            CategoriesTableSeeder::class,
            ProductsTableSeeder::class,
            CategoryProductTableSeeder::class,
            ProductVariationTypesTableSeeder::class,
            ProductVariationsTableSeeder::class,
            StocksTableSeeder::class,
            UsersTableSeeder::class,
            CountriesTableSeeder::class,
            AddressesTableSeeder::class,
        ]);
    }
}

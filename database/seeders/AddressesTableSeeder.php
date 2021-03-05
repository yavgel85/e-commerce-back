<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //\App\Models\Address::factory(10)->create();
        $addresses = [
            [
                'id'          => 1,
                'user_id'     => 1,
                'country_id'  => 233,
                'name'        => 'Eugene Yavgel',
                'address_1'   => 'Teatralnaya',
                'city'        => 'Kiev',
                'postal_code' => 21056897,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        Address::insert($addresses);
    }
}

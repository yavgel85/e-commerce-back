<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'id'          => 1,
                'user_id'     => 1,
                'card_type'   => 'Visa',
                'last_four'   => '4242',
                'default'     => true,
                'provider_id' => Str::random(10),
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        PaymentMethod::insert($paymentMethods);
    }
}

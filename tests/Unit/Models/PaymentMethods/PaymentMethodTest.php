<?php

namespace Tests\Unit\Models\PaymentMethods;

use App\Models\PaymentMethod;
use App\Models\User;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    public function test_it_belongs_to_a_user(): void
    {
        $paymentMethod = PaymentMethod::factory()->create([
            'user_id' => User::factory()->create()->id
        ]);

        $this->assertInstanceOf(User::class, $paymentMethod->user);
    }

    public function test_it_sets_old_payment_method_to_not_default_when_creating(): void
    {
        $user = User::factory()->create();

        $oldPaymentMethod = PaymentMethod::factory()->create([
            'default' => true,
            'user_id' => $user->id
        ]);

        PaymentMethod::factory()->create([
            'default' => true,
            'user_id' => $user->id
        ]);

        $this->assertFalse((bool) $oldPaymentMethod->fresh()->default);
    }
}

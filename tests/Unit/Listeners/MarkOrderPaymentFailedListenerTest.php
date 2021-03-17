<?php

namespace Tests\Unit\Listeners;

use App\Events\Order\OrderPaymentFailed;
use App\Listeners\Order\MarkOrderPaymentFailed;
use App\Models\Order;
use App\Models\User;
use Tests\TestCase;

class MarkOrderPaymentFailedListenerTest extends TestCase
{
    public function test_it_marks_order_as_payment_failed(): void
    {
        $event = new OrderPaymentFailed(
            $order = Order::factory()->create([
                'user_id' => User::factory()->create()
            ])
        );

        $listener = new MarkOrderPaymentFailed();

        $listener->handle($event);

        $this->assertEquals($order->fresh()->status, Order::PAYMENT_FAILED);
    }
}

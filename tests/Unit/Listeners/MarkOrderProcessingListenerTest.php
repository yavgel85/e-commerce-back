<?php

namespace Tests\Unit\Listeners;

use App\Events\Order\OrderPaid;
use App\Listeners\Order\MarkOrderProcessing;
use App\Models\Order;
use App\Models\User;
use Tests\TestCase;

class MarkOrderProcessingListenerTest extends TestCase
{
    public function test_it_marks_order_as_processing(): void
    {
        $event = new OrderPaid(
            $order = Order::factory()->create([
                'user_id' => User::factory()->create()
            ])
        );

        $listener = new MarkOrderProcessing();

        $listener->handle($event);

        $this->assertEquals($order->fresh()->status, Order::PROCESSING);
    }
}

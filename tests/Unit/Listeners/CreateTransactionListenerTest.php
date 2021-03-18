<?php

namespace Tests\Unit\Listeners;

use App\Events\Order\OrderPaid;
use App\Listeners\Order\CreateTransaction;
use App\Models\Order;
use App\Models\User;
use Tests\TestCase;

class CreateTransactionListenerTest extends TestCase
{
    public function test_it_creates_a_transaction(): void
    {
        $event = new OrderPaid(
            $order = Order::factory()->create([
                'user_id' => User::factory()->create()
            ])
        );

        $listener = new CreateTransaction();

        $listener->handle($event);

        $this->assertDatabaseHas('transactions', [
            'order_id' => $order->id,
            'total'    => $order->total()->amount()
        ]);
    }
}

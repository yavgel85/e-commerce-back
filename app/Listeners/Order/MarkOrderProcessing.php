<?php

namespace App\Listeners\Order;

use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MarkOrderProcessing
{
    /**
     * Handle the event.
     *
     * @param $event
     */
    public function handle($event): void
    {
        $event->order->update([
            'status' => Order::PROCESSING,
        ]);
    }
}

<?php

namespace App\Listeners\Order;

use App\Cart\Payments\Gateway;
use App\Events\Order\OrderCreated;
use App\Events\Order\OrderPaid;
use App\Events\Order\OrderPaymentFailed;
use App\Exceptions\PaymentFailedException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessPayment implements ShouldQueue
{
    protected Gateway $gateway;

    /**
     * Create the event listener.
     *
     * @param Gateway $gateway
     */
    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Handle the event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;

        try {
            $this->gateway->withUser($order->user)
                ->getCustomer()
                ->charge(
                    $order->paymentMethod, $order->total()->amount()
                );

            event(new OrderPaid($order));
        } catch (PaymentFailedException $e) {
            event(new OrderPaymentFailed($order));
        }
    }
}

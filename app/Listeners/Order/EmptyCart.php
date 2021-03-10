<?php

namespace App\Listeners\Order;

use App\Cart\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmptyCart
{
    protected Cart $cart;

    /**
     * Create the event listener.
     *
     * @param Cart $cart
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->cart->empty();
    }
}

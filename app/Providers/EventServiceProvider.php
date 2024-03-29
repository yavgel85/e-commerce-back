<?php

namespace App\Providers;

use App\Events\Order\OrderCreated;
use App\Events\Order\OrderPaid;
use App\Events\Order\OrderPaymentFailed;
use App\Listeners\Order\CreateTransaction;
use App\Listeners\Order\EmptyCart;
use App\Listeners\Order\MarkOrderPaymentFailed;
use App\Listeners\Order\MarkOrderProcessing;
use App\Listeners\Order\ProcessPayment;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderCreated::class => [
            ProcessPayment::class,
            EmptyCart::class,
        ],
        OrderPaymentFailed::class => [
            MarkOrderPaymentFailed::class,
        ],
        OrderPaid::class => [
            CreateTransaction::class,
            MarkOrderProcessing::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

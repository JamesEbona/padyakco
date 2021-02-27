<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use App\Events\NewOrderEvent;
use App\Events\OrderShippedEvent;
use App\Events\OrderCancelledEvent;
use App\Events\OrderDeliveredEvent;
// use App\Listeners\SendNewOrderNotification;
use App\Listeners\SendMemberInvoice;
use App\Listeners\SendShippedOrderNotification;
use App\Listeners\SendCancelledOrderNotification;
use App\Listeners\SendDeliveredOrderNotification;
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
        NewOrderEvent::class => [
            SendMemberInvoice::class,
        ],
        OrderShippedEvent::class => [
            SendShippedOrderNotification::class,
        ],
        OrderCancelledEvent::class => [
            SendCancelledOrderNotification::class,
        ],
        OrderDeliveredEvent::class => [
            SendDeliveredOrderNotification::class,
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

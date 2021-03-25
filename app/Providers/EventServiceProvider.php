<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use App\Events\BookingConfirmedEvent;
use App\Events\BookingEnRouteEvent;
use App\Events\BookingDoneEvent;
use App\Events\BookingPaymentEvent;
use App\Events\BookingCancelledEvent;
use App\Events\NewBookingEvent;
use App\Events\NewOrderEvent;
use App\Events\OrderShippedEvent;
use App\Events\OrderCancelledEvent;
use App\Events\OrderDeliveredEvent;
use App\Events\InquiryReplyEvent;
use App\Events\MechanicAssignEvent;
use App\Events\MechanicUnassignEvent;
// use App\Listeners\SendNewOrderNotification;
use App\Listeners\SendBookingConfirmedNotification;
use App\Listeners\SendBookingDoneNotification;
use App\Listeners\SendBookingPaymentNotification;
use App\Listeners\SendBookingEnRouteNotification;
use App\Listeners\SendBookingCancelledNotification;
use App\Listeners\SendNewBookingAdminNotification;
use App\Listeners\SendMemberInvoice;
use App\Listeners\SendShippedOrderNotification;
use App\Listeners\SendCancelledOrderNotification;
use App\Listeners\SendInquiryReplyNotification;
use App\Listeners\SendDeliveredOrderNotification;
use App\Listeners\SendMechanicAssignNotification;
use App\Listeners\SendMechanicUnassignNotification;
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
        BookingConfirmedEvent::class => [
            SendBookingConfirmedNotification::class,
        ],
        BookingEnRouteEvent::class => [
            SendBookingEnRouteNotification::class,
        ],
        BookingCancelledEvent::class => [
            SendBookingCancelledNotification::class,
        ],
        BookingPaymentEvent::class => [
            SendBookingPaymentNotification::class,
        ],
        BookingDoneEvent::class => [
            SendBookingDoneNotification::class,
        ],
        InquiryReplyEvent::class => [
            SendInquiryReplyNotification::class,
        ],
        MechanicAssignEvent::class => [
            SendMechanicAssignNotification::class,
        ],
        MechanicUnassignEvent::class => [
            SendMechanicUnassignNotification::class,
        ],
        NewBookingEvent::class => [
            SendNewBookingAdminNotification::class,
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

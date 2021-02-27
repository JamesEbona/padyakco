<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\OrderDelivered;
use Illuminate\Support\Facades\Mail;

class SendDeliveredOrderNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->order->email)->send(new OrderDelivered($event->order));
    }
}

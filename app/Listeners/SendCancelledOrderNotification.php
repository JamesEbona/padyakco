<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\OrderCancelled;
use Illuminate\Support\Facades\Mail;

class SendCancelledOrderNotification implements ShouldQueue
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
        Mail::to($event->order->email)->send(new OrderCancelled($event->order));
    }
}

<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\BookingConfirmed;
use Illuminate\Support\Facades\Mail;

class SendBookingConfirmedNotification implements ShouldQueue
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
        Mail::to($event->booking->user->email)->send(new BookingConfirmed($event->booking));
    }
}

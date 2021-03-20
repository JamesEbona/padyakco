<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\BookingAdminNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SendNewBookingAdminNotification implements ShouldQueue
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
        $admins = User::where('role',1)->where('status','active')->get();

        Mail::to($admins)->send(new BookingAdminNotification($event->booking));
    }
}

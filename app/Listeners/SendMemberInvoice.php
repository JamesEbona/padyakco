<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\OrderReceipt;
use App\Mail\OrderAdminNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\User;


class SendMemberInvoice implements ShouldQueue
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
        Mail::to($event->order->email)->send(new OrderReceipt($event->order));

        $admins = User::where('role',1)->where('status','active')->get();

        Mail::to($admins)->send(new OrderAdminNotification($event->order));
    }
}

<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\InquiryReply;
use Illuminate\Support\Facades\Mail;
use App\Models\Inquiry;

class SendInquiryReplyNotification implements ShouldQueue
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

        Mail::to($event->inquiry->email)->send(new InquiryReply($event->inquiry,$event->subject,$event->reply));
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryReply extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $reply;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inquiry,$subject,$reply)
    {
        $this->inquiry = $inquiry;
        $this->reply = $reply;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('emails.inquiries.reply');
    }
}

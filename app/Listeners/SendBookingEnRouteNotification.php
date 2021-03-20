<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\BookingEnRoute;
use Illuminate\Support\Facades\Mail;
use Config;

class SendBookingEnRouteNotification implements ShouldQueue
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
        Mail::to($event->booking->user->email)->send(new BookingEnRoute($event->booking));

        $number = $event->booking->phone_number;
        $date = date_format($event->booking->booking_time,"d M, Y H:i");
        $message = "Your Padyak.Co mechanic (".$event->booking->mechanic->first_name." ".$event->booking->mechanic->last_name.") for booking #".$event->booking->id." is en route:\nSchedule: ".$date;
        $apicode = config('itexmo.code2');
        $passwd = config('itexmo.password2');
        $url = 'https://www.itexmo.com/php_api/api.php';
		$itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
		$param = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($itexmo),
			),
		);
		$context  = stream_context_create($param);
		return file_get_contents($url, false, $context);
    }
}

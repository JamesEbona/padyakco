<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;
use App\Events\BookingCancelledEvent;

class CancelPendingBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel:booking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel pending bookings 2 hours past schedule';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        echo "cron job ran!\n";
        $nowDate = Carbon::now();
        $bookings = Booking::where('status','pending')->get();
        echo "time right now is:".$nowDate."\n";

        foreach($bookings as $booking){
            echo "======= new booking found =======\n";  
            $pastSchedule = $booking->booking_time->addHours(2);
            echo "booking past sched is:".$pastSchedule."\n";
            if($pastSchedule <= $nowDate){
                $booking->status = "cancelled";
                $booking->save();
                event(new BookingCancelledEvent($booking)); 
                echo "pending booking cancelled\n";    
            }
        }
        echo "cron job finished!\n";

        return 0;
    }
}

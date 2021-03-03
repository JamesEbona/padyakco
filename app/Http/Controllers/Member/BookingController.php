<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Repair;
use App\Models\Booking;
use App\Rules\verify_booking_region;
use Carbon\Carbon;


class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','member','active']);
    }

    public function index()
    {
        $nowDate = Carbon::now();
        $minDate = $nowDate->format('Y-m-d\TH:i');
        $maxDate = $nowDate->addWeeks(1)->format('Y-m-d\TH:i');
        $repair = Repair::where('id',1)->firstOrFail();
        return view('member.Book',compact('minDate','maxDate','repair'));
    }

    public function book(Request $request){

        $nowDate = Carbon::now();
        $minDate = $nowDate->format('Y-m-d\TH:i');
        $maxDate = $nowDate->addWeeks(1)->format('Y-m-d\TH:i');
        
        $request->validate([
            'location' => ['required','string','max:100'],
            'region' => ['nullable', new verify_booking_region()],
            'booking_time' => ['required','date_format:Y-m-d\TH:i','before_or_equal:'.$maxDate.',after_or_equal:'.$minDate],
            'repair_type' => ['required','string','regex:/^[a-zA-Z ]*$/','max:20'],
            'phone_number' => array('required','regex:/^(09|\+639)\d{9}$/'),
            'notes' => ['nullable','string','max:1000'],    
        ]);

        $repair_fee = 0;
        $transportation_fee = 0;
        $total_fee = 0;

        $repair = Repair::where('id',1)->firstOrFail();

        if(request('repair_type') == "Basic"){
            $repair_fee = $repair->basic_fee;
        }
        else if(request('repair_type') == "Expert"){
            $repair_fee = $repair->expert_fee;
        }
        else if(request('repair_type') == "Upgrade"){
            $repair_fee = $repair->upgrade_fee;
        }


        if(request('city') == 'Caloocan'){
            $transportation_fee = $repair->caloocan_fee;
        }
        else if(request('city') == 'Malabon'){
            $transportation_fee = $repair->malabon_fee;
        }
        else if(request('city') == 'Navotas City'){
            $transportation_fee = $repair->navotas_fee;
        }
        else if(request('city') == 'Valenzuela'){
            $transportation_fee = $repair->valenzuela_fee;
        }
        else if(request('city') == 'Quezon City'){
            $transportation_fee = $repair->quezon_fee;
        }
        else if(request('city') == 'Marikina'){
            $transportation_fee = $repair->marikina_fee;
        }
        else if(request('city') == 'Pasig'){
            $transportation_fee = $repair->pasig_fee;
        }
        else if(request('city') == 'Taguig'){
            $transportation_fee = $repair->taguig_fee;
        }
        else if(request('city') == 'Makati'){
            $transportation_fee = $repair->makati_fee;
        }
        else if(request('city') == 'Mandaluyong'){
            $transportation_fee = $repair->mandaluyong_fee;
        }
        else if(request('city') == 'San Juan'){
            $transportation_fee = $repair->sanjuan_fee;
        }
        else if(request('city') == 'Parañaque'){
            $transportation_fee = $repair->paranaque_fee;
        }
        else if(request('city') == 'Las Piñas'){
            $transportation_fee = $repair->laspinas_fee;
        }
        else if(request('city') == 'Muntinlupa City'){
            $transportation_fee = $repair->muntinlupa_fee;
        }
        else if(request('city') == 'Manila'){
            $transportation_fee = $repair->manila_fee;
        }

        $total_fee = $repair_fee + $transportation_fee;

        $booking = new Booking;
        $booking->user_id = auth()->id();
        $booking->first_name = auth()->user()->first_name;
        $booking->last_name = auth()->user()->last_name;
        $booking->phone_number = request('phone_number');
        $booking->repair_type = request('repair_type');
        $booking->location = request('location');
        $booking->booking_time = request('booking_time');
        $booking->longhitude = request('longhitude');
        $booking->latitude = request('latitude');
        $booking->notes = request('notes');
        $booking->repair_fee = $repair_fee;
        $booking->transportation_fee = $transportation_fee;
        $booking->total_fee = $total_fee;
        $booking->status = 'pending';
        $booking->save();
        
        return redirect("/member/book")->with('message', 'Mechanic booked! Please wait for an email about the booking confirmation.');
    }

    public function view()
    {
        $bookings = Booking::where('user_id',auth()->id())->orderBy('created_at', 'desc')->paginate(5);
        return view('member.Bookings', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::where('user_id',auth()->id())->where('id',$id)->firstOrFail();
        return view('member.Booking', compact('booking'));
    }

}

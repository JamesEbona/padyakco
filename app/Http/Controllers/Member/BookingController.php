<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Repair;
use App\Models\Booking;
use App\Rules\verify_booking_region;
use App\Rules\check_active_booking;
use Carbon\Carbon;
use App\Events\BookingCancelledEvent;
use App\Events\NewBookingEvent;
use App\Events\BookingDoneEvent;
use App\Models\BookingDaySales;
use App\Models\BookingMonthSales;
use App\Models\BookingYearSales;
use App\Models\Coupon;


class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','member','active']);
    }

    public function index()
    {
        $nowDate = Carbon::now();
        $minDate = $nowDate->addHour()->format('Y-m-d\TH:i');
        $maxDate = $nowDate->addWeeks(1)->format('Y-m-d\TH:i');
        $repair = Repair::where('id',1)->firstOrFail();
        return view('member.Book',compact('minDate','maxDate','repair'));
    }

    public function book(Request $request){
      
        $nowDate = Carbon::now();
        $minDate = $nowDate->addHour()->format('Y-m-d\TH:i');
        $maxDate = $nowDate->addWeeks(1)->format('Y-m-d\TH:i');
        
        
        $request->validate([
            'location' => ['required','string','max:500'],
            'region' => ['nullable', new verify_booking_region()],
            'booking_time' => ['required','date_format:Y-m-d\TH:i','before_or_equal:'.$maxDate.'','after_or_equal:'.$minDate],
            'repair_type' => ['required','string','regex:/^[a-zA-Z ]*$/','max:20'],
            'phone_number' => array('required','regex:/^(09|\+639)\d{9}$/'),
            'notes' => ['nullable','string','max:1000'],  
            'memberId' => ['required', new check_active_booking()],  
        ]);

         // $result = Booking::where('status','!=','cancelled')->where('status','!=','done')->where('user_id', auth()->id())->get();
        // if (isset($result)) {
        //    return response()->json(['errors'=>$validator->errors()->all()]); 
        // }

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
        else if(request('city') == 'Navotas'){
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
        else if(request('city') == 'Muntinlupa'){
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

        event(new NewBookingEvent($booking));
        
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

    public function cancel($id)
    {
        $booking = Booking::where('user_id',auth()->id())->where('id',$id)->where('status', '=', 'pending')->firstOrFail();
        $booking->status = "cancelled";
        $booking->save();
        event(new BookingCancelledEvent($booking));  

        return redirect("/member/book/mybookings")->with('message', 'Your booking has been cancelled.');
        
    }

    public function pay(Request $request)
    {
        $booking = Booking::where('user_id',auth()->id())->where('id',request('bookingId'))->firstOrFail();
        $booking->status = "done";
        $booking->save();

        event(new BookingDoneEvent($booking)); 
        $nowDate = \Carbon\Carbon::now();
        $bookingDay = $nowDate->format('d');
        $bookingMonth = $nowDate->format('F');
        $bookingYear = $nowDate->format('Y');

        if($bookingDay == 01){
            BookingDaySales::query()->update(['after' => 1]);
        }
        $bookingDaySales = BookingDaySales::firstOrNew(['day' =>  $bookingDay]);
        $bookingDaySales->profit += $booking->total_fee;
        $bookingDaySales->after = 0;
        $bookingDaySales->save(); 

        if($bookingMonth == "January"){
            BookingMonthSales::query()->update(['after' => 1]);
        }
        $bookingMonthSales = BookingMonthSales::firstOrNew(['month' =>  $bookingMonth]);
        $bookingMonthSales->profit += $booking->total_fee;
        $bookingMonthSales->after = 0;
        $bookingMonthSales->save(); 

        $bookingYearSales = BookingYearSales::firstOrNew(['year' =>  $bookingYear]);
        $bookingYearSales->profit += $booking->total_fee;
        $bookingYearSales->save(); 

        return view('member.Booking', compact('booking'));
    }

    public function storeCoupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon_code)->first();
    }

}

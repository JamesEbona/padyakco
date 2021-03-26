<?php

namespace App\Http\Controllers\Mechanic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Events\BookingConfirmedEvent;
use App\Events\BookingEnRouteEvent;
use App\Events\BookingDoneEvent;
use App\Events\BookingCancelledEvent;
use App\Events\BookingPaymentEvent;
use App\Models\BookingDaySales;
use App\Models\BookingMonthSales;
use App\Models\BookingYearSales;

class BookingsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','mechanic','active']);
    }

    public function index()
    {
        $bookings = Booking::where('mechanic_id','=',auth()->user()->id)->get();
        return view('mechanic.Bookings', compact('bookings'));
    }

    public function calendar()
    {
        $bookings = Booking::where('status', '!=' , 'pending')->where('mechanic_id','=',auth()->user()->id)->get();
        return view('mechanic.BookingsCalendar', compact('bookings'));
    }

   
    public function modify(Request $request)
    {

      $validator = \Validator::make($request->all(), [
        'additional_fee' => ['required','numeric'],
     ]);
  
      if ($validator->fails()){
        return response()->json(['errors'=>$validator->errors()->all()]);
      }
        $booking = Booking::findOrFail(request('editId'));
        $current_additional = $booking->additional_fee;
      
        $total_fee = $booking->total_fee;
        $total_fee -= $booking->additional_fee;
        $total_fee += $booking->discount;
        $total_fee += request('additional_fee');

        if($booking->discount != 0){
          if($booking->discount_type == "Fixed"){
              $total_fee = max($total_fee - $booking->discount,0);
             
          }
          else{
              $discount = round(($booking->discount_percent / 100) * $total_fee);
              $total_fee -= $discount;
              // return response()->json(['errors'=>$total_fee]);
          }
      }

        $booking->additional_fee = request('additional_fee');
        $booking->total_fee = $total_fee;
        if($booking->discount != 0 && $booking->discount_type =="Percent"){
          $booking->discount = $discount;
        }
        $booking->save();

        if($current_additional != request('additional_fee') && $booking->status == "payment"){ 
        event(new BookingPaymentEvent($booking));  
        }
    
        return redirect("/mechanic/bookings");
    }

    public function showAddress($id)
    {
        $booking = Booking::where('id',$id)->firstOrFail();
        return view('mechanic.BookingAddress', compact('booking'));
    }

    public function updateStatus(Request $request)
    {

      $validator = \Validator::make($request->all(), [
        'status' => 'required|string|max:100',
     ]);
  
      if ($validator->fails()){
        return response()->json(['errors'=>$validator->errors()->all()]);
      }
    
      $status = request('status');
      $booking = Booking::findOrFail(request('editStatusId'));
      $booking->status = $status;
      $booking->save();

      if($status == "en route"){
        event(new BookingEnRouteEvent($booking));  
      }
      else if($status == "payment"){
        event(new BookingPaymentEvent($booking));  
      }
      else if($status == "done"){
        $booking->payment_method = "Cash";
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
      }
      else if($status == "cancelled"){
        event(new BookingCancelledEvent($booking)); 
      }
    
      return redirect("/mechanic/bookings");
    
    }

}


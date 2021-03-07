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
      
        $total_fee = $booking->total_fee;
        $total_fee -= $booking->additional_fee;
        $total_fee += request('additional_fee');

        $booking->additional_fee = request('additional_fee');
        $booking->total_fee = $total_fee;
        $booking->save();
    
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
      else if($status == "done"){
        event(new BookingDoneEvent($booking));  
      }
      else if($status == "cancelled"){
        event(new BookingCancelledEvent($booking)); 
      }
    
      return redirect("/mechanic/bookings");
    
    }

}


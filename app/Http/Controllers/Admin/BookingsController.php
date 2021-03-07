<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Repair;
use App\Models\User;
// use Carbon\Carbon;
use App\Events\BookingConfirmedEvent;
use App\Events\BookingEnRouteEvent;
use App\Events\BookingDoneEvent;
use App\Events\BookingCancelledEvent;
use App\Rules\verify_booking_region;

class BookingsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin','active']);
    }

    public function index()
    {
        $bookings = Booking::all();
        $mechanics = User::where('role','2')->get();
        return view('admin.Bookings', compact('bookings','mechanics'));
    }

    public function modify(Request $request)
    {

      $validator = \Validator::make($request->all(), [
        'first_name' => ['required','string','max:30','min:2','alpha'],
        'last_name' => ['required','string','max:30','min:2','alpha'],
        'booking_time' => ['required','date_format:Y-m-d\TH:i'],
        'repair_type' => ['required','string','regex:/^[a-zA-Z ]*$/','max:20'],
        'phone_number' => array('required','regex:/^(09|\+639)\d{9}$/'),
        'additional_fee' => ['required','numeric'],
        'notes' => ['nullable','string','max:1000'],    
     ]);
  
      if ($validator->fails()){
        return response()->json(['errors'=>$validator->errors()->all()]);
      }
        $booking = Booking::findOrFail(request('editId'));
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

        $total_fee = $booking->total_fee;
        $total_fee -= $booking->repair_fee;
        $total_fee += $repair_fee;
        $total_fee += request('additional_fee');

        $booking->first_name = request('first_name');
        $booking->last_name = request('last_name');
        $booking->phone_number = request('phone_number');
        $booking->booking_time = request('booking_time');
        $booking->repair_type = request('repair_type');
        $booking->additional_fee = request('additional_fee');
        $booking->repair_fee = $repair_fee;
        $booking->total_fee = $total_fee;
        $booking->notes= request('notes');
        $booking->save();
    
        return redirect("/admin/bookings");
    }

    public function showAddress($id)
    {
        $booking = Booking::where('id',$id)->firstOrFail();
        return view('admin.BookingAddress', compact('booking'));
    }

    public function updateAddress(Request $request)
    {
        $repair = Repair::where('id',1)->firstOrFail();
        $booking = Booking::findOrFail(request('booking_id'));

        if(request('location') != $booking->location){
              $request->validate([
                'location' => ['required','string','max:100'],
                'region' => ['nullable', new verify_booking_region()],
              ]);

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

              $total_fee = $booking->total_fee;
              $total_fee -= $booking->transportation_fee;
              $total_fee += $transportation_fee;

              $booking->location = request('location');
              $booking->longhitude = request('longhitude');
              $booking->latitude = request('latitude');
              $booking->transportation_fee = $transportation_fee;
              $booking->total_fee = $total_fee;
              $booking->save();

              return redirect()->route('adminBookingsShowAddress', request('booking_id'))->with('message', 'Booking address updated.');
        }
        else{
          return redirect()->route('adminBookingsShowAddress', request('booking_id'))->with('message', 'Booking address updated.');
        }

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
      $booking->mechanic_id = request('mechanic_id');
      $booking->save();

      if($status == "confirmed"){
        event(new BookingConfirmedEvent($booking));  
      }
      else if($status == "en route"){
        event(new BookingEnRouteEvent($booking));  
      }
      else if($status == "done"){
        event(new BookingDoneEvent($booking));  
      }
      else if($status == "cancelled"){
        event(new BookingCancelledEvent($booking)); 
      }
    
      return redirect("/admin/bookings");
    
    }

}


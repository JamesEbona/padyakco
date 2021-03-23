<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Repair;
use App\Models\User;
use Carbon\Carbon;
use App\Events\BookingConfirmedEvent;
use App\Events\BookingEnRouteEvent;
use App\Events\BookingDoneEvent;
use App\Events\BookingCancelledEvent;
use App\Events\MechanicAssignEvent;
use App\Events\MechanicUnassignEvent;
use App\Rules\verify_booking_region;
use App\Models\BookingDaySales;
use App\Models\BookingMonthSales;
use App\Models\BookingYearSales;
// use Illuminate\Support\Facades\Notification;
// use App\Notifications\MechanicNotification;

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

    public function calendar()
    {
        $bookings = Booking::where('status', '!=' , 'pending')->get();
        return view('admin.BookingsCalendar', compact('bookings'));
    }

    public function mechanicCalendar($id)
    {
        $bookings = Booking::where('status', '!=' , 'pending')->where('mechanic_id', '=' , $id)->get();
        $mechanic = User::where('id',$id)->firstOrFail();
        return view('admin.BookingsCalendar', compact('bookings','mechanic'));
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
                'location' => ['required','string','max:500'],
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

    public function modify(Request $request)
    {

      $validator = \Validator::make($request->all(), [
        'status' => 'required|string|max:100',
        'first_name' => ['required','string','max:30','min:2','regex:/^[\pL\s\-\.]+$/u'],
        'last_name' => ['required','string','max:30','min:2','regex:/^[\pL\s\-\.]+$/u'],
        'booking_time' => ['required','date_format:Y-m-d\TH:i'],
        'repair_type' => ['required','string','regex:/^[a-zA-Z ]*$/','max:20'],
        'phone_number' => array('required','regex:/^(09|\+639)\d{9}$/'),
        'additional_fee' => ['nullable','numeric'],
        'notes' => ['nullable','string','max:1000'],    
     ]);
  
      if ($validator->fails()){
        return response()->json(['errors'=>$validator->errors()->all()]);
      }
        $booking = Booking::findOrFail(request('editId'));
        $current_status = $booking->status;
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
        $total_fee -= $booking->additional_fee;
        $total_fee += $repair_fee;
        $total_fee += request('additional_fee');

        $booking->status = request('status');
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

        $status = request('status');

        if($current_status != $status){ 
            if($status == "confirmed"){
                event(new BookingConfirmedEvent($booking));  
            }
            else if($status == "en route"){
                event(new BookingEnRouteEvent($booking));  
            }
            else if($status == "done"){
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
                if(isset($booking->mechanic_id)){
                    event(new MechanicUnassignEvent($booking,$booking->mechanic->phone_number)); 
                }
            }
          }
    
        return redirect("/admin/bookings");
    }

    public function updateMechanic(Request $request)
    {

      $validator = \Validator::make($request->all(), [
        'mechanic' => 'required|numeric'
     ]);
  
      if ($validator->fails()){
        return response()->json(['errors'=>$validator->errors()->all()]);
      }

      $booking = Booking::findOrFail(request('editMechanicId'));
      $booking_before = $booking->booking_time->subHours(2);
      $booking_after = $booking->booking_time->addHours(2);
      $result = Booking::where('booking_time', '>=', $booking_before)->where('booking_time', '<=', $booking_after)->where('status', '!=', 'cancelled')->where('mechanic_id', '=', request('mechanic'))->where('id', '!=', $booking->id)->first();
      if(!$result){
        if(isset($booking->mechanic_id)){
        $current_mechanic = User::findOrFail($booking->mechanic_id); 
        $current_mechanic_id = $current_mechanic->id;
        }
        else{
        $current_mechanic_id = 0;
        }
        $new_mechanic = User::findOrFail(request('mechanic'));
        $booking->mechanic_id = $new_mechanic->id;
        $booking->save();
      }
      else{
        return response()->json(['errors'=>['Selected mechanic is unavailable during the booking time.']]);
      }

      if($current_mechanic_id != $new_mechanic->id){
        event(new MechanicAssignEvent($booking,$new_mechanic->phone_number)); 
        if($current_mechanic_id != 0){
            event(new MechanicUnassignEvent($booking,$current_mechanic->phone_number)); 
        }
        
        // Notification::send($new_mechanic, new MechanicNotification($booking)); 
      }
    
      return redirect("/admin/bookings");
    
    }


}


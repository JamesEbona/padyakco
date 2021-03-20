<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Booking;
use App\Models\Inquiry;
use App\Models\ProductCategoryReport;
use App\Models\BookingDaySales;
use App\Models\StoreDaySales;
use App\Models\BookingMonthSales;
use App\Models\StoreMonthSales;
use App\Models\BookingYearSales;
use App\Models\StoreYearSales;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin','active']);
    }

    public function index()
    {
        $member_count = User::where('role', '3')->count();
        $pending_orders_count = Order::where('status', '=', 'paid')->count();
        $inquiries_count = Inquiry::where('status', '=', 'pending')->count();
        $pending_bookings_count = Booking::where('status', '=', 'pending')->count();
        $basic_count = Booking::where('repair_type', '=', 'Basic')->count();
        $expert_count = Booking::where('repair_type', '=', 'Expert')->count();
        $upgrade_count = Booking::where('repair_type', '=', 'Upgrade')->count();
        $productCategories = ProductCategoryReport::all();
        $store_month_sales = StoreMonthSales::where('after', '!=', 1)->orderBy('created_at', 'ASC')->get();
        $booking_month_sales = BookingMonthSales::where('after', '!=', 1)->orderBy('created_at', 'ASC')->get();
        $store_year_sales = StoreYearSales::orderBy('year', 'ASC')->get();
        $booking_year_sales = BookingYearSales::orderBy('year', 'ASC')->get();

        $store_day_sales = StoreDaySales::where('after', '!=', 1)->orderBy('day', 'ASC')->get();
        $booking_day_sales = BookingDaySales::where('after', '!=', 1)->orderBy('day', 'ASC')->get();          
        
        return view('admin.home', compact('member_count','pending_orders_count','pending_bookings_count','basic_count','expert_count','upgrade_count','inquiries_count','productCategories','store_month_sales','booking_month_sales','store_year_sales','booking_year_sales','store_day_sales','booking_day_sales'));
    }

    public function storeDailySales()
    {
        $result = StoreDaySales::where('after', '!=', 1)->orderBy('day', 'ASC')->get();          
        return response()->json($result);
    }

    public function bookingDailySales()
    {
        $result = BookingDaySales::where('after', '!=', 1)->orderBy('day', 'ASC')->get();          
        return response()->json($result);
    }
    
}


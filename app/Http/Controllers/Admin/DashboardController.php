<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Booking;
use App\Models\Inquiry;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin','active']);
    }

    public function index()
    {
        $member_count = User::where('role', '3')->count();
        $sales_count = Order::where('status', '!=', 'cancelled')->count();
        $inquiries_count = Inquiry::where('status', '=', 'pending')->count();
        $pending_count = Booking::where('status', '=', 'pending')->count();
        $basic_count = Booking::where('repair_type', '=', 'Basic')->count();
        $expert_count = Booking::where('repair_type', '=', 'Expert')->count();
        $upgrade_count = Booking::where('repair_type', '=', 'Upgrade')->count();
        return view('admin.home', compact('member_count','sales_count','pending_count','basic_count','expert_count','upgrade_count','inquiries_count'));
    }
}


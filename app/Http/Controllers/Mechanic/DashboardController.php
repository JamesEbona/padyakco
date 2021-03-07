<?php

namespace App\Http\Controllers\Mechanic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','mechanic','active']);
    }

    public function index()
    {
        $pending_count = Booking::where('mechanic_id', auth()->id())->where('status', '!=', 'done')->where('status', '!=', 'cancelled')->count();
        $done_count = Booking::where('mechanic_id', auth()->id())->where('status', '=', 'done')->count();
        $cancelled_count = Booking::where('mechanic_id', auth()->id())->where('status', '=', 'cancelled')->count();
        return view('mechanic.home',compact('pending_count','done_count','cancelled_count'));
    }
}


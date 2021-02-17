<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin','active']);
    }

    public function index()
    {
        $member_count = User::where('role', '3')->count();
        return view('admin.home', compact('member_count'));
    }
}


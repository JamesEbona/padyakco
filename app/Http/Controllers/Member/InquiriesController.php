<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Inquiry;

class InquiriesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','member','active']);
    }

    public function index(){
        return view('member.Contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:80|min:2',
            'message' => 'required|string|max:800|min:2',
        ]);

        $inquiry = new Inquiry;
        $inquiry->name = auth()->user()->first_name.' '.auth()->user()->last_name;
        $inquiry->email = Auth::user()->email;
        $inquiry->message = request('message');
        $inquiry->subject = request('subject');
        $inquiry->status = "pending";
        $inquiry->save();

        return redirect(route('memberContact'))->with('message', 'Inquiry sent. Please expect a reply to your email soon.');
    }

}

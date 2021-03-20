<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Inquiry;

class InquiriesController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|string|email:rfc,dns|max:50|',
            'subject' => 'required|string|max:80|min:2',
            'message' => 'required|string|max:800|min:2',
        ]);

        $inquiry = new Inquiry;
        $inquiry->name = request('name');
        $inquiry->email = request('email');
        $inquiry->message = request('message');
        $inquiry->subject = request('subject');
        $inquiry->status = "pending";
        $inquiry->save();

        return redirect("/")->with('message', 'Inquiry sent.');
    }

}

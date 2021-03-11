<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Events\InquiryReplyEvent;

class InquiriesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin','active']);
    }

    public function index()
    {
        $inquiries = Inquiry::all();
        return view('admin.Inquiries', compact('inquiries'));
    }

    public function destroy($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry_from = $inquiry->name;
        Inquiry::destroy($id);
       
        return redirect("/admin/inquiries")->with('message', $inquiry_from."'s inquiry is now deleted."); 
    }

    public function reply(Request $request){
        $validator = \Validator::make($request->all(), [
            'reply' => 'required|string|min:2',
            'subject' => 'required|string|min:2',
         ]);
      
          if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
          }

          $inquiry = Inquiry::findOrFail(request('inquiryId'));
          $reply = request('reply');
          $subject = request('subject');
          $inquiry->status = "replied";
          $inquiry->save();
          
          event(new InquiryReplyEvent($inquiry,$reply,$subject));
    }

}


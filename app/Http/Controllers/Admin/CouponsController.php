<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Validation\Rule;


class CouponsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin','active']);
    }

    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.Coupons', compact('coupons'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:30',
            'type' => 'required|string|max:10|min:2', 
            'code' => 'required|string|max:15|',
            'category' => 'nullable|string|max:10|min:2', 
            'value' => [Rule::requiredIf(request('type') == "Fixed"),'nullable','numeric'], 
            'percent_off' => [Rule::requiredIf(request('type') == "Percent"),'nullable','numeric','max:100'],       
         ]);
      
        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
          
        $coupon = new Coupon; 
        $coupon->title = request('title');
        $coupon->type = request('type');
        $coupon->code = strtoupper(request('code'));
        if(request('category') != NULL){
        $coupon->category = request('category');
        }
        if(request('value') != NULL && request('type') == 'Fixed'){
        $coupon->value = request('value');
        }
        if(request('percent_off') != NULL && request('type') == 'Percent'){
        $coupon->percent_off = request('percent_off');
        }
        $coupon->status = "active";
        $coupon->save();

        return redirect("/admin/coupons")->with('message', 'Coupon added.');
    }

  
    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:30',
            'type' => 'required|string|max:10|min:2', 
            'code' => 'required|string|max:15|',
            'category' => 'nullable|string|max:10|min:2', 
            'value' => [Rule::requiredIf(request('type') == "Fixed"),'nullable','numeric'], 
            'percent_off' => [Rule::requiredIf(request('type') == "Percent"),'nullable','numeric','max:100'],       
         ]);
      
        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
          
        $coupon = Coupon::findOrFail(request('editId'));
        $coupon->title = request('title');
        $coupon->type = request('type');
        $coupon->code = strtoupper(request('code'));
        if(request('category') != NULL){
        $coupon->category = request('category');
        }
        if(request('value') != NULL && request('type') == 'Fixed'){
        $coupon->value = request('value');
        $coupon->percent_off = NULL;
        }
        if(request('percent_off') != NULL && request('type') == 'Percent'){
        $coupon->percent_off = request('percent_off');
        $coupon->value = NULL;
        }
        $coupon->status = "active";
        $coupon->save();

        return redirect("/admin/coupons")->with('message', 'Coupon updated.');
    }

    public function activate($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update(['status' => "active"]);
        $coupon_title = $coupon->title;
        return redirect("/admin/coupons")->with('message', $coupon_title." coupon is now active.");
    }

    public function deactivate($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update(['status' => "inactive"]);
        $coupon_title = $coupon->title;
        return redirect("/admin/coupons")->with('message', $coupon_title." coupon is now inactive.");  
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        Coupon::destroy($coupon->id);
        return redirect("/admin/coupons")->with('message', $coupon->title." coupon is now deleted.");  
    }
}

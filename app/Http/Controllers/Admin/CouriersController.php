<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Courier;
use App\Models\Order;

class CouriersController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin','active']);
    }

    public function index()
    {
        $couriers = Courier::all();
        return view('admin.Couriers', compact('couriers'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:30|min:2',
            'website' => 'nullable|string|max:500|min:2',     
         ]);
      
        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
          
        $courier = new Courier; 
        $courier->name = request('name');
        $courier->website = request('website');
        $courier->save();

        return redirect("/admin/couriers")->with('message', 'Logistic partner added.');
    }

    public function edit(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:30|min:2',
            'website' => 'nullable|string|max:500|min:2',     
         ]);
      
        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        
        $courier = Courier::findOrFail(request('editId'));
        $courier->name = request('name');
        $courier->website = request('website');
        $courier->save();

        return redirect("/admin/couriers")->with('message', 'Logistic partner updated.');
    }

    
    public function destroy($id)
    {
        $courier = Courier::findOrFail($id);
        if($courier->orders->count()){
            return redirect("/admin/couriers")->with('error_message', "Cannot delete, the logistic partner has orders.");  
        }

        Courier::destroy($courier->id);
        return redirect("/admin/couriers")->with('message', $courier->title." logistic partner is now deleted.");  
    }
}


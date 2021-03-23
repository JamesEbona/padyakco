<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\Cart;
use App\Models\Address;
use Illuminate\Auth\Events\Registered;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use App\Rules\verify_password;


class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin','active']);
    }

    public function membersindex(Request $request)
    {
      $users = User::all()->where('role', '==', '3');
      return view('admin.Members', compact('users'));
    }
    
    public function adminsindex(Request $request)
    {
      $users = User::all()->where('role', '==', '1');
      return view('admin.Admins', compact('users'));
    } 

    public function mechanicsindex(Request $request)
    {
      $users = User::all()->where('role', '==', '2');
      return view('admin.Mechanics', compact('users'));
    } 

   public function memberstore(Request $request){

    $validator = \Validator::make($request->all(), [
      'first_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
      'last_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
      'email' => 'required|string|email:rfc,dns|max:50|unique:users',
      'password' => 'required|string|confirmed|min:8|max:15',
      'image' => 'image|dimensions:min_width=100,min_height=100'
          
   ]);

    if ($validator->fails()){
      return response()->json(['errors'=>$validator->errors()->all()]);
    }
    
        if(request('image') != NULL){
        $imagePath = request('image')->store('avatars','public');       
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(180, 180);
        $image->save();
       }
       else {
        $imagePath = 'avatars/avatar_stock_photo.png';
       }
        //  $user = $user = new User; 
         $user = new User;
         $user->first_name = request('first_name');
         $user->last_name = request('last_name');
         $user->email = request('email');
         $user->image = $imagePath;
         $user->status = 'active';
         $user->password = Hash::make(request('password'));
         $user->role = '3';
         $user->save();

         $address = new Address;
         $address->user_id = $user->id;
         $address->save();

         $cart = new Cart;
         $cart->user_id = $user->id;
         $cart->save();

         event(new Registered($user));

         return redirect("/admin/memberusers")->with('message', 'Member added.');
    } 

    public function adminstore(Request $request){

      $validator = \Validator::make($request->all(), [
        'first_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
        'last_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
        'email' => 'required|string|email:rfc,dns|max:50|unique:users',
        'password' => 'required|string|confirmed|min:8|max:15',
        'image' => 'image|dimensions:min_width=100,min_height=100'
            
     ]);
  
      if ($validator->fails()){
        return response()->json(['errors'=>$validator->errors()->all()]);
      }
      
          if(request('image') != NULL){
          $imagePath = request('image')->store('avatars','public');       
          $image = Image::make(public_path("storage/{$imagePath}"))->fit(180, 180);
          $image->save();
         }
         else {
          $imagePath = 'avatars/avatar_stock_photo.png';
         }
          //  $user = $user = new User; 
           $user = new User;
           $user->first_name = request('first_name');
           $user->last_name = request('last_name');
           $user->email = request('email');
           $user->image = $imagePath;
           $user->status = 'active';
           $user->password = Hash::make(request('password'));
           $user->role = '1';
           $user->save();
  
           return redirect("/admin/adminusers")->with('message', 'Admin added.');
      } 

      public function mechanicstore(Request $request){

        $validator = \Validator::make($request->all(), [
          'first_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
          'last_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
          'email' => 'required|string|email:rfc,dns|max:50|unique:users',
          'password' => 'required|string|confirmed|min:8|max:15',
          'image' => 'image|dimensions:min_width=100,min_height=100',
          'phone_number' => array('required','regex:/^(09|\+639)\d{9}$/','unique:users'),
              
       ]);
    
        if ($validator->fails()){
          return response()->json(['errors'=>$validator->errors()->all()]);
        }
        
            if(request('image') != NULL){
            $imagePath = request('image')->store('avatars','public');       
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(180, 180);
            $image->save();
           }
           else {
            $imagePath = 'avatars/avatar_stock_photo.png';
           }
            //  $user = $user = new User; 
             $user = new User;
             $user->first_name = request('first_name');
             $user->last_name = request('last_name');
             $user->email = request('email');
             $user->phone_number = request('phone_number');
             $user->image = $imagePath;
             $user->status = 'active';
             $user->password = Hash::make(request('password'));
             $user->role = '2';
             $user->save();
    
             return redirect("/admin/mechanicusers")->with('message', 'Admin added.');
        } 

	 public function show(){
       
          return view('Admin.ViewUser');	
         
      }

       public function edit(){
          return view('Admin.EditUser');	
         
      }

      public function changepassword(){
      
          return view('Admin.ChangePassword');	
         
      }

      public function update(Request $request)
      {
        $UserID = auth()->user()->id;

        $request->validate([
          'first_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
          'last_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
          'email' => 'required|string|email:rfc,dns|max:50|unique:users,email,'.$UserID.',id',
          'image' => 'image|dimensions:min_width=100,min_height=100'
          // 'email' => 'required|string|email|max:50|unique:users',
      ]);
  
       $data = array(
              'first_name' => request('first_name'),
              'last_name' => request('last_name'),
              'email' => request('email'),
          );
  
  
      if (request('image')){
       $imagePath = request('image')->store('avatars','public');       
       
  
          $image = Image::make(public_path("storage/{$imagePath}"))->fit(180, 180);
          
          $image->save();
  
          $imageArray = ['image' => $imagePath];
      }
     
  
     // auth()->user()->profile->update($data);
  
         User::where('id', $UserID)->update(array_merge(
      $data,
      $imageArray ?? []
     
  
  
      ));
      
      return redirect("/admin/editUser")->with('message', 'Profile Updated.');
     
      
      }

      public function updatepassword(Request $request)
      {

        $request->validate([
          'old_password' => ['required', new verify_password],
          'password' => ['required','string','confirmed','min:8','max:15'],
      ]);
  
       $data = array(
              'password' => Hash::make(request('password'))
          );

         User::where('id', auth()->user()->id)->update($data);
      
         return redirect("/admin/changePassword")->with('message', 'Password Updated.');
     
     
      }

      public function modify(Request $request)
    {
      $RequestID = request('editId');

      $validator = \Validator::make($request->all(), [
        'first_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
        'last_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
        'email' => 'required|string|email:rfc,dns|max:50|unique:users,email,'.$RequestID.',id',
        'image' => 'image|dimensions:min_width=100,min_height=100'
        // 'email' => 'required|string|email|max:50|unique:users',        
     ]);
  
      if ($validator->fails()){
        return response()->json(['errors'=>$validator->errors()->all()]);
      }

  
     $data = array(
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
        );


    if (request('image')){
     $imagePath = request('image')->store('avatars','public');       
        //where the image will be uploaded

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(180, 180);
        //intervention library that fits image to size
        $image->save();

        $imageArray = ['image' => $imagePath];
    }
    //if the user submits an image in the form

   // auth()->user()->profile->update($data);

    //CHECK FOR NEW OR EXISTING ORDER
    if($RequestID > 0) {
        //THIS FUNCTION SOMEHOW RETURNS THE FUNCTION CALL AND DOESNT CONTINUE PAST
        //AND THE RECORD IS NOT UPDATED
       User::where('id', $RequestID)->update(array_merge(
    $data,
    $imageArray ?? []
    //if no image set


    ));
    }
     
    return redirect("/admin/memberusers");
    
    }
    
     public function modifyAdmin(Request $request)
    {
      $RequestID = request('editId');

      $validator = \Validator::make($request->all(), [
        'first_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
        'last_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
        'email' => 'required|string|email:rfc,dns|max:50|unique:users,email,'.$RequestID.',id',
        'image' => 'image|dimensions:min_width=100,min_height=100'
        // 'email' => 'required|string|email|max:50|unique:users',        
     ]);
  
      if ($validator->fails()){
        return response()->json(['errors'=>$validator->errors()->all()]);
      }

  
     $data = array(
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
        );


    if (request('image')){
     $imagePath = request('image')->store('avatars','public');       
        //where the image will be uploaded

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(180, 180);
        //intervention library that fits image to size
        $image->save();

        $imageArray = ['image' => $imagePath];
    }
    //if the user submits an image in the form

   // auth()->user()->profile->update($data);

    //CHECK FOR NEW OR EXISTING ORDER
    if($RequestID > 0) {
        //THIS FUNCTION SOMEHOW RETURNS THE FUNCTION CALL AND DOESNT CONTINUE PAST
        //AND THE RECORD IS NOT UPDATED
       User::where('id', $RequestID)->update(array_merge(
    $data,
    $imageArray ?? []
    //if no image set


    ));
    }
     
    return redirect("/admin/adminusers");
    
    }

    public function modifyMechanic(Request $request)
    {

      $validator = \Validator::make($request->all(), [
        'first_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
        'last_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
        'email' => 'required|string|email:rfc,dns|max:50|unique:users,email,'.request("editId").',id',
        'image' => 'image|dimensions:min_width=100,min_height=100',
        'phone_number' => array('required','regex:/^(09|\+639)\d{9}$/','unique:users,phone_number,'.request("editId").',id'),
        // 'email' => 'required|string|email|max:50|unique:users',        
     ]);
  
      if ($validator->fails()){
        return response()->json(['errors'=>$validator->errors()->all()]);
      }

  
     $data = array(
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'phone_number' => request('phone_number'),
        );


    if (request('image')){
     $imagePath = request('image')->store('avatars','public');       
        //where the image will be uploaded

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(180, 180);
        //intervention library that fits image to size
        $image->save();

        $imageArray = ['image' => $imagePath];
    }
    //if the user submits an image in the form

   // auth()->user()->profile->update($data);

    $RequestID = request('editId');

    //CHECK FOR NEW OR EXISTING ORDER
    if($RequestID > 0) {
        //THIS FUNCTION SOMEHOW RETURNS THE FUNCTION CALL AND DOESNT CONTINUE PAST
        //AND THE RECORD IS NOT UPDATED
       User::where('id', $RequestID)->update(array_merge(
    $data,
    $imageArray ?? []
    //if no image set


    ));
    }
     
    return redirect("/admin/mechanicusers");
    
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => "active"]);
        $user_name = $user->first_name.' '.$user->last_name;
        if($user->role == '3'){
        return redirect("/admin/memberusers")->with('message', $user_name."'s account is now activated.");
        }
        else if($user->role == '2'){
          return redirect("/admin/mechanicusers")->with('message', $user_name."'s account is now activated.");
          }
        else if($user->role == '1'){
        return redirect("/admin/adminusers")->with('message', $user_name."'s account is now activated.");
        }

    }

     public function deactivate($id)
    {
       
         $user = User::findOrFail($id);

         $user_name = $user->first_name.' '.$user->last_name;
         if($user->role == '3'){
         $user->update(['status' => "inactive"]);
         return redirect("/admin/memberusers")->with('message', $user_name."'s account is now deactivated.");
         }
         else if($user->role == '2'){
          $result = Booking::where('mechanic_id',$user->id)->where('status','!=','done')->where('status','!=','cancelled')->get();
          if(count($result) != 0){
            return redirect("/admin/mechanicusers")->with('error_message', $user_name." is currently assigned to an active booking and cannot be deactivated."); 
          }
          else{
            $user->update(['status' => "inactive"]);
            return redirect("/admin/mechanicusers")->with('message', $user_name."'s account is now deactivated."); 
          } 
         }
         else if($user->role == '1'){
          $user->update(['status' => "inactive"]);
          return redirect("/admin/adminusers")->with('message', $user_name."'s account is now deactivated.");  
         }
    }

     public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->role == '1'){
        User::destroy($id);
         return redirect("/admin/adminusers");
        }
        if($user->role == '2'){
        User::destroy($id);
        return redirect("/admin/mechanicusers");
        } 
    }

    
}

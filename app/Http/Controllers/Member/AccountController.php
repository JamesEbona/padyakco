<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\verify_password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Address;
use Intervention\Image\Facades\Image;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','member','active']);
    }

    public function index()
    {
        return view('member.MyAccount');
    }

    public function edit_profile()
    {
        return view('member.EditProfile');
    }

    public function edit_password()
    {
        return view('member.EditPassword');
    }

    public function edit_address()
    {
        return view('member.EditAddress');
    }

    public function update_address(Request $request){

        $request->validate([
            'address1' => 'required|string|max:100',
            'address2' => 'string|nullable|max:100',
            'postal_code' => 'required|regex:/\d{4}/',
            'city' => 'required|string|regex:/^[a-zA-Z ]*$/|max:20|',
            'province' => 'required|string|regex:/^[a-zA-Z ]*$/|max:20|',
            'phone_number' => array('required','regex:/^(09|\+639)\d{9}$/'),
            
        ]);

        $data = array(
            'address1' => request('address1'),
            'address2' => request('address2'),
            'postal_code' => request('postal_code'),
            'city' => request('city'),
            'province' => request('province'),
            'phone_number' => request('phone_number'),
        );

      
        // if(request('image') != NULL){
        // $imagePath = request('image')->store('avatars','public');       
          
        //     $image = Image::make(public_path("storage/{$imagePath}"))->fit(180, 180);
         
        //     $image->save();

        //     $imageArray = ['image' => $imagePath];
        // }

        $UserID = auth()->user()->id;
     

          Address::where('user_id', $UserID)->update($data);
         
     
        return redirect("/member/editaddress")->with('message', 'Delivery details updated.');
    }

    public function update_profile(Request $request){

        $request->validate([
            'first_name' => 'required|string|max:30|min:2|alpha',
            'last_name' => 'required|string|max:30|min:2|alpha',
            'email' => 'required|string|email|max:50|',
            'image' => 'image'
            // 'email' => 'required|string|email|max:50|unique:users',
        ]);

        $data = array(
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
        );

      
        if(request('image') != NULL){
        $imagePath = request('image')->store('avatars','public');       
          
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(180, 180);
         
            $image->save();

            $imageArray = ['image' => $imagePath];
        }

        $UserID = auth()->user()->id;
     

    // auth()->user()->profile->update($data);

      
          User::where('id', $UserID)->update(array_merge(
        $data,
        $imageArray ?? []
        ));
         
     
        return redirect("/member/editprofile")->with('message', 'Profile Updated.');
    }
    
    public function update_password(Request $request){
        $request->validate([
            'old_password' => ['required', new verify_password],
            'password' => 'required|string|confirmed|min:8|max:15',
        ]);

        $data = array(
                'password' => Hash::make(request('password'))
            );

        User::where('id', auth()->user()->id)->update($data);
        
        return redirect("/member/editpassword")->with('message', 'Password Updated.');
        }
}

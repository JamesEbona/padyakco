<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\verify_password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Address;
use Intervention\Image\Facades\Image;
use Illuminate\Auth\Events\Registered;

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

        $UserID = auth()->user()->id;

        $request->validate([
            'address1' => 'required|string|max:100',
            'address2' => 'string|nullable|max:100',
            'postal_code' => 'required|numeric|regex:/^\d{3,4}$/',
            'city' => 'required|string|regex:/^[a-zA-Z ]*$/|max:20|',
            'province' => 'required|string|regex:/^[a-zA-Z ]*$/|max:20|',
            'phone_number' => array('required','regex:/^(09|\+639)\d{9}$/','unique:users,phone_number,'.$UserID.',id'),
            
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

          Address::where('user_id', $UserID)->update($data);
         
     
        return redirect("/member/editaddress")->with('message', 'Delivery details updated.');
    }

    public function update_profile(Request $request){

        $UserID = auth()->user()->id;

        $request->validate([
            'first_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
            'last_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
            'email' => 'required|string|email:rfc,dns|max:50|unique:users,email,'.$UserID.',id',
            'image' => 'image|dimensions:min_width=100,min_height=100'
            // 'email' => 'required|string|email|max:50|unique:users',
        ]);

       
      
        if(request('image') != NULL){
        $imagePath = request('image')->store('avatars','public');       
          
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(180, 180);
         
            $image->save();

            $imageArray = ['image' => $imagePath];
        }

    // auth()->user()->profile->update($data);
        $user =  User::find($UserID);
        if($user->email != request('email')){
            $data = array(
                'first_name' => ucfirst(request('first_name')),
                'last_name' => ucfirst(request('last_name')),
                'email' => request('email'),
                'email_verified_at' => NULL
            );

            $user->update(array_merge(
                $data,
                $imageArray ?? []
                ));

            event(new Registered($user));
        }
        else{
            $data = array(
                'first_name' => ucfirst(request('first_name')),
                'last_name' => ucfirst(request('last_name')),
                'email' => request('email'),
            );

            $user->update(array_merge(
                $data,
                $imageArray ?? []
                ));
        }

        // User::where('id', $UserID)->update(array_merge(
        // $data,
        // $imageArray ?? []
        // ));

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

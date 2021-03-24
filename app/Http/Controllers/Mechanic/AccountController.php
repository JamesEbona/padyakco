<?php

namespace App\Http\Controllers\Mechanic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Rules\verify_password;


class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','mechanic','active']);
    }

    public function index()
    {
        return view('mechanic.home');
    }

    public function show(){
       
        return view('mechanic.ViewUser');	
       
    }

     public function edit(){
        return view('mechanic.EditUser');	
       
    }

    public function changepassword(){
    
        return view('mechanic.ChangePassword');	
       
    }

    public function update(Request $request)
    {
        $UserID = auth()->user()->id;

        $request->validate([
            'first_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
            'last_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
            'email' => 'required|string|email:rfc,dns|max:50|unique:users,email,'.$UserID.',id',
            'phone_number' => array('required','regex:/^(09|\+639)\d{9}$/','unique:users,phone_number,'.$UserID.',id'),
            'image' => 'image'
            // 'email' => 'required|string|email|max:50|unique:users',
        ]);

        $data = array(
                'first_name' => ucfirst(request('first_name')),
                'last_name' => ucfirst(request('last_name')),
                'email' => request('email'),
                'phone_number' => request('phone_number')
        );


        if (request('image')){
            $imagePath = request('image')->store('avatars','public');       
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(180, 180);
            $image->save();
            $imageArray = ['image' => $imagePath];
        }
    
        User::where('id', $UserID)->update(array_merge(
        $data,
        $imageArray ?? []
        ));
        
        return redirect("/mechanic/editUser")->with('message', 'Profile Updated.');
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
    
       return redirect("/mechanic/changePassword")->with('message', 'Password Updated.');
   
    }
}


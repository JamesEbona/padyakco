<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;
use App\Models\Cart;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
            'last_name' => 'required|string|max:30|min:2|regex:/^[\pL\s\-\.]+$/u',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|confirmed|min:8|max:15',

        ]);

        Auth::login($user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => '3',
            'status' => 'active',
            'image' => '/avatars/avatar_stock_photo.png'
        ]));

        $address = new Address;
        $address->user_id = $user->id;
        $address->save();

        $cart = new Cart;
        $cart->user_id = $user->id;
        $cart->save();

        event(new Registered($user));


        
        return redirect()->route('verification.notice');
        // return redirect(RouteServiceProvider::HOME);
    }
}

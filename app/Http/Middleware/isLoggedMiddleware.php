<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isLoggedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (auth()->user()->role =='1') {
                return redirect()->route('adminDashboard');
            }
            if (auth()->user()->role =='2') {
                return redirect()->route('mechanicDashboard');
            }
            if (auth()->user()->role =='3') {
                return redirect()->route('myAccount');
            }
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isActiveMiddleware
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
        if(auth()->user()->status =='inactive'){
            abort(403);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isMemberMiddleware
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
        if(auth()->user()->role !='3'){
            abort(403);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class CheckOwnProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
          if(auth()->user()->id == $request->id){
            return $next($request);
        }
       abort(403, 'Unauthorized action.');
      
    }
}

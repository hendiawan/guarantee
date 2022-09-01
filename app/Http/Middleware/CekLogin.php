<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CekLogin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        if (Auth::user() &&
            Auth::user()->level != 'admin'&& 
            Auth::user()->level != 'super'&& 
            Auth::user()->level != 'direksi') {
          return redirect()->guest('/');
          //  abort(404);
        }  
        return $next($request);
    }

}

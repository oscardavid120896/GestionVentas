<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth::user()->rol == 'directivo'){
            return redirect('directivo');
        }elseif(auth::user()->rol == 'alumno'){
            return redirect('alumno');
        }elseif(auth::user()->rol == 'profesor'){
            return redirect('profesor');
        }else{
            return $next($request);
        }
    }
}

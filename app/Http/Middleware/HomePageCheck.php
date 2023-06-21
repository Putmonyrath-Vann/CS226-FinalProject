<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomePageCheck
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
        if (Auth::guard('buyer')->check()) {
            return redirect('/buyer');
        }
        else if (Auth::guard('driver')->check()) {
            return redirect('/drivers');
        }
        else if (Auth::guard('restaurant')->check()) {
            return redirect('/restaurant');
        }
        else return redirect('/login');
    }
}

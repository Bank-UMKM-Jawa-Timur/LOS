<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() != '') {
            if (Auth::user()->role == 'Administrator') {
                return $next($request);
            }
        }
        return redirect('/');
    }
}

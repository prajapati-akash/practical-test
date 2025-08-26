<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserAccessMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must login first.');
        }

        if (Auth::user()->user_type === 'admin') {
            return redirect()->route('dashboard')->with('error', 'Admins cannot access this section.');
        }

        return $next($request);
    }
}
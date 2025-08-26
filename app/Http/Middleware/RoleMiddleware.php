<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Usage in routes: ->middleware('role:admin') or ->middleware('role:user,sub_user')
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user = Auth::user();

        // if roles passed, check if user's role is in roles list
        if ($roles && count($roles) > 0) {
            if (! in_array($user->user_type, $roles)) {
                abort(403, 'Unauthorized.');
            }
        }

        return $next($request);
    }
}
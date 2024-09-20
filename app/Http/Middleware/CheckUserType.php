<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next , $role)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Please log in to access this page.');
        }

        // Check if the authenticated user's role matches the required role
        if (Auth::user()->user_type !== $role) {
            return redirect('/home')->with('error', 'Unauthorized Access');
        }

        return $next($request);
    }
}

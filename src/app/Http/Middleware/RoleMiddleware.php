<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $role
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if the user is authenticated and has the required role
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        return redirect()->route('home'); 
    }
}

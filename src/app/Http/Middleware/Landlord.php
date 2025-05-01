<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LandlordMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'landlord') {
            return redirect()->route('login')
                ->with('error', 'Access denied. Landlord privileges required.');
        }

        return $next($request);
    }
}
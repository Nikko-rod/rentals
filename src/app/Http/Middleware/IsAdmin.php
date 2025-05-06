<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('admin.login')
                ->with('error', 'Access denied. Admin privileges required.');
        }

        return $next($request);
    }
}
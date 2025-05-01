<?php

namespace App\Http\Middleware;

use App\Enums\ApprovalStatus;

class VerifiedLandlord
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->isApproved()) {
            return redirect()->route('landlord.profile')
                ->with('error', 'Please verify your account by uploading a business permit first.');
        }

        return $next($request);
    }
}
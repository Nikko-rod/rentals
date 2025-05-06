<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{
    public function index()
    {
        
        $totalInquiries = Auth::user()->inquiries()->count();
        
        $latestInquiries = Auth::user()->inquiries()
            ->with('property')
            ->latest()
            ->take(5)
            ->get();

        $latestProperties = Property::where('is_active', true)
            ->with(['images', 'owner'])
            ->latest()
            ->take(5)
            ->get();

        return view('tenant.dashboard', compact(
            'totalInquiries',
            'latestInquiries',
            'latestProperties'
        ));
    }
}
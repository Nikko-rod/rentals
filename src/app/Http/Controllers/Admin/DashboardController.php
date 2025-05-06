<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $monthStart = Carbon::now()->startOfMonth();
        $totalUsers = User::count();
        $newUsersThisMonth = User::where('created_at', '>=', $monthStart)->count();
        
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalProperties' => Property::count(),
            'totalLandlords' => User::where('role', 'landlord')->count(),
            'totalTenants' => User::where('role', 'tenant')->count(),
            'userGrowth' => $totalUsers > 0 ? ($newUsersThisMonth / $totalUsers) * 100 : 0,
            'recentProperties' => Property::with('owner')  
                ->latest()
                ->take(5)
                ->get(),
            'recentUsers' => User::latest()
                ->take(5)
                ->get()
        ]);
    }
}
@extends('layouts.dashboard')

@section('title', 'Admin Dashboard | Rentals Tacloban')

@section('sidebar')
    <ul>
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
    <a href="{{ route('admin.manage-users') }}" class="nav-link {{ Request::routeIs('admin.manage-users') ? 'active' : '' }}">
        <i class="fas fa-users"></i>
        <span>Manage Users</span>
    </a>
</li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-home"></i>
                <span>Properties</span>
            </a>
        </li>
    </ul>
    <ul>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>
@endsection

@section('content')
<div class="content-card">
    <h1 class="font-bold text-2xl mb-4">Welcome back, {{ Auth::user()->first_name }}!</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="content-card">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-primary rounded-lg">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-light text-sm">Total Users</h3>
                <p class="font-bold text-xl">{{ $totalUsers ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-primary rounded-lg">
                <i class="fas fa-home text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-light text-sm">Properties</h3>
                <p class="font-bold text-xl">{{ $totalProperties ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-primary rounded-lg">
                <i class="fas fa-user-tie text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-light text-sm">Landlords</h3>
                <p class="font-bold text-xl">{{ $totalLandlords ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-primary rounded-lg">
                <i class="fas fa-user text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-light text-sm">Tenants</h3>
                <p class="font-bold text-xl">{{ $totalTenants ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="content-card">
        <h2 class="font-bold text-xl mb-4">Recent Properties</h2>
        @if(isset($recentProperties) && count($recentProperties) > 0)
            <div class="space-y-4">
                @foreach($recentProperties as $property)
                    <div class="flex items-center gap-4">
                        <i class="fas fa-home text-primary"></i>
                        <div>
                            <h4 class="font-semibold">{{ $property->name }}</h4>
                            <p class="text-light text-sm">Added {{ $property->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-light">No recent properties.</p>
        @endif
    </div>

    <div class="content-card">
        <h2 class="font-bold text-xl mb-4">New Users</h2>
        @if(isset($recentUsers) && count($recentUsers) > 0)
            <div class="space-y-4">
                @foreach($recentUsers as $user)
                    <div class="flex items-center gap-4">
                        <i class="fas fa-user text-primary"></i>
                        <div>
                            <h4 class="font-semibold">{{ $user->first_name }} {{ $user->last_name }}</h4>
                            <p class="text-light text-sm">Joined {{ $user->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-light">No new users.</p>
        @endif
    </div>
</div>
@endsection
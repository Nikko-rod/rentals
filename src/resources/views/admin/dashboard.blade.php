@extends('layouts.final-dashboard')

@section('title', 'Admin Dashboard')
@section('dashboard-title', 'Admin Panel')
@section('page-title', 'Dashboard')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105 
              {{ Request::routeIs('admin.dashboard') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-chart-line w-5"></i>
        <span>Dashboard</span>
    </a>
    
    <a href="{{ route('admin.manage-users') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('admin.manage-users') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-users w-5"></i>
        <span>Manage Users</span>
    </a>

    <a href="{{ route('admin.properties.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('admin.properties.index') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-home w-5"></i>
        <span>Manage Properties</span>
    </a>
@endsection

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Users Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 p-4 rounded-lg transition-colors duration-300 hover:bg-blue-200">
                    <i class="fas fa-users text-blue-600 text-xl transition-transform duration-300 hover:scale-110"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Users</p>
                    <h3 class="text-2xl font-bold">{{ number_format($totalUsers) }}</h3>
                </div>
            </div>
        </div>

        <!-- Properties Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="bg-indigo-100 p-4 rounded-lg transition-colors duration-300 hover:bg-indigo-200">
                    <i class="fas fa-building text-indigo-600 text-xl transition-transform duration-300 hover:scale-110"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Properties</p>
                    <h3 class="text-2xl font-bold">{{ number_format($totalProperties) }}</h3>
                </div>
            </div>
        </div>

        <!-- Landlords Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="bg-purple-100 p-4 rounded-lg transition-colors duration-300 hover:bg-purple-200">
                    <i class="fas fa-user-tie text-purple-600 text-xl transition-transform duration-300 hover:scale-110"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Landlords</p>
                    <h3 class="text-2xl font-bold">{{ number_format($totalLandlords) }}</h3>
                </div>
            </div>
        </div>

        <!-- Tenants Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="bg-pink-100 p-4 rounded-lg transition-colors duration-300 hover:bg-pink-200">
                    <i class="fas fa-user text-pink-600 text-xl transition-transform duration-300 hover:scale-110"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Tenants</p>
                    <h3 class="text-2xl font-bold">{{ number_format($totalTenants) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Recent Properties -->
        <div class="bg-white rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Recent Properties</h2>
                <a href="{{ route('admin.properties.index') }}" class="text-blue-600 hover:text-blue-700 text-sm">View all</a>
            </div>
            @if($recentProperties->count() > 0)
                <div class="space-y-4">
                    @foreach($recentProperties as $property)
                        <div class="flex items-center gap-4 p-3 rounded-lg transition-all duration-300 hover:bg-gray-50 hover:shadow-md transform hover:-translate-x-1">
                            <div class="bg-gray-100 p-3 rounded-lg transition-colors duration-300 hover:bg-gray-200">
                                <i class="fas fa-home text-gray-600 transition-transform duration-300 hover:rotate-12"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold">{{ $property->title }}</h4>
                                <p class="text-sm text-gray-500">
                                    Added by {{ $property->owner->full_name }}
                                    <span class="mx-2">•</span>
                                    {{ $property->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="text-sm">
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full transition-all duration-300 hover:bg-green-200">
                                    ₱{{ number_format($property->monthly_rent) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-home text-4xl mb-3"></i>
                    <p>No properties listed yet</p>
                </div>
            @endif
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">New Users</h2>
                <a href="{{ route('admin.manage-users') }}" class="text-blue-600 hover:text-blue-700 text-sm">View all</a>
            </div>
            @if($recentUsers->count() > 0)
                <div class="space-y-4">
                    @foreach($recentUsers as $user)
                        <div class="flex items-center gap-4 p-3 rounded-lg transition-all duration-300 hover:bg-gray-50 hover:shadow-md transform hover:translate-x-1">
                            <div class="bg-gray-100 p-3 rounded-lg transition-colors duration-300 hover:bg-gray-200">
                                <i class="fas fa-user text-gray-600 transition-transform duration-300 hover:scale-110"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold">{{ $user->full_name }}</h4>
                                <p class="text-sm text-gray-500">
                                    {{ ucfirst($user->role) }}
                                    <span class="mx-2">•</span>
                                    {{ $user->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm transition-all duration-300 hover:bg-blue-200">
                                    {{ $user->email_verified_at ? 'Email verified' : 'Pending' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-users text-4xl mb-3"></i>
                    <p>No new users</p>
                </div>
            @endif
        </div>
    </div>
@endsection
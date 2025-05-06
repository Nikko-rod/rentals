@extends('layouts.final-dashboard')

@section('title', 'Tenant Dashboard')
@section('dashboard-title', 'Tenant Portal')
@section('page-title', 'Dashboard')

@section('sidebar-menu')
    <a href="{{ route('tenant.dashboard') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105 
              {{ Request::routeIs('tenant.dashboard') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-home w-5"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('tenant.properties.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('tenant.properties.index') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-building w-5"></i>
        <span>Browse Properties</span>
    </a>

    <a href="{{ route('tenant.inquiries.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('tenant.inquiries.index') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-message w-5"></i>
        <span>My Inquiries</span>
    </a>

    <a href="{{ route('tenant.profile') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('tenant.profile') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-user w-5"></i>
        <span>Profile</span>
    </a>
@endsection

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Active Inquiries -->
        <div class="bg-white rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 p-4 rounded-lg transition-colors duration-300 hover:bg-blue-200">
                    <i class="fas fa-message text-blue-600 text-xl transition-transform duration-300 hover:scale-110"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Active Inquiries</p>
                    <h3 class="text-2xl font-bold">0</h3>
                </div>
            </div>
        </div>

        <!-- Similar cards for other stats -->
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Inquiries -->
        <div class="bg-white rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Recent Inquiries</h2>
                <a href="{{ route('tenant.inquiries.index') }}" class="text-blue-600 hover:text-blue-700 text-sm">View all</a>
            </div>
            <!-- Add your inquiries list here -->
        </div>

        <!-- Saved Properties or other content -->
        <div class="bg-white rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-lg">
            <!-- Add your content here -->
        </div>
    </div>
@endsection
@extends('layouts.final-dashboard')

@section('title', 'Landlord Dashboard')
@section('dashboard-title', 'Landlord Portal')
@section('page-title', 'Dashboard')

@section('sidebar-menu')
    <a href="{{ route('landlord.dashboard') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105 
              {{ Request::routeIs('landlord.dashboard') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-home w-5"></i>
        <span>Dashboard</span>
    </a>
    
    <a href="{{ route('landlord.properties.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('landlord.properties.index') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-building w-5"></i>
        <span>Properties</span>
    </a>

    <a href="{{ route('landlord.inquiries.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('landlord.inquiries.index') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-message w-5"></i>
        <span>Inquiries</span>
    </a>

    <a href="{{ route('landlord.profile') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('landlord.profile') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-user-circle w-5"></i>
        <span>Profile</span>
    </a>
@endsection

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Properties Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="bg-indigo-100 p-4 rounded-lg transition-colors duration-300 hover:bg-indigo-200">
                    <i class="fas fa-building text-indigo-600 text-xl transition-transform duration-300 hover:scale-110"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Listed Properties</p>
                    <h3 class="text-2xl font-bold">{{ auth()->user()->properties()->count() }}</h3>
                </div>
            </div>
        </div>

        <!-- Unread Inquiries Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 p-4 rounded-lg transition-colors duration-300 hover:bg-blue-200">
                    <i class="fas fa-message text-blue-600 text-xl transition-transform duration-300 hover:scale-110"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Unread Inquiries</p>
                    <h3 class="text-2xl font-bold">
                        {{ auth()->user()->receivedInquiries()->whereNull('read_at')->count() }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Inquiries Section -->
    @if(auth()->user()->receivedInquiries()->count() > 0)
        <div class="bg-white rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Recent Inquiries</h2>
                <a href="{{ route('landlord.inquiries.index') }}" class="text-blue-600 hover:text-blue-700 text-sm">
                    View all
                </a>
            </div>
            
            <div class="space-y-4">
                @foreach(auth()->user()->receivedInquiries()->latest()->take(5)->get() as $inquiry)
                    <div class="flex items-center gap-4 p-3 rounded-lg transition-all duration-300 hover:bg-gray-50 hover:shadow-md">
                        <div class="bg-blue-100 p-3 rounded-lg transition-colors duration-300 hover:bg-blue-200">
                            <i class="fas fa-message text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <h4 class="font-semibold">{{ $inquiry->property->title }}</h4>
                                @if(!$inquiry->read_at)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                        New
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500">{{ $inquiry->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
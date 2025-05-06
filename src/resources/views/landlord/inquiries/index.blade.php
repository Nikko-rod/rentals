@extends('layouts.final-dashboard')
@section('title', 'My Inquiries | Rentals Tacloban')
@section('dashboard-title', 'Landlord Portal')
@section('page-title', 'Inquiries')



@section('sidebar-menu')
    <a href="{{ route('landlord.dashboard') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('landlord.dashboard') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-home w-5"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('landlord.properties.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('landlord.properties.*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-search w-5"></i>
        <span>Browse Properties</span>
    </a>

    <a href="{{ route('landlord.inquiries.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('landlord.inquiries.*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
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
<div class="max-w-7xl mx-auto space-y-4">
    <div class="flex justify-between items-center bg-white p-4 rounded-xl shadow-sm">
        <h1 class="text-lg font-semibold text-gray-800">My Inquiries</h1>
        <span class="text-sm text-gray-500">Total: {{ $inquiries->total() }}</span>
    </div>

    @if($inquiries->count() > 0)
        <div class="bg-white rounded-xl shadow-sm overflow-hidden divide-y divide-gray-100">
            @foreach($inquiries as $inquiry)
                <div class="p-5 hover:bg-gray-50/80 transition-all duration-300 cursor-pointer group" 
                     onclick="window.location.href='{{ route('landlord.inquiries.show', $inquiry) }}'">
                    <div class="space-y-3">
                        <!-- Property Title and Date -->
                        <div class="flex justify-between items-start gap-4">
                            <h3 class="font-medium text-gray-800 group-hover:text-green-700 transition-colors">
                                {{ $inquiry->property->title }}
                            </h3>
                            <span class="text-xs text-gray-500 whitespace-nowrap">
                                {{ $inquiry->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <!-- Message Preview -->
                        <div class="rounded-lg p-3 text-sm text-gray-600">
                            {{ Str::limit($inquiry->message, 100) }}
                        </div>

                        <!-- Property Details -->
                        <div class="flex flex-wrap items-center gap-3">
                            <!-- Price -->
                            <div class="flex items-center gap-2 bg-green-50 text-green-800 text-sm px-3 py-1.5 rounded-lg border border-green-100">
                                <i class="fas fa-peso-sign text-green-600"></i>
                                <span class="font-medium">{{ number_format($inquiry->quoted_monthly_rent, 2) }}</span>
                            </div>

                            <!-- Type -->
                            <div class="flex items-center gap-2 bg-purple-50 text-purple-800 text-sm px-3 py-1.5 rounded-lg border border-purple-100">
                                <i class="fas fa-home text-purple-600"></i>
                                <span>{{ ucfirst($inquiry->quoted_type) }}</span>
                            </div>

                            <!-- Contact -->
                            <div class="flex items-center gap-2 bg-blue-50 text-blue-800 text-sm px-3 py-1.5 rounded-lg border border-blue-100">
                                <i class="fas fa-phone text-blue-600"></i>
                                <span>{{ $inquiry->quoted_contact_number }}</span>
                            </div>

                            <!-- View arrow -->
                            <div class="ml-auto">
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-green-600 transition-colors"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $inquiries->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm p-8 text-center">
            <div class="flex flex-col items-center gap-3">
                <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gray-50">
                    <i class="fas fa-message text-2xl text-gray-400"></i>
                </div>
                <p class="text-sm text-gray-500">No inquiries yet</p>
                <a href="{{ route('landlord.properties.index') }}" 
                   class="inline-flex items-center justify-center px-4 py-2 bg-green-700 text-white text-sm rounded-lg hover:bg-green-800 transition duration-300">
                    <i class="fas fa-search mr-2"></i>
                    Browse Properties
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
@extends('layouts.final-dashboard')

@section('title', 'Browse Properties')
@section('dashboard-title', 'Tenant Portal')
@section('page-title', 'Available Properties')

@section('sidebar-menu')
    <a href="{{ route('tenant.dashboard') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105 
              {{ Request::routeIs('tenant.dashboard') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-home w-5"></i>
        <span>Dashboard</span>
    </a>
    
    <a href="{{ route('tenant.properties.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('tenant.properties.*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-search w-5"></i>
        <span>Browse Properties</span>
    </a>

    <a href="{{ route('tenant.inquiries.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('tenant.inquiries.*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-message w-5"></i>
        <span>Inquiries</span>
    </a>

    <a href="{{ route('tenant.profile') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('tenant.profile') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-user-circle w-5"></i>
        <span>Profile</span>
    </a>
@endsection

@section('content')
    <!-- Search and Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <form action="{{ route('tenant.properties.index') }}" method="GET" 
              class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Search Input -->
            <div class="lg:col-span-2">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search properties..."
                       class="w-full rounded-lg border-gray-300 focus:border-green-500 p-2 focus:ring focus:ring-green-200">
            </div>

            <!-- Property Type Filter -->
            <div>
                <select name="type" class="w-full rounded-lg border-gray-300 p-2 focus:border-green-500 focus:ring focus:ring-green-200">
                    <option value="">All Types</option>
                    <option value="bedspace" {{ request('type') == 'bedspace' ? 'selected' : '' }}>Bedspace</option>
                    <option value="room" {{ request('type') == 'room' ? 'selected' : '' }}>Room</option>
                    <option value="apartment" {{ request('type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                    <option value="house" {{ request('type') == 'house' ? 'selected' : '' }}>House</option>
                </select>
            </div>

            <!-- Available For Filter -->
            <div>
                <select name="available_for" class="w-full rounded-lg border-gray-300 p-2 focus:border-green-500 focus:ring focus:ring-green-200">
                    <option value="">Available For</option>
                    <option value="male" {{ request('available_for') == 'male' ? 'selected' : '' }}>Male Only</option>
                    <option value="female" {{ request('available_for') == 'female' ? 'selected' : '' }}>Female Only</option>
                    <option value="couples" {{ request('available_for') == 'couples' ? 'selected' : '' }}>Couples</option>
                    <option value="any" {{ request('available_for') == 'any' ? 'selected' : '' }}>Any</option>
                </select>
            </div>

            <!-- Sort By Price -->
            <div class="flex items-center gap-2">
                <select name="sort" class="w-full rounded-lg border-gray-300 p-2 focus:border-green-500 focus:ring focus:ring-green-200">
                    <option value="">Sort By Price</option>
                    <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Highest to Lowest</option>
                    <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Lowest to Highest</option>
                </select>

                <button type="submit" 
                        class="p-2.5 bg-green-700 text-white rounded-lg hover:bg-green-800 p-2 transition duration-300">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Properties Grid -->
    @if($properties->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($properties as $property)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden group hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <!-- Property Image -->
                    <div class="relative h-48">
                        @if($property->images->count() > 0)
                            <img src="{{ Storage::url($property->images->first()->image_path) }}" 
                                 alt="{{ $property->title }}"
                                 class="w-full h-full object-cover"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-home text-gray-400 text-3xl"></i>
                            </div>
                        @endif

       
                    
                        <!-- Property Status -->
                                            <div class="absolute bottom-2 left-2">
                        @if($property->is_available)
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                Available
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                Not Available
                            </span>
                        @endif
                    </div>  
                    </div>

                    <!-- Property Details -->
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-800 truncate flex-1" title="{{ $property->title }}">
                                {{ $property->title }}
                            </h3>
                            <p class="text-green-700 font-semibold whitespace-nowrap ml-2">
                                ₱{{ number_format($property->monthly_rent) }}/mo
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-4 mt-3">
                            <span class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-home mr-1 text-gray-400"></i>
                                {{ ucfirst($property->type) }}
                            </span>
                            <span class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-users mr-1 text-gray-400"></i>
                                {{ ucfirst($property->available_for) }}
                            </span>
                        </div>

                        <!-- View Details Link -->
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('tenant.properties.show', $property) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition duration-300">
                                <i class="fas fa-eye mr-2"></i>
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $properties->links() }} 
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-xl shadow-sm">
            <i class="fas fa-search text-gray-400 text-5xl mb-4"></i>
            <p class="text-gray-600">No properties found matching your criteria</p>
        </div>
    @endif
@endsection
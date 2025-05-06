@extends('layouts.final-dashboard')
@section('title', 'Browse Properties')
@section('dashboard-title', 'Tenant Portal')
@section('page-title', 'View Property')

@push('styles')
<style>
    /* Aspect ratio container */
    .aspect-w-4 {
        position: relative;
        padding-bottom: 75%;
    }

    .aspect-w-4 > a {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    .aspect-w-4 img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Lightbox customization */
    .lb-outerContainer {
        max-height: 85vh !important;
        background-color: white !important;
        border-radius: 8px 8px 0 0 !important;
    }

    .lb-container {
        padding: 12px !important;
    }

    .lb-image {
        border: none !important;
        border-radius: 4px !important;
        object-fit: contain !important;
        max-height: 80vh !important;
    }

    .lb-dataContainer {
        background-color: white !important;
        border-radius: 0 0 8px 8px !important;
        padding: 12px !important;
    }
</style>
@endpush

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
    <!-- Main Container -->
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Back Button and Title -->
        <div class="flex items-center gap-4 bg-white p-4 rounded-xl shadow-sm">
            <a href="{{ route('landlord.properties.index') }}" 
               class="p-2.5 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition duration-300">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $property->title }}</h1>
                <p class="text-gray-500 mt-1">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    {{ $property->address }}
                </p>
            </div>
        </div>

        <!-- Image Gallery -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800">Property Gallery</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 p-6">
                @forelse($property->images as $key => $image)
                    <div class="relative {{ $key === 0 ? 'col-span-2 row-span-2' : '' }} rounded-lg overflow-hidden group shadow-sm">
                        <div class="aspect-w-4 aspect-h-3 w-full h-full">
                            <a href="{{ Storage::url($image->image_path) }}" 
                               data-lightbox="property-gallery"
                               data-title="{{ $property->title }} - Image {{ $key + 1 }}"
                               class="block w-full h-full">
                                <img src="{{ Storage::url($image->image_path) }}" 
                                     alt="Property image {{ $key + 1 }}"
                                     class="w-full h-full object-cover transition duration-300 group-hover:scale-105"
                                     loading="{{ $key === 0 ? 'eager' : 'lazy' }}"
                                     onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}'">
                                
                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-20 transition-opacity duration-300">
                                    <div class="absolute bottom-3 right-3 bg-black/70 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                                        <i class="fas fa-search-plus"></i>
                                        <span>View</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-12 bg-gray-50 rounded-lg">
                        <div class="text-center">
                            <i class="fas fa-image text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No images available for this property</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Property Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 space-y-6">
                        <!-- Price -->
                        <div class="flex items-center text-2xl font-bold text-gray-800">
                            <i class="fas fa-peso-sign mr-2 text-green-600"></i>
                            {{ number_format($property->monthly_rent, 2) }}/month
                        </div>

                        <!-- Type and Availability -->
                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-800 rounded-full">
                                <i class="fas fa-home"></i>
                                <span>{{ ucfirst($property->type) }}</span>
                            </div>
                            <div class="flex items-center gap-2 px-3 py-1 bg-purple-100 text-purple-800 rounded-full">
                                <i class="fas fa-users"></i>
                                <span>For {{ ucfirst($property->available_for) }}</span>
                            </div>
                            <div class="flex items-center gap-2 px-3 py-1 {{ $property->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full">
                                <i class="fas {{ $property->is_available ? 'fa-check' : 'fa-times' }}"></i>
                                <span>{{ $property->is_available ? 'Available' : 'Not Available' }}</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="prose max-w-none">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Description</h3>
                            <p class="text-gray-600 whitespace-pre-line">{{ $property->description ?: 'No description provided' }}</p>
                        </div>
                    </div>
                </div>

               <!-- Action Buttons -->
@if(auth()->id() === $property->user_id)
    <div class="flex gap-4">
        <a href="{{ route('landlord.properties.edit', $property) }}" 
           class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
            <i class="fas fa-edit mr-2"></i>
            Edit Property
        </a>
        <form action="{{ route('landlord.properties.destroy', $property) }}" 
              method="POST" 
              class="flex-1"
              onsubmit="return confirm('Are you sure you want to delete this property?');">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300">
                <i class="fas fa-trash-alt mr-2"></i>
                Delete Property
            </button>
        </form>
    </div>
@endif

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Owner Info -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800">Property Details</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg mb-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Property Owner</p>
                                <p class="font-medium text-gray-800">{{ $property->user->first_name }} {{ $property->user->last_name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-phone text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Contact Number</p>
                                <p class="font-medium text-gray-800">{{ $property->contact_number ?: 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

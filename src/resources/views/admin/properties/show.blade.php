@extends('layouts.final-dashboard')

@section('title', 'Property Details')

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
              {{ Request::routeIs('admin.properties.*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-home w-5"></i>
        <span>Manage Properties</span>
    </a>
@endsection
@push('styles')
<style>
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

    .col-span-2.row-span-2 .aspect-w-4 {
        padding-bottom: 75%;
    }
</style>
@endpush
@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.properties.index') }}" 
                       class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-xl font-semibold text-gray-800">{{ $property->title }}</h1>
                </div>
                <span class="px-3 py-1 rounded-full text-sm font-medium 
                    {{ $property->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $property->is_available ? 'Available' : 'Not Available' }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
           <!-- Images Section -->
           <div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h2 class="text-lg font-semibold text-gray-800">Property Gallery</h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 p-6">
        @forelse($property->images as $key => $image)
            <div class="relative {{ $key === 0 ? 'col-span-2 row-span-2' : '' }} rounded-lg overflow-hidden group shadow-sm">
                <div class="aspect-w-4 aspect-h-3 w-full h-full">
                    <a href="{{ Storage::url($image->path) }}" 
                       data-lightbox="property-gallery"
                       data-title="{{ $property->title }} - Image {{ $key + 1 }}"
                       class="block w-full h-full">
                        <img src="{{ Storage::url($image->path) }}" 
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

            <!-- Description -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Description</h2>
                    <p class="text-gray-600 whitespace-pre-line">{{ $property->description }}</p>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Property Details -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Property Details</h2>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm text-gray-500">Monthly Rent</dt>
                            <dd class="text-lg font-medium text-gray-800">₱{{ number_format($property->monthly_rent, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Type</dt>
                            <dd class="text-gray-800">{{ ucfirst($property->type) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Available For</dt>
                            <dd class="text-gray-800">{{ ucfirst($property->available_for) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Address</dt>
                            <dd class="text-gray-800">{{ $property->address }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Contact Number</dt>
                            <dd class="text-gray-800">{{ $property->contact_number }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Owner Details -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Owner Details</h2>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-green-700 text-white flex items-center justify-center text-xl">
                            {{ strtoupper(substr($property->owner->first_name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">{{ $property->owner->full_name }}</h3>
                            <p class="text-sm text-gray-500">{{ $property->owner->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<script>
    lightbox.option({
        'resizeDuration': 300,
        'wrapAround': true,
        'fadeDuration': 300,
        'imageFadeDuration': 300,
        'disableScrolling': true,
        'fitImagesInViewport': true,
        'maxWidth': Math.min(1200, window.innerWidth * 0.9),
        'maxHeight': window.innerHeight * 0.85,
        'positionFromTop': 50,
        'alwaysShowNavOnTouchDevices': true,
        'showImageNumberLabel': true,
        'albumLabel': 'Image %1 of %2'
    });

    window.addEventListener('resize', function() {
        lightbox.option({
            'maxWidth': Math.min(1200, window.innerWidth * 0.9),
            'maxHeight': window.innerHeight * 0.85
        });
    });
</script>
@endpush
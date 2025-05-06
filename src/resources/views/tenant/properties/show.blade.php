@extends('layouts.final-dashboard')

@section('title', $property->title . ' | Rentals Tacloban')
@section('dashboard-title', 'Tenant Portal')
@section('page-title', 'Property Details')

@push('styles')
<style>
    .aspect-w-4 {
        position: relative;
        padding-bottom: 75%; /* 4:3 Aspect Ratio (divide 3 by 4 = 0.75) */
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

    /* First image styling */
    .col-span-2.row-span-2 .aspect-w-4 {
        padding-bottom: 75%; /* Maintain aspect ratio for larger image */
    }
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
    }

    .lb-dataContainer {
        background-color: white !important;
        border-radius: 0 0 8px 8px !important;
        padding: 12px !important;
    }

    .lightbox {
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
    }

    /* Improve navigation visibility */
    .lb-nav a.lb-prev,
    .lb-nav a.lb-next {
        opacity: 0.8;
        filter: brightness(0.7) !important;
    }

    .lb-nav a.lb-prev:hover,
    .lb-nav a.lb-next:hover {
        opacity: 1;
    }

</style>
@endpush


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
    <!-- Main Container -->
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Back Button and Title -->
        <div class="flex items-center gap-4 bg-white p-4 rounded-xl shadow-sm">
            <a href="{{ route('tenant.properties.index') }}" 
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
                             onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}'"
                             >
                        
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

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Quick Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white p-4 rounded-xl shadow-sm">
                        <p class="text-sm text-gray-500 mb-1">Monthly Rent</p>
                        <p class="text-xl font-semibold text-green-700">₱{{ number_format($property->monthly_rent) }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm">
                        <p class="text-sm text-gray-500 mb-1">Property Type</p>
                        <p class="text-xl font-semibold text-gray-800">{{ ucfirst($property->type) }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm">
                        <p class="text-sm text-gray-500 mb-1">Available For</p>
                        <p class="text-xl font-semibold text-gray-800">{{ ucfirst($property->available_for) }}</p>
                    </div>
                </div>

                <!-- Property Details -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800">Property Details</h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="prose max-w-none">
                            <p class="text-gray-600 whitespace-pre-line">{{ $property->description ?: 'No description provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Contact Card -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800">Contact Owner</h2>
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

                <!-- Inquiry Form -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800">Send Inquiry</h2>
                    </div>
                                                    <div class="p-6">
                                    <form action="{{ route('tenant.inquiries.store', $property) }}" method="POST">
                                        @csrf
                                        <div class="space-y-4">
                                            <div class="relative">
                                                <textarea name="message" 
                                                        id="message" 
                                                        rows="6" 
                                                        maxlength="250"
                                                        placeholder="Write your message here..."
                                                        class="w-full rounded-lg border-gray-300 p-2 focus:border-green-500 focus:ring focus:ring-green-200 resize-none text-base"
                                                        required>{{ old('message') }}</textarea>
                                                <div class="absolute bottom-2 right-2 text-sm text-gray-500">
                                                    <span id="charCount">0</span>/250
                                                </div>
                                            </div>
                                            @error('message')
                                                <p class="text-red-600 text-sm">{{ $message }}</p>
                                            @enderror

                                            <button type="submit" 
                                                    class="w-full px-6 py-3 bg-green-700 text-white rounded-lg hover:bg-green-800 transition duration-300 flex items-center justify-center gap-2 font-medium">
                                                <i class="fas fa-paper-plane"></i>
                                                <span>Send Inquiry</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
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
        'albumLabel': 'Image %1 of %2',
        'containerPadding': 12,
        'imagePadding': 12
    });

    // Ensure proper sizing on window resize
    window.addEventListener('resize', function() {
        lightbox.option({
            'maxWidth': Math.min(1200, window.innerWidth * 0.9),
            'maxHeight': window.innerHeight * 0.85
        });
    });

    // Fix modal positioning after image load
    $(document).on('loaded.lb', function() {
        setTimeout(function() {
            $('.lightbox').css({
                'position': 'fixed',
                'top': '50%',
                'left': '50%',
                'transform': 'translate(-50%, -50%)'
            });
        }, 0);
    });


    document.addEventListener('DOMContentLoaded', function() {
    const messageInput = document.getElementById('message');
    const charCount = document.getElementById('charCount');

    function updateCharCount() {
        const count = messageInput.value.length;
        charCount.textContent = count;
        
        if (count >= 200) {
            charCount.classList.add('text-yellow-600');
        } else if (count >= 240) {
            charCount.classList.remove('text-yellow-600');
            charCount.classList.add('text-red-600');
        } else {
            charCount.classList.remove('text-yellow-600', 'text-red-600');
        }
    }

    messageInput.addEventListener('input', updateCharCount);
    messageInput.addEventListener('keyup', updateCharCount);
    
    // Initialize counter
    updateCharCount();
});

</script>
@endpush
@endsection
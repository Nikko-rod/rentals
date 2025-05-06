@extends('layouts.final-dashboard')

@section('title', 'Edit Property')
@section('dashboard-title', 'Landlord Portal')
@section('page-title', 'Edit Property')


@push('styles')
<style>
    .toggle-checkbox:checked {
        @apply right-0 border-green-700;
        background-color: #047857;
    }
    .toggle-checkbox:checked + .toggle-label {
        @apply bg-green-700;
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
        <i class="fas fa-building w-5"></i>
        <span>Properties</span>
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
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex items-center gap-4 bg-white p-4 rounded-xl shadow-sm">
        <a href="{{ route('landlord.properties.index') }}" 
           class="p-2.5 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition duration-300">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Property</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Current Images</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-6">
            @forelse($property->images as $image)
                <div class="relative aspect-w-4 aspect-h-3 rounded-lg overflow-hidden group">
                    <img src="{{ Storage::url($image->image_path) }}" 
                         alt="Property image" 
                         class="w-full h-full object-cover">
                    <form action="{{ route('landlord.properties.deleteImage', $image->id) }}" 
                          method="POST" 
                          class="absolute top-2 right-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to delete this image?')"
                                class="bg-black/50 hover:bg-black/70 text-white rounded-full w-8 h-8 flex items-center justify-center transition duration-300">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full p-12 bg-gray-50 rounded-lg">
                    <div class="text-center">
                        <i class="fas fa-image text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No images uploaded yet</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Property Details</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('landlord.properties.update', $property) }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $property->title) }}" 
                           required 
                           class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring-green-500">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <div class="relative">
                                <textarea id="description" 
                                        name="description" 
                                        required 
                                        rows="4"
                                        maxlength="500"
                                        class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring-green-500"
                                        oninput="updateCharacterCount(this)">{{ old('description', $property->description) }}</textarea>
                                <div class="absolute bottom-2 right-2 text-sm text-gray-500">
                                    <span id="characterCount">0</span>/500 characters
                                </div>
                            </div>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                <!-- Two Column Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Contact Number -->
                    <div>
                        <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                        <input type="text" 
                               id="contact_number" 
                               name="contact_number" 
                               value="{{ old('contact_number', $property->contact_number) }}" 
                               required 
                               class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring-green-500">
                        @error('contact_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Monthly Rent -->
                    <div>
                        <label for="monthly_rent" class="block text-sm font-medium text-gray-700">Monthly Rent (₱)</label>
                        <input type="number" 
                               id="monthly_rent" 
                               name="monthly_rent" 
                               value="{{ old('monthly_rent', $property->monthly_rent) }}" 
                               required 
                               min="0" 
                               step="0.01" 
                               class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring-green-500">
                        @error('monthly_rent')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Property Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Property Type</label>
                        <select id="type" 
                                name="type" 
                                required 
                                class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring-green-500">
                            <option value="bedspace" {{ old('type', $property->type) == 'bedspace' ? 'selected' : '' }}>Bedspace</option>
                            <option value="room" {{ old('type', $property->type) == 'room' ? 'selected' : '' }}>Room</option>
                            <option value="apartment" {{ old('type', $property->type) == 'apartment' ? 'selected' : '' }}>Apartment</option>
                            <option value="house" {{ old('type', $property->type) == 'house' ? 'selected' : '' }}>House</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Available For -->
                    <div>
                        <label for="available_for" class="block text-sm font-medium text-gray-700">Available For</label>
                        <select id="available_for" 
                                name="available_for" 
                                required 
                                class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring-green-500">
                            <option value="male" {{ old('available_for', $property->available_for) == 'male' ? 'selected' : '' }}>Male Only</option>
                            <option value="female" {{ old('available_for', $property->available_for) == 'female' ? 'selected' : '' }}>Female Only</option>
                            <option value="couples" {{ old('available_for', $property->available_for) == 'couples' ? 'selected' : '' }}>Couples</option>
                            <option value="any" {{ old('available_for', $property->available_for) == 'any' ? 'selected' : '' }}>Any</option>
                        </select>
                        @error('available_for')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" 
                           id="address" 
                           name="address" 
                           value="{{ old('address', $property->address) }}" 
                           required 
                           class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring-green-500">
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Availability Toggle -->
                                        <div class="flex items-center gap-3">
                            <label for="is_available" class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                    id="is_available" 
                                    name="is_available" 
                                    class="sr-only peer" 
                                    {{ $property->is_available ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none p-2 peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                            <span class="text-sm font-medium text-gray-700">Available for Rent</span>
                        </div>

                <!-- Add New Images -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Add New Images</label>
                    <input type="file" 
                           name="images[]" 
                           accept="image/*" 
                           multiple 
                           class="mt-1 block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-medium
                                  file:bg-green-50 file:text-green-700
                                  hover:file:bg-green-100">
                    <p class="mt-1 text-sm text-gray-500">Upload additional images (JPEG, PNG, JPG)</p>
                    @error('images')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-4 pt-4">
                    <a href="{{ route('landlord.properties.index') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-green-700 border border-transparent rounded-md shadow-sm hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Update Property
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>

    const toggleCheckbox = document.getElementById('is_available');
    const toggleLabel = toggleCheckbox.nextElementSibling.nextElementSibling;
    
    toggleCheckbox.addEventListener('change', function() {
        toggleLabel.textContent = this.checked ? 'Available' : 'Not Available';
    });

    function updateCharacterCount(textarea) {
        const maxLength = 500;
        const currentLength = textarea.value.length;
        const counterElement = document.getElementById('characterCount');
        
        counterElement.textContent = currentLength;
        
        if (currentLength >= maxLength) {
            counterElement.classList.add('text-red-500');
        } else {
            counterElement.classList.remove('text-red-500');
        }
    }

    // Initialize character count on page load
    document.addEventListener('DOMContentLoaded', function() {
        const description = document.getElementById('description');
        updateCharacterCount(description);
    });
</script>
@endpush
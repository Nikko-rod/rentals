@extends('layouts.final-dashboard')

@section('title', 'Add New Property')
@section('dashboard-title', 'Landlord Portal')
@section('page-title', 'Add New Property')
@section('head')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@endsection
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
<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('landlord.properties.index') }}" 
           class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition duration-300">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-xl font-semibold">Add New Property</h2>
    </div>

    <form action="{{ route('landlord.properties.store') }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="max-w-3xl">
        @csrf

        <!-- Basic Information -->
        <div class="space-y-6">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}" 
                       required 
                       maxlength="100"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 p-2 focus:ring focus:ring-green-200">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description tinymce -->
            <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea id="description" 
                  name="description" 
                  required>{{ old('description') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

            <!-- Two Column Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Contact Number -->
                <div>
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="text" 
                           id="contact_number" 
                           name="contact_number" 
                           value="{{ old('contact_number', auth()->user()->contact_number) }}" 
                           required 
                           pattern="[0-9]{11}"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-2 focus:border-green-500 focus:ring focus:ring-green-200">
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
                           value="{{ old('monthly_rent') }}" 
                           required 
                           min="0" 
                           step="0.01"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-2 focus:border-green-500 focus:ring focus:ring-green-200">
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
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-2 focus:border-green-500 focus:ring focus:ring-green-200">
                        <option value="">Select Type</option>
                        <option value="bedspace" {{ old('type') == 'bedspace' ? 'selected' : '' }}>Bedspace</option>
                        <option value="room" {{ old('type') == 'room' ? 'selected' : '' }}>Room</option>
                        <option value="apartment" {{ old('type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                        <option value="house" {{ old('type') == 'house' ? 'selected' : '' }}>House</option>
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
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-2 focus:border-green-500 focus:ring focus:ring-green-200">
                        <option value="">Select Availability</option>
                        <option value="male" {{ old('available_for') == 'male' ? 'selected' : '' }}>Male Only</option>
                        <option value="female" {{ old('available_for') == 'female' ? 'selected' : '' }}>Female Only</option>
                        <option value="couples" {{ old('available_for') == 'couples' ? 'selected' : '' }}>Couples</option>
                        <option value="any" {{ old('available_for') == 'any' ? 'selected' : '' }}>Any</option>
                    </select>
                    @error('available_for')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea id="address" 
                          name="address" 
                          required 
                          rows="2"
                          class="mt-1 block w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- availability auto -->
            <input type="hidden" name="is_available" value="1">

            <!-- Images -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Property Images</label>
                <div class="mt-1">
                    <input type="file" 
                           name="images[]" 
                           accept="image/*" 
                           multiple 
                           required 
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                </div>
                <p class="mt-2 text-sm text-gray-500">Upload up to 5 images (JPEG, PNG, JPG)</p>
                @error('images')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="mt-8 flex justify-end gap-4">
            <a href="{{ route('landlord.properties.index') }}" 
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Cancel
            </a>
            <button type="submit" 
                    class="px-4 py-2 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Create Property
            </button>
        </div>
    </form>
</div>
@endsection

<div>
    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
    <textarea id="description" 
              name="description" 
              required>{{ old('description') }}</textarea>
    @error('description')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

@push('scripts')
<script>
    tinymce.init({
        selector: '#description',
        height: 300,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview',
            'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic | alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | removeformat',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }',
        branding: false,
        skin: "oxide",
        promotion: false,
        setup: function(editor) {
            editor.on('keyup', function() {
                // Optional: Add character limit
                if (editor.getContent().length > 1000) {
                    editor.setContent(editor.getContent().substr(0, 1000));
                }
            });
        }
    });
</script>
@endpush
@extends('layouts.dashboard')

@section('title', 'Edit Property | Rentals Tacloban')

@section('sidebar')
    <li class="nav-item">
        <a href="{{ route('landlord.dashboard') }}" class="nav-link">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('landlord.properties.index') }}" class="nav-link active">
            <i class="fas fa-building"></i>
            <span>Properties</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="fas fa-message"></i>
            <span>Inquiries</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('landlord.profile') }}" class="nav-link">
            <i class="fas fa-user-circle"></i>
            <span>Profile</span>
        </a>
    </li>
@endsection

@section('content')
<div class="content-card">
    <div style="display: flex; align-items: center; margin-bottom: 2rem;">
        <a href="{{ route('landlord.properties.index') }}" 
           style="margin-right: 1rem; color: var(--text-light);">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 style="font-size: 1.5rem; font-weight: 600;">Edit Property</h1>
    </div>

    <!-- Current Images Section -->
    <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.1rem; font-weight: 500; margin-bottom: 1rem;">Current Images</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem;">
            @forelse($property->images as $image)
                <div style="position: relative; padding-bottom: 100%;">
                    <img src="{{ Storage::url($image->image_path) }}" 
                         alt="Property image" 
                         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 0.5rem;">
                    <form action="{{ route('landlord.properties.deleteImage', $image->id) }}" 
                          method="POST" 
                          style="position: absolute; top: 0.5rem; right: 0.5rem;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to delete this image?')"
                                style="background: rgba(0,0,0,0.5); color: white; border: none; border-radius: 50%; width: 2rem; height: 2rem; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                </div>
            @empty
                <p style="color: var(--text-light);">No images uploaded yet</p>
            @endforelse
        </div>
    </div>

    <form action="{{ route('landlord.properties.update', $property) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          style="max-width: 800px;">
        @csrf
        @method('PUT')

        <!-- Same form fields as create.blade.php but with $property values -->
        <!-- Title -->
        <div style="margin-bottom: 1.5rem;">
            <label for="title" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Title</label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="{{ old('title', $property->title) }}" 
                   required 
                   style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 0.5rem;"
                   maxlength="100">
            @error('title')
                <p style="color: var(--error); margin-top: 0.5rem; font-size: 0.875rem;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div style="margin-bottom: 1.5rem;">
            <label for="description" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Description</label>
            <textarea id="description" 
                      name="description" 
                      required 
                      style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 0.5rem; min-height: 100px;"
                      maxlength="500">{{ old('description', $property->description) }}</textarea>
            @error('description')
                <p style="color: var(--error); margin-top: 0.5rem; font-size: 0.875rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
            <!-- Contact Number -->
            <div>
                <label for="contact_number" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Contact Number</label>
                <input type="text" 
                       id="contact_number" 
                       name="contact_number" 
                       value="{{ old('contact_number', auth()->user()->contact_number) }}" 
                       required 
                       style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 0.5rem;"
                       pattern="[0-9]{11}">
                @error('contact_number')
                    <p style="color: var(--error); margin-top: 0.5rem; font-size: 0.875rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Monthly Rent -->
            <div>
                <label for="monthly_rent" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Monthly Rent (₱)</label>
                <input type="number" 
                       id="monthly_rent" 
                       name="monthly_rent" 
                       value="{{ old('monthly_rent', $property->monthly_rent) }}" 
                       required 
                       min="0" 
                       step="0.01" 
                       style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 0.5rem;">
                @error('monthly_rent')
                    <p style="color: var(--error); margin-top: 0.5rem; font-size: 0.875rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Property Type -->
            <div>
    <label for="type" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Property Type</label>
    <select id="type" 
            name="type" 
            required 
            style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 0.5rem;">
        <option value="bedspace" {{ (old('type', $property->type) == 'bedspace') ? 'selected' : '' }}>Bedspace</option>
        <option value="room" {{ (old('type', $property->type) == 'room') ? 'selected' : '' }}>Room</option>
        <option value="apartment" {{ (old('type', $property->type) == 'apartment') ? 'selected' : '' }}>Apartment</option>
        <option value="house" {{ (old('type', $property->type) == 'house') ? 'selected' : '' }}>House</option>
    </select>
    @error('type')
        <p style="color: var(--error); margin-top: 0.5rem; font-size: 0.875rem;">{{ $message }}</p>
    @enderror
</div>

            <!-- Available For -->
            <div>
    <label for="available_for" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Available For</label>
    <select id="available_for" 
            name="available_for" 
            required 
            style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 0.5rem;">
        <option value="male" {{ (old('available_for', $property->available_for) == 'male') ? 'selected' : '' }}>Male Only</option>
        <option value="female" {{ (old('available_for', $property->available_for) == 'female') ? 'selected' : '' }}>Female Only</option>
        <option value="couples" {{ (old('available_for', $property->available_for) == 'couples') ? 'selected' : '' }}>Couples</option>
        <option value="any" {{ (old('available_for', $property->available_for) == 'any') ? 'selected' : '' }}>Any</option>
    </select>
    @error('available_for')
        <p style="color: var(--error); margin-top: 0.5rem; font-size: 0.875rem;">{{ $message }}</p>
    @enderror
</div>
                <!-- Address -->
                <div>
                    <label for="address" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Address</label>
                    <input type="text" 
                        id="address" 
                        name="address" 
                        value="{{ old('address', $property->address) }}" 
                        required 
                        style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 0.5rem;"
                        maxlength="255">
                    @error('address')
                        <p style="color: var(--error); margin-top: 0.5rem; font-size: 0.875rem;">{{ $message }}</p>
                    @enderror
                </div>
        </div>
        <!-- Add New Images -->
        <div style="margin-top: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Add New Images</label>
            <input type="file" 
                   name="images[]" 
                   accept="image/*" 
                   multiple 
                   style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 0.5rem;">
            <p style="color: var(--text-light); margin-top: 0.5rem; font-size: 0.875rem;">Upload additional images (JPEG, PNG, JPG)</p>
            @error('images')
                <p style="color: var(--error); margin-top: 0.5rem; font-size: 0.875rem;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Buttons -->
        <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('landlord.properties.index') }}" 
               style="padding: 0.75rem 1.5rem; border-radius: 0.5rem; background: var(--secondary); color: var(--text); text-decoration: none;">
                Cancel
            </a>
            <button type="submit" 
                    style="padding: 0.75rem 1.5rem; border-radius: 0.5rem; background: var(--primary); color: var(--white); border: none; cursor: pointer;">
                Update Property
            </button>
        </div>
    </form>
</div>
@endsection
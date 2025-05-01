@extends('layouts.dashboard')

@section('title', 'Add New Property | Rentals Tacloban')

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
        <h1 style="font-size: 1.5rem; font-weight: 600;">Add New Property</h1>
    </div>

    <form action="{{ route('landlord.properties.store') }}" 
          method="POST" 
          enctype="multipart/form-data" 
          style="max-width: 800px;">
        @csrf

        <!-- Title -->
        <div style="margin-bottom: 1.5rem;">
            <label for="title" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Title</label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="{{ old('title') }}" 
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
                      maxlength="500">{{ old('description') }}</textarea>
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
                       value="{{ old('monthly_rent') }}" 
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
                    <option value="">Select Type</option>
                    <option value="bedspace" {{ old('type') == 'bedspace' ? 'selected' : '' }}>Bedspace</option>
                    <option value="room" {{ old('type') == 'room' ? 'selected' : '' }}>Room</option>
                    <option value="apartment" {{ old('type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                    <option value="house" {{ old('type') == 'house' ? 'selected' : '' }}>House</option>
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
                    <option value="">Select Availability</option>
                    <option value="male" {{ old('available_for') == 'male' ? 'selected' : '' }}>Male Only</option>
                    <option value="female" {{ old('available_for') == 'female' ? 'selected' : '' }}>Female Only</option>
                    <option value="couples" {{ old('available_for') == 'couples' ? 'selected' : '' }}>Couples</option>
                    <option value="any" {{ old('available_for') == 'any' ? 'selected' : '' }}>Any</option>
                </select>
                @error('available_for')
                    <p style="color: var(--error); margin-top: 0.5rem; font-size: 0.875rem;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Address -->
        <div style="margin-top: 1.5rem;">
            <label for="address" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Address</label>
            <textarea id="address" 
                      name="address" 
                      required 
                      style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 0.5rem;">{{ old('address') }}</textarea>
            @error('address')
                <p style="color: var(--error); margin-top: 0.5rem; font-size: 0.875rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-top: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Property Images</label>
            <input type="file" 
                   name="images[]" 
                   accept="image/*" 
                   multiple 
                   required 
                   style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 0.5rem;">
            <p style="color: var(--text-light); margin-top: 0.5rem; font-size: 0.875rem;">Upload up to 5 images (JPEG, PNG, JPG)</p>
            @error('images')
                <p style="color: var(--error); margin-top: 0.5rem; font-size: 0.875rem;">{{ $message }}</p>
            @enderror
        </div>
        <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('landlord.properties.index') }}" 
               style="padding: 0.75rem 1.5rem; border-radius: 0.5rem; background: var(--secondary); color: var(--text); text-decoration: none;">
                Cancel
            </a>
            <button type="submit" 
                    style="padding: 0.75rem 1.5rem; border-radius: 0.5rem; background: var(--primary); color: var(--white); border: none; cursor: pointer;">
                Create Property
            </button>
        </div>
    </form>
</div>
@endsection
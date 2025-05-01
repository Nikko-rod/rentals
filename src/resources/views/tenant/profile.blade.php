@extends('layouts.dashboard')

@section('title', 'Profile | Rentals Tacloban')

@section('styles')
<style>
    .profile-container {
        max-width: 768px;
        margin: 0 auto;
        padding: 1.5rem;
    }

    .card {
        background: var(--white);
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-input {
        width: 100%;
        padding: 0.625rem;
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(20, 83, 45, 0.1);
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1rem;
        background: var(--primary);
        color: var(--white);
        border: none;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        background: var(--primary-light);
    }

    .error-text {
        color: var(--danger);
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }
</style>
@endsection

@section('sidebar')
    <li class="nav-item">
        <a href="{{ route('tenant.dashboard') }}" class="nav-link">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('tenant.properties.index') }}" class="nav-link">
            <i class="fas fa-search"></i>
            <span>Browse Properties</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="fas fa-message"></i>
            <span>Inquiries</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('tenant.profile') }}" class="nav-link active">
            <i class="fas fa-user-circle"></i>
            <span>Profile</span>
        </a>
    </li>
@endsection

@section('content')
<div class="profile-container">
    <div class="card">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold">Profile Information</h2>
        </div>

        <form action="{{ route('tenant.profile.update') }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                <div class="space-y-1">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" 
                           name="first_name" 
                           id="first_name" 
                           value="{{ old('first_name', $user->first_name) }}" 
                           class="form-input"
                           required>
                    @error('first_name')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" 
                           name="last_name" 
                           id="last_name" 
                           value="{{ old('last_name', $user->last_name) }}" 
                           class="form-input"
                           required>
                    @error('last_name')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-1 mt-4">
                <label for="contact_number" class="form-label">Contact Number</label>
                <input type="tel" 
                       name="contact_number" 
                       id="contact_number" 
                       value="{{ old('contact_number', $user->contact_number) }}" 
                       class="form-input"
                       required>
                @error('contact_number')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="border-t mt-6 pt-6">
                <div class="space-y-1">
                    <label for="current_password" class="form-label">Current Password to Confirm Changes</label>
                    <input type="password" 
                           name="current_password" 
                           id="current_password" 
                           class="form-input"
                           required>
                    @error('current_password')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
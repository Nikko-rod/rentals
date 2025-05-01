@extends('layouts.dashboard')

@section('title', $property->title . ' | Rentals Tacloban')
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
        <h1 style="font-size: 1.5rem; font-weight: 600;">Property Details</h1>
    </div>

    <!-- Property Images -->
    <div style="margin-bottom: 2rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            @foreach($property->images as $image)
                <div style="position: relative; padding-top: 75%;">
                    <img src="{{ Storage::url($image->image_path) }}" 
                         alt="Property image"
                         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 0.5rem;">
                </div>
            @endforeach
        </div>
    </div>

    <!-- Property Information -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Main Content -->
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem;">{{ $property->title }}</h2>
            
            <div style="display: flex; gap: 2rem; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--primary);">
                    <i class="fas fa-money-bill"></i>
                    <span style="font-size: 1.25rem; font-weight: 600;">₱{{ number_format($property->monthly_rent, 2) }}/month</span>
                </div>
                
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $property->address }}</span>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
                <span style="padding: 0.5rem 1rem; background: var(--secondary); border-radius: 0.5rem;">
                    <i class="fas fa-home"></i> {{ ucfirst($property->type) }}
                </span>
                <span style="padding: 0.5rem 1rem; background: var(--secondary); border-radius: 0.5rem;">
                    <i class="fas fa-users"></i> For {{ ucfirst($property->available_for) }}
                </span>
            </div>

            <div style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Description</h3>
                <p style="line-height: 1.6; color: var(--text-dark);">{{ $property->description }}</p>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <div style="background: var(--white); padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">Contact Information</h3>
                
                <div style="margin-bottom: 1rem;">
                    <p style="font-weight: 500; margin-bottom: 0.25rem;">Owner</p>
                    <p>{{ $property->owner->first_name }} {{ $property->owner->last_name }}</p>
                </div>

                <div style="margin-bottom: 1rem;">
                    <p style="font-weight: 500; margin-bottom: 0.25rem;">Contact Number</p>
                    <p>{{ $property->contact_number }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
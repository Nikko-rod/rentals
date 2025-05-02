@extends('layouts.dashboard')

@section('title', $property->title . ' | Rentals Tacloban')

@section('styles')
<style>
    .property-images {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
        max-width: 100%;
    }

    .image-container {
        position: relative;
        padding-top: 75%;
        border-radius: 0.5rem;
        overflow: hidden;
        background: var(--secondary);
    }

    .image-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .image-container:hover img {
        transform: scale(1.05);
    }

    .property-info {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
        gap: 2rem;
    }

    .info-card {
        background: var(--white);
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        height: fit-content;
    }

    .property-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        word-break: break-word;
        line-height: 1.3;
    }

    .property-price {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary);
        white-space: nowrap;
    }

    .property-address {
        word-break: break-word;
        max-width: 100%;
    }

    .property-description {
        line-height: 1.6;
        color: var(--text-dark);
        white-space: pre-line;
        word-break: break-word;
        max-height: 300px;
        overflow-y: auto;
        padding-right: 1rem;
    }

    .badge {
        padding: 0.5rem 1rem;
        background: var(--secondary);
        border-radius: 0.5rem;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .contact-info {
        word-break: break-word;
    }

    @media (max-width: 1024px) {
        .property-info {
            grid-template-columns: 1fr;
        }
    }
    
</style>
@endsection


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
        <a href="{{ route('landlord.inquiries.index') }}" class="nav-link">
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
    <div class="property-images">
        @forelse($property->images as $image)
            <div class="image-container">
                <img src="{{ Storage::url($image->image_path) }}" 
                     alt="Property image"
                     onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}';">
            </div>
        @empty
            <div class="image-container">
                <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-home" style="font-size: 3rem; color: var(--text-light);"></i>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Property Information -->
    <div class="property-info">
        <!-- Main Content -->
        <div>
            <h2 class="property-title">{{ $property->title }}</h2>
            
            <div style="display: flex; flex-wrap: wrap; gap: 2rem; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-money-bill"></i>
                    <span class="property-price">₱{{ number_format($property->monthly_rent, 2) }}/month</span>
                </div>
                
                <div style="display: flex; align-items: center; gap: 0.5rem; flex: 1;">
                    <i class="fas fa-map-marker-alt"></i>
                    <span class="property-address">{{ $property->address ?: 'Address not provided' }}</span>
                </div>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;">
                <span class="badge">
                    <i class="fas fa-home"></i> {{ ucfirst($property->type) }}
                </span>
                <span class="badge">
                    <i class="fas fa-users"></i> For {{ ucfirst($property->available_for) }}
                </span>
            </div>

            <div style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Description</h3>
                <p class="property-description">{{ $property->description ?: 'No description provided' }}</p>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="info-card">
            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">Contact Information</h3>
            
            <div class="contact-info" style="margin-bottom: 1rem;">
                <p style="font-weight: 500; margin-bottom: 0.25rem;">Owner</p>
                <p>{{ $property->owner->first_name }} {{ $property->owner->last_name }}</p>
            </div>

            <div class="contact-info" style="margin-bottom: 1rem;">
                <p style="font-weight: 500; margin-bottom: 0.25rem;">Contact Number</p>
                <p>{{ $property->contact_number ?: 'Not provided' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
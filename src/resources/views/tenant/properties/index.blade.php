@extends('layouts.dashboard')

@section('title', 'Browse Properties | Rentals Tacloban')

@section('sidebar')
    <li class="nav-item">
        <a href="{{ route('tenant.dashboard') }}" class="nav-link">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('tenant.properties.index') }}" class="nav-link active">
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
          <a href="{{ route('tenant.profile') }}" class="nav-link {{ Request::routeIs('tenant.profile') ? 'active' : '' }}">
        <i class="fas fa-user-circle"></i>
        <span>Profile</span>
          </a>    
        </li>
@endsection

@section('content')
<div class="content-card">
    <!-- Search and Filter Section -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        
        <form action="{{ route('tenant.properties.index') }}" method="GET" style="display: flex; gap: 1rem;">
            <!-- Search Input -->
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Search properties..."
                   style="padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 0.5rem; width: 200px;">

            <!-- Property Type Filter -->
            <select name="type" 
                    style="padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 0.5rem;">
                <option value="">All Types</option>
                <option value="bedspace" {{ request('type') == 'bedspace' ? 'selected' : '' }}>Bedspace</option>
                <option value="room" {{ request('type') == 'room' ? 'selected' : '' }}>Room</option>
                <option value="apartment" {{ request('type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                <option value="house" {{ request('type') == 'house' ? 'selected' : '' }}>House</option>
            </select>

            <!-- Available For Filter -->
            <select name="available_for" 
                    style="padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 0.5rem;">
                <option value="">Available For</option>
                <option value="male" {{ request('available_for') == 'male' ? 'selected' : '' }}>Male Only</option>
                <option value="female" {{ request('available_for') == 'female' ? 'selected' : '' }}>Female Only</option>
                <option value="couples" {{ request('available_for') == 'couples' ? 'selected' : '' }}>Couples</option>
                <option value="any" {{ request('available_for') == 'any' ? 'selected' : '' }}>Any</option>
            </select>

            <!-- Sort By Price -->
            <select name="sort" 
                    style="padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 0.5rem;">
                <option value="">Sort By Price</option>
                <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Highest to Lowest</option>
                <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Lowest to Highest</option>
            </select>

            <button type="submit" 
                    style="padding: 0.75rem; background: var(--primary); color: var(--white); border: none; border-radius: 0.5rem; width: 45px;">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    <!-- Properties Grid -->
    @if($properties->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
            @foreach($properties as $property)
            <div class="property-card" onclick="window.location.href='{{ route('tenant.properties.show', $property) }}'">
            
            
            <div class="inquiry-btn" 
         onclick="event.stopPropagation(); alert('Inquiry feature coming soon!');" 
         title="Send Inquiry">
        <i class="fas fa-paper-plane"></i>
    </div>
            
            
            <!-- Property Image -->
                    <div style="position: relative; padding-top: 60%;">
                    @if($property->images->count() > 0)
                        <img src="{{ Storage::url($property->images->first()->image_path) }}" 
                             alt="{{ $property->title }}"
                             style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: var(--secondary); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-home" style="font-size: 2rem; color: var(--text-light);"></i>
                        </div>
                    @endif
                </div>

                    <!-- Property Details -->
                <div style="padding: 1rem;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;" title="{{ $property->title }}">
                        {{ \Illuminate\Support\Str::limit($property->title, 25, '...') }}
                    </h3>
                    <p style="color: var(--primary); font-weight: 600; margin-bottom: 0.5rem;">₱{{ number_format($property->monthly_rent, 2) }}/month</p>
                    
                    <div style="display: flex; gap: 1rem;">
                        <span style="display: inline-flex; align-items: center; gap: 0.25rem; color: var(--text-light); font-size: 0.875rem;">
                            <i class="fas fa-home"></i> {{ ucfirst($property->type) }}
                        </span>
                        <span style="display: inline-flex; align-items: center; gap: 0.25rem; color: var(--text-light); font-size: 0.875rem;">
                            <i class="fas fa-users"></i> {{ ucfirst($property->available_for) }}
                        </span>
                    </div>
                </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 2rem;">
            {{ $properties->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 3rem 0;">
            <i class="fas fa-search" style="font-size: 3rem; color: var(--text-light); margin-bottom: 1rem;"></i>
            <p style="color: var(--text-light);">No properties found matching your criteria</p>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .property-card {
        background: var(--white);
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .property-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .property-card:active {
        transform: translateY(-2px);
    }

    .property-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.1);
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .property-card:hover::after {
        opacity: 1;
    }
    .inquiry-btn {
        position: absolute;
        bottom: 1rem;   
        right: 1rem;
        width: 35px;
        height: 35px;
        background: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 2;
        opacity: 0;         
    }

    .property-card:hover .inquiry-btn {
        opacity: 1;     
    }

    .inquiry-btn:hover {
        transform: scale(1.1);
        background: var(--primary-dark);
    }

    .inquiry-btn i {
        font-size: 1rem;
    }
</style>
@endsection
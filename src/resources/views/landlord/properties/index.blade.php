@extends('layouts.dashboard')

@section('title', 'Properties | Rentals Tacloban')

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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <h1 style="font-size: 1.5rem; font-weight: 600;">Properties</h1>
                <div style="display: flex; gap: 0.5rem; background: var(--secondary); padding: 0.25rem; border-radius: 0.5rem;">
                    <a href="{{ route('landlord.properties.index') }}" 
                       style="padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; {{ !request()->has('filter') ? 'background: var(--primary); color: var(--white);' : 'color: var(--text-dark);' }}">
                        All Listings
                    </a>
                    <a href="{{ route('landlord.properties.index', ['filter' => 'own']) }}" 
                       style="padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; {{ request()->get('filter') === 'own' ? 'background: var(--primary); color: var(--white);' : 'color: var(--text-dark);' }}">
                        My Properties
                    </a>
                </div>
            </div>
            <a href="{{ route('landlord.properties.create') }}" 
               style="background: var(--primary); color: var(--white); padding: 0.75rem 1rem; border-radius: 0.5rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s ease;">
                <i class="fas fa-plus"></i>
                <span>Add Property</span>
            </a>
        </div>

        @if($properties->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                @foreach($properties as $property)
                    <div style="background: var(--white); border-radius: 0.5rem; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: transform 0.2s ease;">
                        <!-- Property Image Section -->
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

                        <div style="padding: 1rem;">
                            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">{{ $property->title }}</h3>
                            <p style="color: var(--primary); font-weight: 600; margin-bottom: 0.5rem;">₱{{ number_format($property->monthly_rent, 2) }}/month</p>
                            
                            <!-- Property Details -->
                            <div style="display: flex; gap: 1rem; margin-bottom: 0.5rem;">
                                <span style="display: inline-flex; align-items: center; gap: 0.25rem; color: var(--text-light); font-size: 0.875rem;">
                                    <i class="fas fa-home"></i>
                                    {{ ucfirst($property->type) }}
                                </span>
                                <span style="display: inline-flex; align-items: center; gap: 0.25rem; color: var(--text-light); font-size: 0.875rem;">
                                    <i class="fas fa-users"></i>
                                    {{ ucfirst($property->available_for) }}
                                </span>
                            </div>

                            <!-- Owner Info -->
                            <div style="margin-bottom: 1rem; font-size: 0.875rem; color: var(--text-light);">
                                <span style="display: inline-flex; align-items: center; gap: 0.25rem;">
                                    <i class="fas fa-user"></i>
                                    {{ $property->user->first_name }} {{ $property->user->last_name }}
                                </span>
                            </div>

                            <!-- Action Buttons -->
                            <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                @if($property->user_id === auth()->id())
                                    <a href="{{ route('landlord.properties.edit', $property) }}" 
                                       style="padding: 0.5rem 1rem; background: var(--primary); color: var(--white); border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">
                                        Edit
                                    </a>
                                    <form action="{{ route('landlord.properties.destroy', $property) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this property?');"
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                style="padding: 0.5rem 1rem; background: var(--danger); color: var(--white); border: none; border-radius: 0.375rem; cursor: pointer; font-size: 0.875rem;">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                <a href="{{ route('landlord.properties.show', $property) }}" 
   style="padding: 0.5rem 1rem; background: var(--primary); color: var(--white); border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">
    View Details
</a>
                                @endif
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
                <i class="fas fa-building" style="font-size: 3rem; color: var(--text-light); margin-bottom: 1rem;"></i>
                <p style="color: var(--text-light); margin-bottom: 1rem;">No properties found</p>
                @if(request()->get('filter') === 'own')
                    <a href="{{ route('landlord.properties.create') }}" 
                       style="display: inline-flex; align-items: center; gap: 0.5rem; background: var(--primary); color: var(--white); padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none;">
                        <i class="fas fa-plus"></i>
                        <span>Add Your First Property</span>
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection
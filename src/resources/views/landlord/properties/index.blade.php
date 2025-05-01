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
                <div style="display: flex; gap: 0.5rem; background: var(--secondary); padding: 0.25rem; border-radius: 0.5rem;">
                    <a href="{{ route('landlord.properties.index') }}" 
                       class="filter-link {{ !request()->has('filter') ? 'active' : '' }}">
                        All Listings
                    </a>
                    <a href="{{ route('landlord.properties.index', ['filter' => 'own']) }}" 
                       class="filter-link {{ request()->get('filter') === 'own' ? 'active' : '' }}">
                        My Properties
                    </a>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 1rem;">
                <form action="{{ route('landlord.properties.index') }}" method="GET" class="search-form">
                    @if(request()->has('filter'))
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                    @endif

                    <select name="type" class="filter-select">
                        <option value="">All Types</option>
                        <option value="bedspace" {{ request('type') == 'bedspace' ? 'selected' : '' }}>Bedspace</option>
                        <option value="room" {{ request('type') == 'room' ? 'selected' : '' }}>Room</option>
                        <option value="apartment" {{ request('type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                        <option value="house" {{ request('type') == 'house' ? 'selected' : '' }}>House</option>
                    </select>

                    <select name="available_for" class="filter-select">
                        <option value="">Available For</option>
                        <option value="male" {{ request('available_for') == 'male' ? 'selected' : '' }}>Male Only</option>
                        <option value="female" {{ request('available_for') == 'female' ? 'selected' : '' }}>Female Only</option>
                        <option value="couples" {{ request('available_for') == 'couples' ? 'selected' : '' }}>Couples</option>
                        <option value="any" {{ request('available_for') == 'any' ? 'selected' : '' }}>Any</option>
                    </select>

                    <select name="sort" class="filter-select">
                        <option value="">Sort By Price</option>
                        <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Highest to Lowest</option>
                        <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Lowest to Highest</option>
                    </select>

                    <button type="submit" class="icon-button" title="Search">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <a href="{{ route('landlord.properties.create') }}" 
                   class="icon-button" 
                   title="Add Property">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>

        @if($properties->count() > 0)
            <div class="property-grid">
                @foreach($properties as $property)
                    <div class="property-card" onclick="window.location.href='{{ route('landlord.properties.show', $property) }}'">
                        <div class="property-image">
                            @if($property->images->count() > 0)
                                <img src="{{ Storage::url($property->images->first()->image_path) }}" 
                                     alt="{{ $property->title }}"
                                     onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}';">
                            @else
                                <div class="placeholder-image">
                                    <i class="fas fa-home"></i>
                                </div>
                            @endif

                            @if($property->user_id === auth()->id())
                                <div class="action-buttons" onclick="event.stopPropagation();">
                                    <a href="{{ route('landlord.properties.edit', $property) }}" 
                                       class="edit-button" 
                                       title="Edit Property">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('landlord.properties.destroy', $property) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this property?');"
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="delete-button"
                                                title="Delete Property">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <div class="property-details">
                            <h3 class="property-title" title="{{ $property->title }}">
                                {{ \Illuminate\Support\Str::limit($property->title, 25, '...') }}
                            </h3>
                            <p class="property-price">₱{{ number_format($property->monthly_rent, 2) }}/month</p>
                            
                            <div class="property-badges">
                                <span class="badge">
                                    <i class="fas fa-home"></i>
                                    {{ ucfirst($property->type) }}
                                </span>
                                <span class="badge">
                                    <i class="fas fa-users"></i>
                                    {{ ucfirst($property->available_for) }}
                                </span>
                            </div>

                            <div class="owner-info">
                                <span>
                                    <i class="fas fa-user"></i>
                                    {{ $property->user->first_name }} {{ $property->user->last_name }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="pagination-container">
                {{ $properties->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-building"></i>
                <p>No properties found</p>
                @if(request()->get('filter') === 'own')
                    <a href="{{ route('landlord.properties.create') }}" class="add-property-btn">
                        <i class="fas fa-plus"></i>
                        <span>Add Your First Property</span>
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection


@section('styles')
<style>
    .search-form {
        display: flex;
        gap: 1rem;
    }

    .filter-select {
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .filter-select:hover {
        border-color: var(--primary);
    }

    .filter-link {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        text-decoration: none;
        color: var(--text-dark);
        transition: all 0.2s ease;
    }

    .filter-link.active {
        background: var(--primary);
        color: var(--white);
    }

    .icon-button {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary);
        color: var(--white);
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
        
    }

    .icon-button:hover {
        transform: translateY(-2px);
        background: var(--primary-dark);
    }

    .property-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }

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

    .property-image {
        position: relative;
        padding-top: 60%;
    }

    .property-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }


    .placeholder-image {
        position: absolute;
        inset: 0;
        background: var(--secondary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .placeholder-image i {
        font-size: 2rem;
        color: var(--text-light);
    }

    .action-buttons {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        display: flex;
        gap: 0.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .property-card:hover .action-buttons {
        opacity: 1;
    }

    .edit-button,
    .delete-button {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .edit-button {
        background: var(--primary);
    }

    .delete-button {
        background: var(--danger);
    }

    .edit-button:hover,
    .delete-button:hover {
        transform: scale(1.1);
    }

    .property-details {
        padding: 1rem;
    }

    .property-title {
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .property-price {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .property-badges {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        color: var(--text-light);
        font-size: 0.875rem;
    }

    .owner-info {
        font-size: 0.875rem;
        color: var(--text-light);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 0;
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--text-light);
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: var(--text-light);
        margin-bottom: 1rem;
    }

    .add-property-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary);
        color: var(--white);
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .add-property-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .pagination-container {
        margin-top: 2rem;
    }
    .property-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .property-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

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
        transition: transform 0.3s ease;
    }

    .image-container:hover {
        transform: scale(1.02);
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
        transform: scale(1.1);
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
        transition: all 0.3s ease;
    }

    .info-card:hover {
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .back-button {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .back-button:hover {
        transform: translateX(-5px);
        background: var(--primary-dark);
    }

    .property-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        word-break: break-word;
        line-height: 1.3;
    }


    @media (max-width: 1024px) {
        .property-info {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
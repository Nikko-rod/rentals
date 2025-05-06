@extends('layouts.final-dashboard')

@section('title', 'Properties | Rentals Tacloban')
@section('dashboard-title', 'Landlord Portal')
@section('page-title', 'Properties')

@section('sidebar-menu')
    <a href="{{ route('landlord.dashboard') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105 
              {{ Request::routeIs('landlord.dashboard') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-home w-5"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('landlord.properties.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('landlord.properties.index') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-building w-5"></i>
        <span>Properties</span>
    </a>

    <a href="{{ route('landlord.inquiries.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('landlord.inquiries.index') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
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
    <!-- Permit Warning -->
    @if(auth()->user()->landlord->approval_status->value !== 'approved')
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg mb-6">
            @if(auth()->user()->landlord->approval_status->value === 'pending')
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clock text-yellow-400 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-medium text-yellow-800">Business Permit Under Review</h2>
                        <p class="mt-1 text-yellow-700">Your business permit is currently being reviewed. Property listing will be enabled once approved. (Check your profile)</p>
                    </div>
                </div>
            @else
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-400 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-medium text-red-800">Business Permit Rejected</h2>
                        <p class="mt-1 text-red-700">Reason: {{ auth()->user()->landlord->rejection_remark }}</p>
                        <a href="{{ route('landlord.profile') }}" 
                           class="mt-3 inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-300">
                            <i class="fas fa-upload mr-2"></i>
                            <span>Upload New Permit</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    @endif

   <!-- Filters and Actions -->
<div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
    <!-- Left side filters -->
    <div class="flex items-center gap-4">
        <div class="bg-white rounded-lg shadow-sm p-1">
            <a href="{{ route('landlord.properties.index') }}" 
               class="px-4 py-2 rounded-lg inline-block {{ !request()->has('filter') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                All Listings
            </a>
            <a href="{{ route('landlord.properties.index', ['filter' => 'own']) }}" 
               class="px-4 py-2 rounded-lg inline-block {{ request()->get('filter') === 'own' ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                My Properties
            </a>
        </div>
    </div>

          <!-- Right side filters and actions -->
    <div class="flex flex-wrap items-center gap-4">
        <form action="{{ route('landlord.properties.index') }}" method="GET" 
              class="flex flex-wrap items-center gap-4">
            @if(request()->has('filter'))
                <input type="hidden" name="filter" value="{{ request('filter') }}">
            @endif
            
            <!-- Property Type Dropdown -->
            <div class="relative">
                <select name="type" 
                        class="appearance-none bg-white border border-gray-300 rounded-lg pl-4 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-500">
                    <option value="">Property Type</option>
                    <option value="bedspace" {{ request('type') == 'bedspace' ? 'selected' : '' }}>Bedspace</option>
                    <option value="room" {{ request('type') == 'room' ? 'selected' : '' }}>Room</option>
                    <option value="apartment" {{ request('type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                    <option value="house" {{ request('type') == 'house' ? 'selected' : '' }}>House</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
            <!-- Available For Dropdown -->
            <div class="relative">
                <select name="available_for" 
                        class="appearance-none bg-white border border-gray-300 rounded-lg pl-4 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-500">
                    <option value="">Available For</option>
                    <option value="male" {{ request('available_for') == 'male' ? 'selected' : '' }}>Male Only</option>
                    <option value="female" {{ request('available_for') == 'female' ? 'selected' : '' }}>Female Only</option>
                    <option value="couples" {{ request('available_for') == 'couples' ? 'selected' : '' }}>Couples</option>
                    <option value="any" {{ request('available_for') == 'any' ? 'selected' : '' }}>Any</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>

            <!-- Sort By Dropdown -->
            <div class="relative">
                <select name="sort" 
                        class="appearance-none bg-white border border-gray-300 rounded-lg pl-4 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-500">
                    <option value="">Sort By Price</option>
                    <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Highest to Lowest</option>
                    <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Lowest to Highest</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>

            <!-- Search Button -->
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition duration-300">
                <i class="fas fa-search mr-2"></i>
                <span>Search</span>
            </button>
        </form>

                    @if(auth()->user()->landlord->approval_status->value === 'approved')
                <a href="{{ route('landlord.properties.create') }}" 
                class="inline-flex items-center justify-center w-10 h-10 bg-green-700 hover:bg-green-800 text-white rounded-lg transition duration-300"
                title="Add New Property">
                    <i class="fas fa-plus"></i>
                </a>
            @endif
    </div>
</div>

    <!-- Properties Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($properties as $property)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden group hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <!-- Property Image -->
                <div class="relative h-48">
                    @if($property->images->count() > 0)
                        <img src="{{ Storage::url($property->images->first()->image_path) }}" 
                             alt="{{ $property->title }}"
                             class="w-full h-full object-cover"
                             loading="lazy">
                    @else
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-home text-gray-400 text-3xl"></i>
                        </div>
                    @endif
                    
                    <!-- Action Buttons -->
                    @if($property->user_id === auth()->id())
                        <div class="absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a href="{{ route('landlord.properties.edit', $property) }}" 
                               class="p-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition duration-300">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('landlord.properties.destroy', $property) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this property?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Property Status -->
                    
                                <div class="absolute bottom-2 left-2">
                                    @if($property->is_available)
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                            Available
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                            Not Available
                                        </span>
                                    @endif
                                </div>
                </div>

                <!-- Property Details -->
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 truncate" title="{{ $property->title }}">
                        {{ $property->title }}
                    </h3>
                    <p class="text-green-700 font-semibold mt-1">₱{{ number_format($property->monthly_rent) }}/month</p>
                    
                    <div class="mt-2 flex flex-wrap gap-2">
                        <span class="inline-flex items-center text-sm text-gray-600">
                            <i class="fas fa-home mr-1"></i>
                            {{ ucfirst($property->type) }}
                        </span>
                        <span class="inline-flex items-center text-sm text-gray-600">
                            <i class="fas fa-users mr-1"></i>
                            {{ ucfirst($property->available_for) }}
                        </span>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('landlord.properties.show', $property) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition duration-300">
                            <i class="fas fa-eye mr-2"></i>
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 bg-white rounded-xl shadow-sm">
                <i class="fas fa-home text-gray-400 text-5xl mb-4"></i>
                <p class="text-gray-600">No properties found</p>
                @if(auth()->user()->landlord->approval_status === 'approved')
                    <a href="{{ route('landlord.properties.create') }}" 
                       class="inline-flex items-center px-4 py-2 mt-4 bg-green-700 hover:bg-green-800 text-white rounded-lg transition duration-300">
                        <i class="fas fa-plus mr-2"></i>
                        Add Your First Property
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $properties->links() }}
    </div>
@endsection



@push('scripts')
<script>
    $(document).ready(function() {
        $('#propertiesTable').DataTable({
            responsive: true,
            pageLength: 10,
            order: [[1, 'asc']], // Sort by title by default
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            language: {
                search: "Search properties:",
                lengthMenu: "Show _MENU_ properties per page",
                info: "Showing _START_ to _END_ of _TOTAL_ properties",
                emptyTable: "No properties found",
            },
            initComplete: function () {
                // Add custom filter for property type
                this.api().columns(2).every(function () {
                    var column = this;
                    var select = $('<select class="rounded-lg border-gray-300 text-sm"><option value="">All Types</option></select>')
                        .appendTo($(column.header()))
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^'+val+'$' : '', true, false).draw();
                        });
 
                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option value="'+d+'">'+d+'</option>');
                    });
                });
            }
        });
    });
</script>
@endpush
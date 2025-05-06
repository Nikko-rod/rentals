@extends('layouts.final-dashboard')

@section('title', 'Manage Properties')
@section('dashboard-title', 'Admin Panel')
@section('page-title', 'Manage Properties')


@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105 
              {{ Request::routeIs('admin.dashboard') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-chart-line w-5"></i>
        <span>Dashboard</span>
    </a>
    
    <a href="{{ route('admin.manage-users') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('admin.manage-users') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-users w-5"></i>
        <span>Manage Users</span>
    </a>

    <a href="{{ route('admin.properties.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('admin.properties.*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-home w-5"></i>
        <span>Manage Properties</span>
    </a>
@endsection



@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Properties Management</h2>
                <span class="text-sm text-gray-500">Total: {{ $properties->total() }}</span>
            </div>

            <table id="propertiesTable" class="w-full">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Owner</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Price</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($properties as $property)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                @if($property->thumbnail)
                                    <img src="{{ Storage::url($property->thumbnail) }}" 
                                         alt="{{ $property->title }}"
                                         class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-home text-gray-400"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="font-medium text-gray-800">{{ $property->title }}</div>
                                    <div class="text-xs text-gray-500">{{ Str::limit($property->address, 30) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-green-700 text-white flex items-center justify-center text-sm">
                                    {{ strtoupper(substr($property->landlord->user->first_name, 0, 1)) }}
                                </div>
                                <span class="text-sm text-gray-600">{{ $property->landlord->user->full_name }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($property->type) }}
                            </span>
                        </td>
                        <td>
                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                {{ $property->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $property->is_available ? 'Available' : 'Not Available' }}
                            </span>
                        </td>
                        <td>
                            <span class="text-sm font-medium text-gray-700">
                                ₱{{ number_format($property->monthly_rent, 2) }}
                            </span>
                        </td>
                        <td>
                            <span class="text-sm text-gray-500">
                                {{ $property->created_at->format('M d, Y') }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.properties.show', $property) }}" 
                                class="p-2 text-blue-700 hover:bg-blue-50 rounded-lg transition-colors"
                                title="View Property">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button onclick="deleteProperty({{ $property->id }})" 
                                        class="p-2 text-red-700 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Delete Property">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $properties->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-xl p-6 max-w-sm w-full mx-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirm Deletion</h3>
        <p class="text-gray-600 mb-6">Are you sure you want to delete this property? This action cannot be undone.</p>
        <div class="flex justify-end gap-3">
            <button onclick="closeDeleteModal()" 
                    class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                Cancel
            </button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script>
$(document).ready(function() {
    $('#propertiesTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[5, 'desc']],
        columnDefs: [
            { orderable: false, targets: [0, 6] }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search properties...",
            lengthMenu: "_MENU_ properties per page",
        }
    });
});

function deleteProperty(propertyId) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    
    form.action = `/admin/properties/${propertyId}`;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}
</script>
@endpush
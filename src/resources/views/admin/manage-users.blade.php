@extends('layouts.final-dashboard')

@section('title', 'Manage Users')
@section('dashboard-title', 'Admin Panel')
@section('page-title', 'Manage Users')


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
              {{ Request::routeIs('admin.properties.index') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-home w-5"></i>
        <span>Manage Properties</span>
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Users Management</h2>
            </div>

            <table id="usersTable" class="w-full">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Verification</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-700 text-white flex items-center justify-center">
                                    {{ strtoupper(substr($user->first_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $user->full_name }}</div>
                                    <div class="text-xs text-gray-500">Joined {{ $user->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                {{ $user->role === 'landlord' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                {{ $user->is_archived ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $user->is_archived ? 'Archived' : 'Active' }}
                            </span>
                        </td>
                        <td>
                            @if($user->role === 'landlord')
                                <span class="px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $user->landlord?->approval_status?->value === 'approved' ? 'bg-green-100 text-green-800' : 
                                      ($user->landlord?->approval_status?->value === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($user->landlord?->approval_status?->value ?? 'pending') }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                   class="p-2 text-green-700 hover:bg-green-50 rounded-lg transition-colors">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="toggleUserStatus({{ $user->id }})" 
                                        class="p-2 {{ $user->is_archived ? 'text-green-700 hover:bg-green-50' : 'text-red-700 hover:bg-red-50' }} rounded-lg transition-colors">
                                    <i class="fas {{ $user->is_archived ? 'fa-undo' : 'fa-archive' }}"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
    $('#usersTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: 5 }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search users...",
            lengthMenu: "_MENU_ users per page",
        }
    });
});

function toggleUserStatus(userId) {

    console.log('Toggle user status:', userId);
}
</script>
@endpush
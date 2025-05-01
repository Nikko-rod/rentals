@extends('layouts.dashboard')

@section('title', 'Manage Users | Admin Dashboard')

@section('sidebar')
    <ul>
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
    <a href="{{ route('admin.manage-users') }}" class="nav-link {{ Request::routeIs('admin.manage-users') ? 'active' : '' }}">
        <i class="fas fa-users"></i>
        <span>Manage Users</span>
    </a>
</li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-home"></i>
                <span>Properties</span>
            </a>
        </li>
    </ul>
    <ul>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <h1 class="text-2xl font-bold">Manage Users</h1>
        <div class="flex items-center gap-4">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" 
                       id="search" 
                       placeholder="Search users..."
                       class="search-input">
            </div>
            <select id="role-filter" class="filter-select">
                <option value="">All Roles</option>
                <option value="landlord">Landlords</option>
                <option value="tenant">Tenants</option>
            </select>
            <select id="status-filter" class="filter-select">
             <option value="">All Status</option>
             <option value="active">Active</option>
             <option value="archived">Archived</option>
             <option value="pending">Pending</option>
</select>
        </div>
    </div>

    <!-- Users List -->
    <div class="content-cardd">
    <div class="overflow-x-auto">
        <table class="w-full table-users">
            <thead>
                <tr class="bg-gray-50">
                    <th class="table-header" style="width: 30%">User</th>
                    <th class="table-header" style="width: 20%">Email</th>
                    <th class="table-header" style="width: 12%">Role</th>
                    <th class="table-header" style="width: 12%">Status</th>
                    <th class="table-header" style="width: 14%">Verification</th>
                    <th class="table-header" style="width: 12%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-t border-gray-100">
                    <td class="table-cell">
                        <div class="flex items-center gap-3">
                            <div class="user-avatar">
                                {{ strtoupper(substr($user->first_name, 0, 1)) }}
                            </div>
                            <div class="user-info">
    <div class="text-sm font-semibold">{{ $user->full_name }}</div>
    <div class="text-xs text-gray-500">Joined {{ $user->created_at->format('M d, Y') }}</div>
</div>
                        </div>
                    </td>
                    <td class="table-cell">
                        <span class="text-gray-600">{{ $user->email }}</span>
                    </td>
                    <td class="table-cell">
                        <span class="badge {{ $user->role === 'landlord' ? 'badge-blue' : 'badge-green' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="table-cell">
                        <span class="badge {{ $user->is_archived ? 'badge-red' : 'badge-green' }}">
                            {{ $user->is_archived ? 'Archived' : 'Active' }}
                        </span>
                    </td>
                    <td class="table-cell">
                        @if($user->role === 'landlord')
                            <span class="badge {{ 
                                $user->landlord?->approval_status?->value === 'approved' ? 'badge-green' : 
                                ($user->landlord?->approval_status?->value === 'pending' ? 'badge-yellow' : 'badge-red') 
                            }}">
                                {{ ucfirst($user->landlord?->approval_status?->value ?? 'pending') }}
                            </span>
                        @else   
                            <span class="text-gray-400">   -   </span>
                        @endif
                    </td>
                    <td class="table-cell">
                        <div class="flex items-center gap-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="action-btn edit-btn" title="View User">
    <i class="fas fa-edit"></i>
</a>
</a>
                            <button class="action-btn {{ $user->is_archived ? 'restore-btn' : 'archive-btn' }}" 
                                    title="{{ $user->is_archived ? 'Restore User' : 'Archive User' }}">
                                <i class="fas {{ $user->is_archived ? 'fa-undo' : 'fa-archive' }}"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-500">
                            
                            <p class="text-lg">No users found</p>
                            <p class="text-sm">Try adjusting your search or filters</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
    <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
        {{ $users->withQueryString()->links() }}
    </div>
</div>
</div>

@endsection

@section('styles')
<style>
    

    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .content-card {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
    }

    .search-box {
        position: relative;
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
    }

    .search-input {
        padding: 0.625rem 1rem 0.625rem 2.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        width: 300px;
    }

    .filter-select {
        padding: 0.625rem 2rem 0.625rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        min-width: 150px;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .badge-blue {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-green {
        background: #dcfce7;
        color: #166534;
    }

    .badge-red {
        background: #fee2e2;
        color: #dc2626;
    }

    .badge-yellow {
        background: #fef3c7;
        color: #d97706;
    }

    .btn-icon {
        padding: 0.5rem;
        border-radius: 0.375rem;
        transition: all 0.2s;
    }

    .btn-icon:hover {
        background: #f8fafc;
    }

    

    .table-users {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-header {
        padding: 1rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        text-align: left;
        color: #4b5563;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .table-cell {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        white-space: nowrap;
    }

    .user-avatar {
        width: 2.5rem;
        height: 2.5rem;
        background: var(--primary);
        color: white;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .user-info {
    min-width: 0;
    line-height: 1.4;
}

.user-info .text-sm {
    color: #1f2937;
    margin-bottom: 0.125rem;
}

.user-info .text-xs {
    font-size: 0.75rem;
    color: #6b7280;
}

    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        white-space: nowrap;
    }

    .action-btn {
    padding: 0.5rem;
    border-radius: 0.375rem;
    transition: all 0.2s;
}

.edit-btn {
    color: var(--primary);
}

.archive-btn {
    color: #dc2626;
}

.restore-btn {
    color: #059669;
}

.action-btn:hover {
    background-color: #f3f4f6;
    color: #6b7280;
}

    /* Improve empty state */
    .empty-state {
        padding: 3rem 1.5rem;
        text-align: center;
    }

    /* Table hover effect */
    .table-users tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Table border radius */
    .content-cardd {
            background: var(--white);
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .content-cardd:hover {
          
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

    .table-users thead tr:first-child th:first-child {
        border-top-left-radius: 0.5rem;
    }

    .table-users thead tr:first-child th:last-child {
        border-top-right-radius: 0.5rem;
    }

    .table-users tbody tr:last-child td:first-child {
        border-bottom-left-radius: 0.5rem;
    }

    .table-users tbody tr:last-child td:last-child {
        border-bottom-right-radius: 0.5rem;
    }
   
.btn {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-success {
    background: #059669;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
}

.btn-danger {
    background: #dc2626;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
}

.form-input {
    border: 1px solid #e5e7eb;
    padding: 0.5rem;
    width: 100%;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary);
    ring: 2px var(--primary);
}

</style>
@endsection


@section('scripts')
<script>
let searchTimer;

document.getElementById('search').addEventListener('input', function(e) {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        updateFilters();
    }, 300);
});

document.getElementById('role-filter').addEventListener('change', updateFilters);
document.getElementById('status-filter').addEventListener('change', updateFilters);

function updateFilters() {
    const search = document.getElementById('search').value;
    const role = document.getElementById('role-filter').value;
    const status = document.getElementById('status-filter').value;

    const params = new URLSearchParams(window.location.search);
    
    if (search) params.set('search', search);
    else params.delete('search');
    
    if (role) params.set('role', role);
    else params.delete('role');
    
    if (status) params.set('status', status);
    else params.delete('status');

    // Preserve current page if not changing filters
    if (!search && !role && !status) {
        const currentPage = params.get('page');
        if (currentPage) params.set('page', currentPage);
    } else {
        params.delete('page'); // Reset to first page when filtering
    }

    window.location.href = `${window.location.pathname}?${params.toString()}`;
}

// Preserve filter values after page load
document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    
    const search = params.get('search');
    if (search) document.getElementById('search').value = search;
    
    const role = params.get('role');
    if (role) document.getElementById('role-filter').value = role;
    
    const status = params.get('status');
    if (status) document.getElementById('status-filter').value = status;
});



</script>
@endsection
@extends('layouts.final-dashboard')

@section('dashboard-title', 'Admin Panel')
@section('title', 'Edit User | Admin Dashboard')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('admin.dashboard') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-chart-line w-5"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('admin.manage-users') }}" 
   class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
          {{ Request::routeIs('admin.manage-users') || Request::routeIs('admin.users.*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
    <i class="fas fa-users w-5"></i>
    <span>Manage Users</span>
</a>

    <a href="{{ route('admin.properties.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('admin.properties.*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-building w-5"></i>
        <span>Manage Properties</span>
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.manage-users') }}" 
                       class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-xl font-semibold text-gray-800">Edit User</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-600 px-4 py-3 rounded-lg">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div class="space-y-2">
                                <label for="first_name" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-user text-gray-400 mr-2"></i>First Name
                                </label>
                                <input type="text" 
                                       name="first_name" 
                                       id="first_name"
                                       value="{{ old('first_name', $user->first_name) }}"
                                       class="w-full p-2 rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                       required>
                            </div>

                            <!-- Last Name -->
                            <div class="space-y-2">
                                <label for="last_name" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-user text-gray-400 mr-2"></i>Last Name
                                </label>
                                <input type="text" 
                                       name="last_name" 
                                       id="last_name"
                                       value="{{ old('last_name', $user->last_name) }}"
                                       class="w-full p-2 rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                       required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-envelope text-gray-400 mr-2"></i>Email Address
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="w-full p-2 rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                   required>
                        </div>

                        <!-- Contact Number -->
                        <div class="space-y-2">
                            <label for="contact_number" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-phone text-gray-400 mr-2"></i>Contact Number
                            </label>
                            <div class="relative">
                               
                                <input type="tel" 
                                       name="contact_number" 
                                       id="contact_number"
                                       value="{{ old('contact_number', $user->contact_number) }}"
                                       class="w-full  p-2 rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                       pattern="[0-9]{11}"
                                       title="Please enter a valid 11-digit phone number"
                                       required>
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-user-tag text-gray-400 mr-2"></i>Role
                            </label>
                            <div class="px-4 py-2 bg-gray-50 rounded-lg border border-gray-200">
                                <span class="font-medium text-gray-800">{{ ucfirst($user->role) }}</span>
                                <span class="text-sm text-gray-500 ml-2">(Cannot be changed)</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.manage-users') }}" 
                               class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors">
                                <i class="fas fa-save mr-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- User Info Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">User Information</h3>
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-green-700 text-white flex items-center justify-center text-2xl">
                            {{ strtoupper(substr($user->first_name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800">{{ $user->full_name }}</h4>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            <p class="text-sm text-gray-500">Joined {{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

       <!-- Business Permit Section -->
@if($user->role === 'landlord')
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-file-certificate text-green-600 mr-2"></i>
                    Business Permit
                </h3>
                @if($user->landlord && $user->landlord->business_permit)
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                        {{ $user->landlord->approval_status->value === 'approved' ? 'bg-green-100 text-green-800' : 
                           ($user->landlord->approval_status->value === 'rejected' ? 'bg-red-100 text-red-800' : 
                           'bg-yellow-100 text-yellow-800') }}">
                        {{ ucfirst($user->landlord->approval_status->value ?? 'pending') }}
                    </span>
                @endif
            </div>

            @if($user->landlord && $user->landlord->business_permit)
                <div class="space-y-6">
                    <!-- Document Preview -->
                    <div class="bg-gray-50 rounded-lg border border-gray-200">
                        <div class="p-4 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center">
                                    <i class="fas fa-file-pdf text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Business Permit</p>
                                    <p class="text-sm text-gray-500">
                                        Last updated: {{ $user->landlord->updated_at->format('M d, Y h:ia') }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ Storage::url($user->landlord->business_permit) }}" 
                               target="_blank"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-external-link-alt"></i>
                                <span>View Document</span>
                            </a>
                        </div>

                        @if($user->landlord->approval_status->value === 'pending')
                            <div class="p-4 border-t border-gray-200 bg-yellow-50">
                                <div class="flex items-center gap-2 mb-4 text-yellow-800">
                                    <i class="fas fa-clock-rotate-left"></i>
                                    <p class="font-medium">Pending Review</p>
                                </div>
                                
                                <div class="flex gap-3">
                                    <form action="{{ route('admin.users.approve-permit', $user->id) }}" 
                                          method="POST" 
                                          class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                            <i class="fas fa-check"></i>
                                            <span>Approve</span>
                                        </button>
                                    </form>

                                    <button type="button" 
                                            onclick="showRejectModal()"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                                        <i class="fas fa-xmark"></i>
                                        <span>Reject</span>
                                    </button>
                                </div>
                            </div>
                        @elseif($user->landlord->approval_status->value === 'rejected')
                            <div class="p-4 border-t border-gray-200 bg-red-50">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-circle-exclamation text-red-500 mt-0.5"></i>
                                    <div class="flex-1">
                                        <p class="font-medium text-red-800">Permit Rejected</p>
                                        @if($user->landlord->rejection_remark)
                                            <p class="text-red-600 mt-1">{{ $user->landlord->rejection_remark }}</p>
                                        @endif
                                        <button type="button"
                                                onclick="showResetModal()"
                                                class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-red-300 text-red-600 rounded-lg text-sm hover:bg-red-50 transition-colors">
                                            <i class="fas fa-rotate"></i>
                                            <span>Reset Status</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @elseif($user->landlord->approval_status->value === 'approved')
                            <div class="p-4 border-t border-gray-200 bg-green-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3 text-green-800">
                                        <i class="fas fa-circle-check"></i>
                                        <div>
                                            <p class="font-medium">Permit Approved</p>
                                            <p class="text-sm">Approved on {{ $user->landlord->updated_at->format('M d, Y h:ia') }}</p>
                                        </div>
                                    </div>
                                    <button type="button"
                                            onclick="showResetModal()"
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-green-300 text-green-600 rounded-lg text-sm hover:bg-green-50 transition-colors">
                                        <i class="fas fa-rotate"></i>
                                        <span>Reset Status</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                    <i class="fas fa-file-circle-plus text-gray-400 text-4xl mb-3"></i>
                    <p class="text-gray-600 font-medium">No Business Permit Uploaded</p>
                    <p class="text-gray-500 text-sm mt-1">The landlord hasn't uploaded their business permit yet.</p>
                </div>
            @endif
        </div>
    </div>
@endif
        </div>
    </div>
</div>




<!-- Replace the existing Reject Modal with this improved version -->
<div id="rejectModal" class="fixed inset-0 bg-gray-900/75 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-sm w-full mx-4 transform transition-all">
        <div class="px-4 py-3 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-800">Reject Business Permit</h3>
        </div>
        
        <form action="{{ route('admin.users.reject-permit', $user->id) }}" method="POST">
            @csrf
            <div class="p-4">
                <label for="rejection_remark" class="block text-sm font-medium text-gray-700 mb-2">
                    Select Rejection Reason
                </label>
                <select name="rejection_remark" 
                        id="rejection_remark" 
                        class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 text-sm"
                        required>
                    <option value="">Choose a reason...</option>
                    @foreach(\App\Enums\RejectionRemark::cases() as $remark)
                        <option value="{{ $remark->value }}" class="py-1">
                            {{ match($remark) {
                                \App\Enums\RejectionRemark::BLURRY => 'Document is too blurry',
                                \App\Enums\RejectionRemark::CORRUPT => 'File is corrupted',
                                \App\Enums\RejectionRemark::EXPIRED => 'Document has expired',
                                \App\Enums\RejectionRemark::INVALID => 'Invalid document',
                                \App\Enums\RejectionRemark::INCOMPLETE => 'Incomplete information'
                            } }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="px-4 py-3 bg-gray-50 text-right rounded-b-lg space-x-2">
                <button type="button" 
                        onclick="hideRejectModal()"
                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    <i class="fas fa-times mr-1.5"></i>
                    Reject
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Replace the existing Reset Modal with this improved version -->
<div id="resetModal" class="fixed inset-0 bg-gray-900/75 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-sm w-full mx-4 transform transition-all">
        <div class="px-4 py-3 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-800">Reset Permit Status</h3>
        </div>
        
        <div class="p-4">
            <p class="text-sm text-gray-600">
                Are you sure you want to reset this permit's status? This will set it back to pending review.
            </p>
        </div>

        <div class="px-4 py-3 bg-gray-50 text-right rounded-b-lg space-x-2">
            <button type="button" 
                    onclick="hideResetModal()"
                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                Cancel
            </button>
            <form action="{{ route('admin.users.reset-permit-status', $user->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                    <i class="fas fa-rotate mr-1.5"></i>
                    Reset
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showRejectModal() {
        const modal = document.getElementById('rejectModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hideRejectModal() {
        const modal = document.getElementById('rejectModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    function showResetModal() {
        const modal = document.getElementById('resetModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hideResetModal() {
        const modal = document.getElementById('resetModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        const rejectModal = document.getElementById('rejectModal');
        const resetModal = document.getElementById('resetModal');
        
        if (event.target === rejectModal) {
            hideRejectModal();
        }
        if (event.target === resetModal) {
            hideResetModal();
        }
    });

    // Close modals on escape key
    window.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            hideRejectModal();
            hideResetModal();
        }
    });
</script>
@endpush
@endsection
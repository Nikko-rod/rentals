@extends('layouts.dashboard')

@section('title', 'Edit User | Admin Dashboard')


@section('sidebar')
    <ul>
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
    <a href="{{ route('admin.manage-users') }}" class="nav-link {{ Request::routeIs('admin.users.edit') ? 'active' : '' }}">
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
    <div class="content-header">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Edit User</h1>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-8">
    
    <div class="content-cardd">
        <div class="max-w-3xl mx-auto">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div>
                 <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
           
                  </div>
                     <input type="text" 
                   name="first_name" 
                   id="first_name"
                   value="{{ old('first_name', $user->first_name) }}"
                   class="form-input block w-full pl-10 rounded-md border-gray-300"
                   required>
                      </div>
                        </div>

                    <div>
                              <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                      <div class="mt-1 relative rounded-md shadow-sm">
                       <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
               
                      </div>
                     <input type="text" 
                   name="last_name" 
                   id="last_name"
                   value="{{ old('last_name', $user->last_name) }}"
                   class="form-input block w-full pl-10 rounded-md border-gray-300"
                   required>
        </div>
    </div>
</div>

<div>
    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
    <div class="mt-1 relative rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
           
        </div>
        <input type="email" 
               name="email" 
               id="email"
               value="{{ old('email', $user->email) }}"
               class="form-input block w-full pl-10 rounded-md border-gray-300"
               required>
    </div>
</div>

<div>
    <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
    <div class="mt-1 relative rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          
        </div>
        <input type="tel" 
               name="contact_number" 
               id="contact_number"
               value="{{ old('contact_number', $user->contact_number) }}"
               class="form-input block w-full pl-10 rounded-md border-gray-300"
               pattern="[0-9]{11}"
               placeholder="09123456789"
               required>
    </div>
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <p class="role-display">
                        {{ ucfirst($user->role) }}
                        <span class="text-gray-400 ml-2">(Cannot be changed)</span>
                    </p>
                </div>

                <div style="margin-top: 2rem; border-top: 1px solid #e5e7eb; padding-top: 1rem;">
    <div style="display: flex; justify-content: flex-end; gap: 1rem;">
        <a href="{{ route('admin.manage-users') }}" 
           style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; background-color: white; color: #374151; text-decoration: none; transition: all 0.2s ease;">
            Cancel
        </a>
        <button type="submit" 
                style="padding: 0.5rem 1rem; border-radius: 0.5rem; background-color: #14532d; color: white; border: none; cursor: pointer; transition: all 0.2s ease;">
            Save Changes
        </button>
    </div>
</div>

                </form>
                </div>


  
          @if($user->role === 'landlord')
    <div class="mt-8 pt-6 border-t border-gray-200">
        <h3 class="text-lg font-semibold mb-4">Business Permit</h3>
        
        @if($user->landlord && $user->landlord->business_permit)
            <div class="bg-white p-6 rounded-lg border">
            <div class="flex items-center justify-between mb-6">
                    <a href="{{ Storage::url($user->landlord->business_permit) }}" 
                       target="_blank"
                       class="inline-flex items-center text-blue-600 hover:text-blue-700">
                        <i class="fas fa-file-pdf mr-2"></i>
                        <span class="underline">Click here to view</span>
                    </a>
                    <div class="status-container">
    <div class="status-label">
        Status:
    </div>
    <div class="status-badge {{ 
        $user->landlord->approval_status->value === 'approved' ? 'status-approved' : 
        ($user->landlord->approval_status->value === 'rejected' ? 'status-rejected' : 
        'status-pending') 
    }}">
        {{ ucfirst($user->landlord->approval_status->value ?? 'pending') }}
    </div>
    <div class="status-timestamp">
        <i class="fas fa-clock"></i>
        {{ $user->landlord->updated_at->format('M d, Y h:ia') }}
    </div>
</div>
               

@if($user->landlord && $user->landlord->approval_status->value === 'pending')
    <div class="flex gap-3 mt-4">
        <form action="{{ route('admin.users.approve-permit', $user->id) }}" 
              method="POST" 
              id="approveForm"
              class="inline">
            @csrf
            <button type="submit" 
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                <i class="fas fa-check mr-2"></i>
                Approve
            </button>
        </form>

        <button type="button" 
                onclick="showRejectModal()"
                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
            <i class="fas fa-times mr-2"></i>
            Reject
        </button>
    </div>
@endif
            </div>
        @else
            <div class="text-center py-8 bg-gray-50 rounded-lg border-2 border-dashed">
                <p class="text-gray-500">No business permit uploaded yet</p>
            </div>
        @endif
    </div>
@endif



          





<div id="rejectModal" style="position: fixed; inset: 0; background-color: rgba(0, 0, 0, 0.5); display: none; align-items: center; justify-content: center; z-index: 50;">
    <div style="background: white; border-radius: 0.75rem; width: 100%; max-width: 450px; margin: 1rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <!-- Modal Header -->
        <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb; background-color: #f8fafc;">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937;">Select Reason for Rejection</h3>
        </div>
        
        <!-- Modal Body -->
        <form id="rejectForm" action="{{ route('admin.users.reject-permit', $user->id) }}" method="POST">
            @csrf
            <div style="padding: 1.5rem; max-height: 60vh; overflow-y: auto;">
                <!-- Radio Options -->
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <label style="display: flex; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s; margin: 0;">
                        <input type="radio" name="rejection_remark" value="blurry" required style="width: 1rem; height: 1rem; margin-right: 0.75rem;">
                        <span style="color: #374151;">Blurry Document</span>
                    </label>

                    <label style="display: flex; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s; margin: 0;">
                        <input type="radio" name="rejection_remark" value="corrupt_file" style="width: 1rem; height: 1rem; margin-right: 0.75rem;">
                        <span style="color: #374151;">Corrupt File</span>
                    </label>

                    <label style="display: flex; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s; margin: 0;">
                        <input type="radio" name="rejection_remark" value="expired_document" style="width: 1rem; height: 1rem; margin-right: 0.75rem;">
                        <span style="color: #374151;">Expired Document</span>
                    </label>

                    <label style="display: flex; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s; margin: 0;">
                        <input type="radio" name="rejection_remark" value="invalid_document" style="width: 1rem; height: 1rem; margin-right: 0.75rem;">
                        <span style="color: #374151;">Invalid Document</span>
                    </label>

                    <label style="display: flex; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s; margin: 0;">
                        <input type="radio" name="rejection_remark" value="incomplete_information" style="width: 1rem; height: 1rem; margin-right: 0.75rem;">
                        <span style="color: #374151;">Incomplete Information</span>
                    </label>
                </div>
            </div>

            <!-- Modal Footer -->
            <div style="padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb; background-color: #f8fafc; display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button type="button" 
                        onclick="hideRejectModal()" 
                        style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background-color: white; color: #374151; font-weight: 500; transition: all 0.2s;">
                    Cancel
                </button>
                <button type="submit" 
                        style="padding: 0.5rem 1rem; border-radius: 0.375rem; background-color: #dc2626; color: white; border: none; font-weight: 500; transition: all 0.2s;">
                    Confirm Rejection
                </button>
            </div>
        </form>
    </div>
</div>

@endsection






@section('scripts')
<script>
function showRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    document.getElementById('rejectForm').reset();
    document.getElementById('rejection_error').classList.add('hidden');
    
    setTimeout(() => {
        document.getElementById('rejection_remark').focus();
    }, 100);
}

function hideRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') hideRejectModal();
});

document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) hideRejectModal();
});


document.getElementById('approveForm').addEventListener('submit', function(e) {
    e.preventDefault();
    if (confirm('Are you sure you want to approve this business permit?')) {
        this.submit();
    }
});

document.querySelector('.modal-content').addEventListener('click', function(e) {
    e.stopPropagation();
});
</script>
@endsection























@section('styles')
<style>

.btn-approve {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background-color: #059669;
    color: white;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-approve:hover {
    background-color: #047857;
}

.btn-reject {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background-color: #dc2626;
    color: white;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-reject:hover {
    background-color: #b91c1c;
}
#rejectModal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 50;
}

#rejectModal.active {
    display: flex !important;
}

.modal-content {
    background: white;
    border-radius: 0.5rem;
    width: 100%;
    max-width: 28rem;
    margin: 1rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    transform: translateY(0);
    transition: transform 0.3s ease-out;
}

#rejectModal.active .modal-content {
    transform: translateY(0);
}
    /* Card Styles */
    .content-wrapper {
        max-width: 1280px;
        margin: 0 auto;
        padding: 2rem;
    }

    .content-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .content-cardd {
        background: var(--white);
        border-radius: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .content-cardd:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Form Styles */
    .form-input {
    height: 2.75rem;
    padding: 0.625rem 0.875rem;
    font-size: 0.9375rem;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    background-color:rgb(247, 247, 247);
    transition: all 0.2s ease;
    padding-left: 1rem;
    margin-bottom: 1rem;
}

.form-input:hover {
    border-color: #d1d5db;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
    background-color: white;
}

.form-input::placeholder {
    color:rgb(235, 236, 239);
    font-size: 0.875rem;
}
.form-input.border-red-500 {
    border-color: #ef4444;
}

.form-input.border-red-500:focus {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

/* Input icons */
.relative .fas {
    font-size: 1rem;
}

/* Input group hover effect */
.relative:hover .fas {
    color: #6b7280;
}

.relative:focus-within .fas {
    color: var(--primary);
}

    /* Button Styles */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 120px;
        padding: 0.5rem 1.25rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.2s ease;
        margin-top: 1rem;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
        height: 2.75rem;
    }

    .btn-primary:hover {
        background-color: var(--primary-light);
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .btn-secondary {
        background-color: white;
        color: #374151;
        border: 1px solid #d1d5db;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background-color:rgb(204, 205, 207);
        transform: translateY(-1px);
    }

    /* Label Styles */
    label {
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #374151;
        margin-top: 1rem;
    }

    /* Error Styles */
    .bg-red-50 {
        border-left: 4px solid #ef4444;
        margin-bottom: 1.5rem;
    }

    /* Role Display */
    .role-display {
        background-color: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        width : fit-content;
    }

    /* Grid Layout */
    .grid {
        gap: 1.5rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 640px) {
        .grid-cols-2 {
            grid-template-columns: 1fr;
        }

        .content-wrapper {
            padding: 1rem;
        }

        .content-cardd {
            padding: 1.5rem;
        }
    }
    .mt-1 {
        margin-top: 0.5rem !important;
    }

    .pt-5 {
        padding-top: 2rem !important;
    }

    .status-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background-color: #f8fafc;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
}

.status-label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 500;
    display: flex;
    align-items: center;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: capitalize;
}

.status-approved {
    background-color: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.status-rejected {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.status-pending {
    background-color: #fef9c3;
    color: #854d0e;
    border: 1px solid #fef08a;
}

.status-timestamp {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.75rem;
    color: #64748b;
    margin-left: auto;
}

.status-timestamp i {
    font-size: 0.875rem;
}

</style>
@endsection
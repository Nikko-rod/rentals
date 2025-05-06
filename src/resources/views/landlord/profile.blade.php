@extends('layouts.final-dashboard')

@section('title', 'Profile | Rentals Tacloban')
@section('dashboard-title', 'Landlord Portal')
@section('page-title', 'Dashboard')


@section('sidebar-menu')
    <a href="{{ route('landlord.dashboard') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('landlord.dashboard') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-home w-5"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('landlord.properties.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('landlord.properties.*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-building w-5"></i>
        <span>Properties</span>
    </a>

    <a href="{{ route('landlord.inquiries.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('landlord.inquiries.*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
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
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Profile Information -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Profile Information</h2>
            </div>

            <form action="{{ route('landlord.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" 
                               name="first_name" 
                               id="first_name" 
                               value="{{ old('first_name', $user->first_name) }}" 
                               class="mt-1 block w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring-green-500"
                               pattern="[A-Za-z\s]+"
                               title="Please enter letters only"
                               required>
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" 
                               name="last_name" 
                               id="last_name" 
                               value="{{ old('last_name', $user->last_name) }}" 
                               class="mt-1 block w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring-green-500"
                               pattern="[A-Za-z\s]+"
                               title="Please enter letters only"
                               required>
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <div class="relative">
                        <input type="tel" 
                               name="contact_number" 
                               id="contact_number" 
                               value="{{ old('contact_number', $user->contact_number) }}" 
                               class="block w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring-green-500"
                               pattern="[0-9]{11}"
                               title="Please enter exactly 11 digits"
                               maxlength="11"
                               required>
                    </div>
                    @error('contact_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-6 border-t border-gray-200 space-y-2">
                    <label for="current_password" class="block text-sm font-medium text-gray-700">
                        Current Password to Confirm Changes
                    </label>
                    <input type="password" 
                           name="current_password" 
                           id="current_password" 
                           class="mt-1 block w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring-green-500"
                           required>
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end pt-6">
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition duration-300">
                        <i class="fas fa-save"></i>
                        <span>Save Changes</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Business Permit Card -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-6">Business Permit</h2>

            <!-- Status Section -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-100">
                <div class="flex flex-col space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Verification Status:</span>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            {{ $user->landlord->isApproved() ? 'bg-green-100 text-green-800' : 
                               ($user->landlord->isPending() ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $user->landlord->approval_status->label() }}
                        </span>
                    </div>

                    @if($user->landlord->isRejected() && $user->landlord->rejection_remark)
                        <div class="flex items-start gap-3 p-3 bg-red-50 rounded-lg border border-red-100">
                            <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                            <div class="flex-1">
                                <span class="block text-sm text-gray-600 mb-1">Rejection Reason:</span>
                                <p class="text-red-600 font-medium">{{ $user->landlord->getRejectionMessage() }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Current Permit -->
            @if($user->landlord->permits)
                <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-file-pdf text-green-600"></i>
                            <span class="font-medium text-gray-700">Current Business Permit</span>
                        </div>
                        <a href="{{ Storage::url($user->landlord->permits) }}" 
                           target="_blank" 
                           class="text-green-700 hover:text-green-800 inline-flex items-center gap-2">
                            <span>View</span>
                            <i class="fas fa-external-link-alt text-sm"></i>
                        </a>
                    </div>
                </div>
            @endif

         <!-- Upload Form -->
<form action="{{ route('landlord.profile.upload-permit') }}" 
      method="POST" 
      enctype="multipart/form-data" 
      id="permitForm"
      class="space-y-4">
    @csrf
    
    @if($user->landlord->isRejected())
<div class="border-2 border-dashed border-gray-200 rounded-lg hover:border-green-500 transition-colors">
    <div id="dropZone" 
         class="p-6 text-center transition-all duration-200 cursor-pointer">
        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-3 block"></i>
        <p class="font-medium text-gray-700 mb-1">Drop your business permit here</p>
        <p class="text-sm text-gray-500">or click to browse</p>
        <p class="text-xs text-gray-400 mt-1">PDF files only, max 2MB</p>
        <input type="file" 
               name="business_permit" 
               accept=".pdf" 
               class="hidden" 
               id="permit-input">
    </div>
</div>
    @elseif($user->landlord->isPending())
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center gap-2 text-yellow-800">
                <i class="fas fa-clock"></i>
                <p>Please wait for your current permit to be reviewed.</p>
            </div>
        </div>
    @elseif($user->landlord->isApproved())
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center gap-2 text-green-800">
                <i class="fas fa-check-circle"></i>
                <p>Your business permit is verified.</p>
            </div>
        </div>
    @endif

    <div class="hidden" id="fileInfo">
    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
        <div class="flex items-center gap-2">
            <i class="fas fa-file-pdf text-green-600"></i>
            <span id="fileName" class="text-sm font-medium text-gray-700">No file selected</span>
        </div>
        <button type="button" 
                onclick="clearFile()"
                class="text-gray-400 hover:text-red-500 transition-colors">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

<button type="submit" 
        id="submitBtn"
        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
        disabled>
    <i class="fas fa-upload"></i>
    <span>Upload Permit</span>
</button>
</form>



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('permit-input');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const submitBtn = document.getElementById('submitBtn');

    // Exit if not in rejected state
    if (!dropZone || !fileInput) return;

    // Initialize click handling
    dropZone.addEventListener('click', function(e) {
        if (e.target !== fileInput) {
            fileInput.click();
        }
    });

    // File input change handler
    fileInput.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files.length) {
            processFile(files[0]);
        }
    });

    // Drag and drop handlers
    dropZone.addEventListener('dragenter', handleDragEnter);
    dropZone.addEventListener('dragleave', handleDragLeave);
    dropZone.addEventListener('dragover', handleDragOver);
    dropZone.addEventListener('drop', handleDrop);

    function handleDragEnter(e) {
        e.preventDefault();
        dropZone.classList.add('bg-green-50');
        dropZone.parentElement.classList.add('border-green-500');
    }

    function handleDragLeave(e) {
        e.preventDefault();
        dropZone.classList.remove('bg-green-50');
        dropZone.parentElement.classList.remove('border-green-500');
    }

    function handleDragOver(e) {
        e.preventDefault();
    }

    function handleDrop(e) {
        e.preventDefault();
        dropZone.classList.remove('bg-green-50');
        dropZone.parentElement.classList.remove('border-green-500');

        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length) {
            processFile(files[0]);
        }
    }

    function processFile(file) {
        console.log('Processing file:', file);

        if (file.type !== 'application/pdf') {
            showError('Only PDF files are allowed');
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            showError('File size must be less than 2MB');
            return;
        }

        // Update file input
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;

        // Update UI
        fileName.textContent = file.name;
        fileInfo.classList.remove('hidden');
        submitBtn.disabled = false;
    }

    function showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'text-red-600 text-sm mt-2';
        errorDiv.textContent = message;

        const existingError = dropZone.parentElement.nextElementSibling;
        if (existingError?.classList.contains('text-red-600')) {
            existingError.remove();
        }

        dropZone.parentElement.after(errorDiv);
        clearFile();
        
        setTimeout(() => errorDiv.remove(), 3000);
    }

    function clearFile() {
        fileInput.value = '';
        fileName.textContent = 'No file selected';
        fileInfo.classList.add('hidden');
        submitBtn.disabled = true;
    }

    // Add clear file handler to window
    window.clearFile = clearFile;
});
</script>
@endpush


@endsection


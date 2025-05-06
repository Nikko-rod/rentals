@extends('layouts.final-dashboard')

@section('title', 'Profile | Rentals Tacloban')
@section('dashboard-title', 'Tenant Portal')
@section('page-title', 'Profile')

@section('sidebar-menu')
    <a href="{{ route('tenant.dashboard') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('tenant.dashboard') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-home w-5"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('tenant.properties.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('tenant.properties.*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-search w-5"></i>
        <span>Browse Properties</span>
    </a>

    <a href="{{ route('tenant.inquiries.index') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('tenant.inquiries.*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-message w-5"></i>
        <span>Inquiries</span>
    </a>

    <a href="{{ route('tenant.profile') }}" 
       class="flex items-center gap-3 p-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105
              {{ Request::routeIs('tenant.profile') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-user-circle w-5"></i>
        <span>Profile</span>
    </a>
@endsection


@section('sidebar')
    <li class="nav-item">
        <a href="{{ route('tenant.dashboard') }}" class="nav-link">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('tenant.properties.index') }}" class="nav-link">
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
        <a href="{{ route('tenant.profile') }}" class="nav-link active">
            <i class="fas fa-user-circle"></i>
            <span>Profile</span>
        </a>
    </li>
@endsection

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Profile Information</h2>
            </div>

            <form action="{{ route('tenant.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" 
                               name="first_name" 
                               id="first_name" 
                               value="{{ old('first_name', $user->first_name) }}" 
                               class="mt-1 block w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring-green-500"
                               pattern="[A-Za-z\s]+"
                               title="Please enter letters only"
                               minlength="2"
                               maxlength="50"
                               required>
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" 
                               name="last_name" 
                               id="last_name" 
                               value="{{ old('last_name', $user->last_name) }}" 
                               class="mt-1 block w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring-green-500"
                               pattern="[A-Za-z\s]+"
                               title="Please enter letters only"
                               minlength="2"
                               maxlength="50"
                               required>
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <div class="relative mt-1">
                        
                        <input type="tel" 
                               name="contact_number" 
                               id="contact_number" 
                               value="{{ old('contact_number', $user->contact_number) }}" 
                               class=" block w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring-green-500"
                               pattern="[0-9]{11}"
                               title="Please enter exactly 11 digits"
                               maxlength="11"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               required>
                    </div>
                    @error('contact_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                <div class="pt-6 border-t border-gray-200">
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
                            class="inline-flex items-center px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition duration-300">
                        <i class="fas fa-save mr-2"></i>
                        <span>Save Changes</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.final-dashboard')

@section('title', 'Inquiry | Rentals Tacloban')
@section('dashboard-title', 'Landlord Portal')
@section('page-title', 'Inquiries')



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
<div class="max-w-7xl mx-auto space-y-4">
    <!-- Property Info Card -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <div class="flex items-center gap-4">
                <a href="{{ route('landlord.inquiries.index') }}" 
                   class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition duration-300">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="text-lg font-semibold text-gray-800">{{ $inquiry->property->title }}</h2>
            </div>
        </div>

        <div class="p-4">
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center gap-2 bg-green-50 text-green-800 px-3 py-1.5 rounded-lg border border-green-100">
                    <i class="fas fa-peso-sign text-green-600"></i>
                    <span class="font-medium">{{ number_format($inquiry->quoted_monthly_rent, 2) }}</span>
                </div>
                <div class="flex items-center gap-2 bg-purple-50 text-purple-800 px-3 py-1.5 rounded-lg border border-purple-100">
                    <i class="fas fa-home text-purple-600"></i>
                    <span>{{ ucfirst($inquiry->quoted_type) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-100">
    <h3 class="font-semibold text-gray-800 flex items-center gap-2">
        {{ $inquiry->tenant->first_name }} {{ $inquiry->tenant->last_name }}
        <span class="text-sm text-gray-500">({{ $inquiry->tenant->contact_number }})</span>
    </h3>
</div>

        <!-- Messages -->
        <div class="p-4 max-h-[500px] overflow-y-auto space-y-4 bg-gray-50" id="messageContainer">
    @foreach($messages as $message)
        <div class="flex {{ $message->is_landlord ? 'justify-end' : 'justify-start' }}">
            <div class="max-w-[400px] space-y-1"> <!-- Changed from 70% to fixed width -->
                <div class="px-4 py-2 rounded-t-xl break-words whitespace-pre-wrap overflow-hidden text-sm
                    {{ $message->is_landlord ? 'bg-green-600 text-white rounded-bl-xl rounded-br-sm' : 'bg-white text-gray-800 rounded-br-xl rounded-bl-sm' }} 
                    shadow-sm">
                    {!! nl2br(e($message->message)) !!}
                </div>
                <div class="text-xs text-gray-500 {{ $message->is_landlord ? 'text-right' : 'text-left' }}">
                    {{ $message->created_at->format('M j, Y g:i A') }} • 
                    {{ $message->is_landlord ? 'You' : 'Tenant' }}
                </div>
            </div>
        </div>
    @endforeach
</div>

        <!-- Message Input -->
        <div class="p-4 border-t border-gray-100 bg-white">
    <form action="{{ route('landlord.inquiries.reply', $inquiry) }}" method="POST" class="space-y-3">
        @csrf
        <div class="relative">
            <textarea name="message" 
                    id="messageInput"
                    class="w-full min-h-[100px] p-3 rounded-lg border border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200 resize-none"
                    placeholder="Type your message... (max 150 characters)"
                    maxlength="150"
                    required></textarea>
            <div class="absolute bottom-2 right-2 text-sm text-gray-500">
                <span id="charCount">0</span>/150
            </div>
            @error('message')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition duration-300">
                <span>Send</span>
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </form>
</div>


@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageInput = document.getElementById('messageInput');
    const charCount = document.getElementById('charCount');
    const messageContainer = document.getElementById('messageContainer');

    messageContainer.scrollTop = messageContainer.scrollHeight;

    function updateCharCount() {
        const count = messageInput.value.length;
        charCount.textContent = count;
        
        if (count >= 120) {
            charCount.classList.add('text-yellow-600');
        } else if (count >= 140) {
            charCount.classList.remove('text-yellow-600');
            charCount.classList.add('text-red-600');
        } else {
            charCount.classList.remove('text-yellow-600', 'text-red-600');
        }
    }

    messageInput.addEventListener('input', updateCharCount);
    messageInput.addEventListener('keyup', updateCharCount);

    messageInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (messageInput.value.trim()) {
                this.form.submit();
            }
        }
    });

    updateCharCount();
});
</script>
@endpush

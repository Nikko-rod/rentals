@extends('layouts.dashboard')

@section('title', 'Inquiry Details | Rentals Tacloban')
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
        <a href="{{ route('tenant.inquiries.index') }}" class="nav-link active">
            <i class="fas fa-message"></i>
            <span>Inquiries</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('tenant.profile') }}" class="nav-link">
            <i class="fas fa-user-circle"></i>
            <span>Profile</span>
        </a>
    </li>
@endsection

@section('styles')
<style>
.btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: var(--primary);
        color: var(--white);
        border: none;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
    }
    .chat-container {
        background: var(--white);
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 1rem;
    }

    .chat-header {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--secondary);
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .chat-body {
        padding: 1rem;
        max-height: 400px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .message {
        display: flex;
        flex-direction: column;
        max-width: 70%;
    }

    .message.tenant {
        align-self: flex-end;
    }

    .message.landlord {
        align-self: flex-start;
    }

    .message-content {
        padding: 0.75rem 1rem;
        border-radius: 1rem;
        font-size: 0.875rem;
        position: relative;
    }

    .tenant .message-content {
        background: var(--primary);
        color: var(--white);
        border-bottom-right-radius: 0.25rem;
    }

    .landlord .message-content {
        background: var(--secondary);
        border-bottom-left-radius: 0.25rem;
    }

    .message-meta {
        font-size: 0.75rem;
        color: var(--text-light);
        margin-top: 0.25rem;
    }
    .message-limit-warning {
        text-align: center;
        color: var(--warning);
        padding: 1rem;
    }

    .inquiry-rejected {
        text-align: center;
        color: var(--danger);
        padding: 1rem;
    }

    .contact-info {
        text-align: center;
        color: var(--success);
        padding: 1rem;
    }

    .contact-number {
        margin-top: 0.5rem;
        font-weight: 500;
        font-size: 1.1rem;
    }

    .tenant .message-meta { text-align: right; }
    .landlord .message-meta { text-align: left; }

    .chat-footer {
        padding: 1rem;
        border-top: 1px solid var(--border-color);
    }

    .property-info {
        background: var(--white);
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .contact-info {
        background: var(--success-light);
        color: var(--success);
        padding: 1rem;
        border-radius: 0.5rem;
        text-align: center;
    }

    .form-input {
        width: 100%;
        min-height: 80px;
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        resize: vertical;
        transition: border-color 0.2s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
    }

    .error-text {
        color: var(--danger);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    .message-input-container {
        margin-bottom: 1rem;
    }

    .message-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }
    
</style>
@endsection



@section('content')
<div class="content-card">
    <!-- Property Info Section -->
    <div class="property-info">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">
            {{ $inquiry->property->title }}
        </h2>
        <div style="display: flex; gap: 2rem; font-size: 0.875rem;">
            <div>
                <p style="color: var(--text-light);">Monthly Rent (Quoted)</p>
                <p style="font-weight: 500;">₱{{ number_format($inquiry->quoted_monthly_rent, 2) }}</p>
            </div>
            <div>
                <p style="color: var(--text-light);">Property Type</p>
                <p style="font-weight: 500;">{{ ucfirst($inquiry->quoted_type) }}</p>
            </div>
            <div>
                <p style="color: var(--text-light);">Contact Number</p>
                <p style="font-weight: 500;">{{ $inquiry->quoted_contact_number }}</p>
            </div>
        </div>
    </div>

    <!-- Chat Container -->
    <div class="chat-container">
        <div class="chat-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="font-weight: 600;">Messages</h3>
                    <p style="font-size: 0.875rem; color: var(--text-light);">
                        {{ $messages->count() ?? 0 }}/10 messages
                    </p>
                </div>
            </div>
        </div>

        <div class="chat-body">
            @foreach($messages as $message)
                <div class="message {{ $message->is_landlord ? 'landlord' : 'tenant' }}">
                    <div class="message-content">
                        {{ $message->message }}
                    </div>
                    <div class="message-meta">
                        {{ $message->created_at->format('M j, Y g:i A') }} • 
                        {{ $message->is_landlord ? 'Landlord' : 'You' }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="chat-footer">
    @php
        $lastMessage = $messages->last();
        $canReply = !$lastMessage || $lastMessage->is_landlord;
        $messageCount = $messages->count();
    @endphp

    @if($messageCount >= 10)
        <div class="message-limit-warning">
            <i class="fas fa-exclamation-circle"></i>
            Maximum messages reached (10/10)
        </div>
    @elseif(!$canReply)
        <p class="text-center text-warning">
            <i class="fas fa-clock"></i>
            Waiting for landlord's response...
        </p>
    @else
        <form action="{{ route('tenant.inquiries.reply', $inquiry) }}" method="POST">
            @csrf
            <div class="message-input-container">
                <textarea name="message" 
                        class="form-input @error('message') error @enderror"
                        placeholder="Type your message... (max 150 characters)"
                        maxlength="150"
                        required></textarea>
                @error('message')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
            <div class="message-actions">
                <button type="submit" class="btn-primary btn-icon" title="Send Message">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    @endif
</div>

    <!-- Back Button -->
    <div style="margin-top: 1rem; text-align: right;">
        <a href="{{ route('tenant.inquiries.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Back to Inquiries
        </a>
    </div>
</div>
@endsection
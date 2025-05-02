@extends('layouts.dashboard')

@section('title', 'My Inquiries | Rentals Tacloban')

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
    .inquiry-list {
        background: var(--white);
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 0.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .inquiry-item {
        padding: 1rem;
        border-radius: 0.375rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid var(--border-color);
    }

    .inquiry-item:hover {
        background: var(--secondary-light);
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border-color: var(--primary);
    }

    .inquiry-content {
        flex: 1;
    }

    .inquiry-meta {
        font-size: 0.75rem;
        color: var(--text-light);
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 500;
        white-space: nowrap;
    }

    .message-preview {
        color: var(--text-light);
        font-size: 0.875rem;
        margin-top: 0.25rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 400px;
        transition: color 0.2s ease;
    }

    .inquiry-item:hover .message-preview {
        color: var(--text-dark);
    }

    .property-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.75rem;
        color: var(--text-light);
        margin-top: 0.5rem;
    }
</style>
@endsection



@section('content')
<div class="content-card">
    <div style="margin-bottom: 1rem;">
        <h1 style="font-size: 1.25rem; font-weight: 600;">My Inquiries</h1>
    </div>

    @if($inquiries->count() > 0)

            @foreach($inquiries as $inquiry)
                <div class="inquiry-item" onclick="window.location.href='{{ route('tenant.inquiries.show', $inquiry) }}'">
                    <div class="inquiry-content">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="font-size: 0.875rem; font-weight: 600;">
                                {{ $inquiry->property->title }}
                            </h3>
                            <div class="inquiry-meta">
                                <span>{{ $inquiry->created_at->diffForHumans() }}</span>
                                <span class="status-badge status-{{ $inquiry->status }}">
                                    {{ ucfirst($inquiry->status) }}
                                </span>
                            </div>
                        </div>

                        <p class="message-preview">
                            {{ Str::limit($inquiry->message, 100) }}
                        </p>

                        <div class="property-meta">
                            <span>
                                <i class="fas fa-peso-sign"></i>
                                {{ number_format($inquiry->quoted_monthly_rent, 2) }}
                            </span>
                            <span>
                                <i class="fas fa-home"></i>
                                {{ ucfirst($inquiry->quoted_type) }}
                            </span>
                            <span>
                                <i class="fas fa-phone"></i>
                                {{ $inquiry->quoted_contact_number }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach

        <div style="margin-top: 1rem;">
            {{ $inquiries->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 2rem 0;">
            <i class="fas fa-message" style="font-size: 2rem; color: var(--text-light); margin-bottom: 0.5rem;"></i>
            <p style="color: var(--text-light); font-size: 0.875rem;">No inquiries yet</p>
            <a href="{{ route('tenant.properties.index') }}" class="btn-primary" style="display: inline-block; margin-top: 1rem;">
                Browse Properties
            </a>
        </div>
    @endif
</div>
@endsection
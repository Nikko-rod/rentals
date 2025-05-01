@extends('layouts.dashboard')

@section('title', 'Tenant Dashboard | Rentals Tacloban')

@section('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--white);
        padding: 1.5rem;
        border-radius: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        background: var(--primary);
        color: var(--white);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.25rem;
    }

    .stat-value {
        font-size: 1.875rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: var(--text-light);
        font-size: 0.875rem;
    }

    .dashboard-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 2rem;
        color: var(--text-dark);
    }
</style>
@endsection

@section('sidebar')
        <li class="nav-item">
            <a href="{{ route('tenant.dashboard') }}" class="nav-link active">
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
          <a href="{{ route('tenant.profile') }}" class="nav-link {{ Request::routeIs('tenant.profile') ? 'active' : '' }}">
        <i class="fas fa-user-circle"></i>
        <span>Profile</span>
          </a>    
        </li>
@endsection

@section('content')
<h1 class="dashboard-title">Welcome back, {{ auth()->user()->first_name }}! 👋</h1>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-building"></i>
        </div>
        <div class="stat-value">0</div>
        <div class="stat-label">Active Applications</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-key"></i>
        </div>
        <div class="stat-value">0</div>
        <div class="stat-label">Current Rentals</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-heart"></i>
        </div>
        <div class="stat-value">0</div>
        <div class="stat-label">Saved Properties</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-message"></i>
        </div>
        <div class="stat-value">0</div>
        <div class="stat-label">Unread Messages</div>
    </div>
</div>
@endsection
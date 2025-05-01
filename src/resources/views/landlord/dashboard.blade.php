@extends('layouts.dashboard')

@section('title', 'Landlord Dashboard | Rentals Tacloban')

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
        transition: transform 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
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

    .recent-activity {
        background: var(--white);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .activity-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-dark);
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-radius: 0.5rem;
        background: var(--secondary);
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection

@section('sidebar')
        <li class="nav-item">
            <a href="{{ route('landlord.dashboard') }}" class="nav-link active">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
        <a href="{{ route('landlord.properties.index') }}" class="nav-link">
                <i class="fas fa-building"></i>
                <span>Properties</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-message"></i>
                <span>Inquiries</span>
            </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('landlord.profile') }}" class="nav-link {{ Request::routeIs('landlord.profile') ? 'active' : '' }}">
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
        <div class="stat-label">Listed Properties</div>
    </div>
    
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-message"></i>
        </div>
        <div class="stat-value">0</div>
        <div class="stat-label">Unread Messages</div>
    </div>
</div>

<div class="recent-activity">
    <div class="activity-header">
        <h2 class="activity-title">Recent Activity</h2>
    </div>
    <div class="activity-list">
        <div class="activity-item">
            <div class="activity-icon">
                <i class="fas fa-info"></i>
            </div>
            <div>No recent activity to show.</div>
        </div>
    </div>
</div>
@endsection
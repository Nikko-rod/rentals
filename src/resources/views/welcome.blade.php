@extends('layouts.main')

@section('title', 'Welcome to Rentals Tacloban')

@section('styles')
<style>
    .welcome-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 5rem); /* Adjust for header */
        padding: 2rem;
        text-align: center;
        max-width: 1200px;
        margin: 0 auto;
    }

    .welcome-title {
        font-size: 3.5rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 1.5rem;
        line-height: 1.2;
        letter-spacing: -1px;
        animation: fadeInUp 1s ease;
    }

    .subtitle {
        font-size: 1.25rem;
        color: var(--text-light);
        margin-bottom: 2.5rem;
        max-width: 600px;
        animation: fadeInUp 1s ease 0.2s both;
    }

    .cta-buttons {
        display: flex;
        gap: 1rem;
        animation: fadeInUp 1s ease 0.4s both;
    }

    .cta-button {
        padding: 1rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .primary-cta {
        background-color: var(--primary);
        color: var(--white);
    }

    .primary-cta:hover {
        background-color: var(--primary-hover);
        transform: translateY(-2px);
    }

    .secondary-cta {
        background-color: var(--secondary);
        color: var(--primary);
    }

    .secondary-cta:hover {
        background-color: #e2e8f0;
        transform: translateY(-2px);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .welcome-title {
            font-size: 2.5rem;
        }

        .cta-buttons {
            flex-direction: column;
        }

        .welcome-container {
            padding: 1rem;
        }
    }
    
    
</style>
@endsection

@section('content')
<div class="welcome-container">
    <h1 class="welcome-title">Find Your Perfect Home in Tacloban</h1>
    <p class="subtitle">Discover the ideal rental property or list your space on the premier rental platform in Tacloban City.</p>
    <div class="cta-buttons">
        <a href="{{ url('/register/tenant') }}" class="cta-button primary-cta">
            <i class="fas fa-search"></i> Start Your Search
        </a>
        <a href="{{ url('/register/landlord') }}" class="cta-button secondary-cta">
            <i class="fas fa-home"></i> List Your Property
        </a>
    </div>
</div>
@endsection
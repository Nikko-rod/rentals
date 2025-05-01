@extends('layouts.main')

@section('title', 'Verify Email | Rentals Tacloban')

@section('content')
<div class="verify-container">
    <div class="verify-box">
        <h2><i class="fas fa-envelope"></i> Verify Your Email Address</h2>
        <p>Before proceeding, please check your email for a verification link.</p>
        <p>If you did not receive the email, click the button below.</p>

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="resend-btn">
                <i class="fas fa-paper-plane"></i> Resend Verification Email
            </button>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
    .verify-container {
        min-height: calc(100vh - 5rem);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .verify-box {
        background: var(--white);
        padding: 2.5rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
        text-align: center;
    }

    .verify-box h2 {
        color: var(--primary);
        margin-bottom: 1.5rem;
    }

    .verify-box p {
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .resend-btn {
        background: var(--primary);
        color: var(--white);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .resend-btn:hover {
        background: var(--primary-hover);
        transform: translateY(-1px);
    }

    .alert {
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: var(--success);
        color: white;
    }
</style>
@endsection







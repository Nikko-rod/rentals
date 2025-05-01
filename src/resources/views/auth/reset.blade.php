@extends('layouts.main')

@section('title', 'Reset Password | Rentals Tacloban')

@section('styles')
<style>
    .reset-container {
        min-height: calc(100vh - 4rem);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        margin-top: 4rem;
    }

    .reset-form {
        background: var(--white);
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        padding: 2rem;
    }

    .reset-form h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .input-group {
        margin-bottom: 1.5rem;
    }

    .input-group label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .input-field {
        position: relative;
    }

    .input-field input {
        width: 100%;
        padding: 0.75rem 1rem;
        padding-left: 2.5rem;
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .input-field input:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(20, 83, 45, 0.1);
    }

    .input-field i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
    }

    .reset-btn {
        width: 100%;
        padding: 0.75rem;
        background: var(--primary);
        color: var(--white);
        border: none;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .reset-btn:hover {
        background: var(--primary-hover);
        transform: translateY(-1px);
    }

    .error {
        color: var(--error);
        font-size: 0.75rem;
        margin-top: 0.5rem;
        display: block;
    }

    .back-to-login {
        text-align: center;
        margin-top: 1.5rem;
    }

    .back-to-login a {
        color: var(--primary);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .back-to-login a:hover {
        text-decoration: underline;
    }
    .email-display {
        background: var(--secondary);
        padding: 0.75rem 1rem;
        padding-left: 2.5rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        position: relative;
    }

    .email-display i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
    }

</style>
@endsection

@section('content')

<div class="reset-container">
    <form method="POST" action="{{ route('password.update') }}" class="reset-form">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <h2>Reset Password</h2>

        <div class="email-display">
            <i class="fas fa-envelope"></i>
            {{ $email }}
        </div>

        <div class="input-group">
            <label for="password">New Password</label>
            <div class="input-field">
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    placeholder="Enter new password"
                    required
                    autofocus
                >
                <i class="fas fa-lock"></i>
            </div>
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-group">
            <label for="password_confirmation">Confirm Password</label>
            <div class="input-field">
                <input 
                    type="password" 
                    id="password_confirmation"
                    name="password_confirmation" 
                    placeholder="Confirm new password"
                    required
                >
                <i class="fas fa-lock"></i>
            </div>
        </div>

        <button type="submit" class="reset-btn">
            <i class="fas fa-key"></i>
            Reset Password
        </button>

        <div class="back-to-login">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left"></i>
                Back to Login
            </a>
        </div>
    </form>
</div>

@section('scripts')
@endsection
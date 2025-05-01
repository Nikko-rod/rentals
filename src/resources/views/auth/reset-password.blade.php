@extends('layouts.main')

@section('title', 'Reset Password | Rentals Tacloban')

@section('styles')
<style>
    .reset-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
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
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .reset-btn:hover {
        background: var(--primary-hover);
    }

    .error {
        color: var(--error);
        font-size: 0.75rem;
        margin-top: 0.5rem;
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
    }

    .back-to-login a:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="reset-container">
    <form method="POST" action="{{ route('password.email') }}" class="reset-form">
        @csrf

        <h2>Reset Password</h2>
        <div class="input-group">
            <label for="email">Email Address</label>
            <div class="input-field">
                <input type="email" 
                       name="email" 
                       id="email" 
                       placeholder="Enter your email"
                       value="{{ old('email') }}"
                       required 
                       autofocus>
                <i class="fas fa-envelope"></i>
            </div>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="reset-btn">
            <i class="fas fa-paper-plane"></i>
            Send Password Reset Link
        </button>

        <div class="back-to-login">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left"></i> Back to Login
            </a>
        </div>
    </form>
</div>
@endsection
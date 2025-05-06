@extends('layouts.main')

@section('title', 'Login | Rentals Tacloban')

@section('styles')
<style>
    .login-container {
        min-height: calc(100vh - 5rem);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .login-form {
        background: var(--white);
        padding: 2.5rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 420px;
        animation: fadeIn 0.3s ease-out;
    }

    .login-form h2 {
        color: var(--primary);
        font-size: 1.75rem;
        margin-bottom: 2rem;
        text-align: center;
    }

    .input-group {
        margin-bottom: 1.5rem;
    }

    .input-group label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }

    .input-field {
        position: relative;
        width: 100%;
    }

    .input-field input {
        width: 100%;
        padding: 0.75rem 1rem;
        padding-right: 2.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s;
        color: var(--text-dark);
    }

    .input-field input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(20, 83, 45, 0.1);
    }

    .input-field i {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
        cursor: pointer;
        transition: color 0.2s;
    }

    .input-field i:hover {
        color: var(--primary);
    }

    .login-btn {
        width: 100%;
        padding: 0.75rem;
        background-color: var(--primary);
        color: var(--white);
        border: none;
        border-radius: 0.5rem;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .login-btn:hover {
        background-color: var(--primary-hover);
        transform: translateY(-1px);
    }

    .forgot-password {
        display: block;
        text-align: right;
        color: var(--primary);
        text-decoration: none;
        font-size: 0.875rem;
        margin: 1rem 0;
        transition: color 0.2s;
    }

    .forgot-password:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }

    @media (max-width: 640px) {
        .login-container {
            padding: 1rem;
        }

        .login-form {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <form method="POST" action="{{ route('login') }}" class="login-form">
        @csrf
        
        @error('email')
            <div class="alert alert-error fade-in">
                {{ $message }}
            </div>
        @enderror

        @error('password')
            <div class="alert alert-error fade-in">
                {{ $message }}
            </div>
        @enderror

        <h2>Welcome Back</h2>
    
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
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <div class="input-field">
                <input type="password" 
                       name="password" 
                       id="password" 
                       placeholder="Enter your password" 
                       required>
                <i class="fas fa-eye" id="togglePassword"></i>
            </div>
        </div>

        <a href="{{ route('password.request') }}" class="forgot-password">
            <i class="fas fa-lock"></i> Forgot your password?
        </a>

        <button type="submit" class="login-btn">
            <i class="fas fa-sign-in-alt"></i> Log In
        </button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const password = document.getElementById('password');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });

</script>
@endsection
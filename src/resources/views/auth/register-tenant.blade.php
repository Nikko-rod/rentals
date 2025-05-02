@extends('layouts.main')

@section('title', 'Register as Tenant | Rentals Tacloban')

@section('styles')
<style>
    .register-container {
        min-height: calc(100vh - 5rem);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .register-form {
        background: var(--white);
        padding: 2.5rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
        animation: fadeIn 0.3s ease-out;
    }

    .register-form h2 {
        color: var(--primary);
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .register-form p {
        color: var(--text-light);
        text-align: center;
        margin-bottom: 2rem;
    }

    .form-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .input-group {
        flex: 1;
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
    }

    .input-field input {
        width: 100%;
        padding: 0.75rem 1rem;
        padding-right: 2.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s;
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

    .register-btn {
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
        margin-top: 1rem;
    }

    .register-btn:hover {
        background-color: var(--primary-hover);
        transform: translateY(-1px);
    }

    .error-message {
        color: var(--error);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    @media (max-width: 640px) {
        .register-container {
            padding: 1rem;
        }

        .register-form {
            padding: 1.5rem;
        }

        .form-row {
            flex-direction: column;
            gap: 0;
        }
    }
</style>
@endsection

@section('content')
<div class="register-container">
    <form method="POST" action="{{ route('register.tenant') }}" class="register-form">
        @csrf
        <h2>Create Your Account</h2>
        <p>Join as a tenant and find your perfect rental</p>

        <div class="form-row">
            <div class="input-group">
                <label for="first_name">First Name</label>
                <div class="input-field">
                    <input type="text" 
                           id="first_name" 
                           name="first_name" 
                           value="{{ old('first_name') }}" 
                           required 
                           autofocus>
                    <i class="fas fa-user"></i>
                </div>
                @error('first_name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <label for="last_name">Last Name</label>
                <div class="input-field">
                    <input type="text" 
                           id="last_name" 
                           name="last_name" 
                           value="{{ old('last_name') }}" 
                           required>
                    <i class="fas fa-user"></i>
                </div>
                @error('last_name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="input-group">
            <label for="contact_number">Contact Number</label>
            <div class="input-field">
                <input type="tel" 
                       id="contact_number" 
                       name="contact_number" 
                       value="{{ old('contact_number') }}" 
                       pattern="[0-9]{11}" 
                       placeholder="09123456789"
                       required>
                <i class="fas fa-phone"></i>
            </div>
            @error('contact_number')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-group">
            <label for="email">Email Address</label>
            <div class="input-field">
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required>
                <i class="fas fa-envelope"></i>
            </div>
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-row">
            <div class="input-group">
                <label for="password">Password</label>
                <div class="input-field">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required>
                    <i class="fas fa-eye" id="togglePassword"></i>
                </div>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <label for="password_confirmation">Confirm Password</label>
                <div class="input-field">
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           required>
                    <i class="fas fa-eye" id="togglePasswordConfirm"></i>
                </div>
            </div>
        </div>

        <button type="submit" class="register-btn">
            <i class="fas fa-user-plus"></i> Create Account
        </button>
    </form>
</div>
@endsection
@section('scripts')
<script>
    // Password toggle functionality
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (!input || !icon) return;
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Password validation
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirmation');
    const form = document.querySelector('.register-form');

    function createErrorMessage(inputElement, message) {
        let errorDiv = inputElement.parentElement.nextElementSibling;
        if (!errorDiv || !errorDiv.classList.contains('error-message')) {
            errorDiv = document.createElement('span');
            errorDiv.className = 'error-message';
            inputElement.parentElement.parentElement.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
    }

    function clearErrorMessage(inputElement) {
        const errorDiv = inputElement.parentElement.nextElementSibling;
        if (errorDiv && errorDiv.classList.contains('error-message')) {
            errorDiv.style.display = 'none';
        }
    }

    function validatePassword() {
        const passwordValue = password.value;
        const confirmValue = passwordConfirm.value;

        clearErrorMessage(password);
        clearErrorMessage(passwordConfirm);

        let isValid = true;

        if (passwordValue.length < 8) {
            createErrorMessage(password, 'Password must be at least 8 characters long');
            isValid = false;
        }

        if (confirmValue && passwordValue !== confirmValue) {
            createErrorMessage(passwordConfirm, 'Passwords do not match');
            isValid = false;
        }

        return isValid;
    }

    // Event Listeners
    if (password) {
        password.addEventListener('input', validatePassword);
    }
    
    if (passwordConfirm) {
        passwordConfirm.addEventListener('input', validatePassword);
    }

    const togglePasswordBtn = document.getElementById('togglePassword');
    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', () => togglePassword('password', 'togglePassword'));
    }

    const toggleConfirmBtn = document.getElementById('togglePasswordConfirm');
    if (toggleConfirmBtn) {
        toggleConfirmBtn.addEventListener('click', () => togglePassword('password_confirmation', 'togglePasswordConfirm'));
    }
</script>
@endsection
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\{
    ForgotPasswordController,
    ResetPasswordController,
    LoginController,
    TenantRegistrationController,
    LandlordRegistrationController,
    VerificationController,
    LogoutController
};
use App\Http\Controllers\Landlord\{
    LandlordProfileController,
    PropertyController,
    InquiryController as LandlordInquiryController
};
use App\Http\Controllers\HomeController;

// Auth::routes(['verify' => true]);

Route::get('/', fn () => view('welcome'))->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    
    // Registration Routes
    Route::prefix('register')->group(function () {
        Route::get('/tenant', [TenantRegistrationController::class, 'showRegistrationForm'])
            ->name('register.tenant');
        Route::post('/tenant', [TenantRegistrationController::class, 'register']);

        Route::get('/landlord', [LandlordRegistrationController::class, 'showRegistrationForm'])
            ->name('register.landlord');
        Route::post('/landlord', [LandlordRegistrationController::class, 'register']);
    });

    // Password Reset Routes
    Route::prefix('password')->group(function () {
        Route::get('/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
            ->name('password.request');
        Route::post('/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
            ->name('password.email');
        Route::get('/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
            ->name('password.reset');
        Route::post('/reset', [ResetPasswordController::class, 'reset'])
            ->name('password.update');
    });
});

// Email Verification Routes
Route::prefix('email')->group(function () {
    Route::get('/verify', [VerificationController::class, 'show'])
        ->middleware('auth')
        ->name('verification.notice');
    Route::get('/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('/verification-notification', [VerificationController::class, 'resend'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.resend');
});

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Landlord Routes
    Route::prefix('landlord')->middleware('role:landlord')->group(function () {
        Route::get('/dashboard', fn () => view('landlord.dashboard'))->name('landlord.dashboard');
        
        // Profile Routes
        Route::get('/profile', [LandlordProfileController::class, 'show'])->name('landlord.profile');
        Route::patch('/profile', [LandlordProfileController::class, 'update'])->name('landlord.profile.update');
        Route::post('/profile/upload-permit', [LandlordProfileController::class, 'uploadPermit'])
            ->name('landlord.profile.upload-permit');

        // Property Routes
        Route::resource('properties', PropertyController::class, ['as' => 'landlord'])
            ->except('show');
        Route::get('/properties/{property}', [PropertyController::class, 'show'])
            ->name('landlord.properties.show');
        Route::delete('/properties/images/{image}', [PropertyController::class, 'deleteImage'])
            ->name('landlord.properties.deleteImage');

        // Inquiry Routes
        Route::get('/inquiries', [LandlordInquiryController::class, 'index'])->name('landlord.inquiries.index');
        Route::get('/inquiries/{inquiry}', [LandlordInquiryController::class, 'show'])->name('landlord.inquiries.show');
        Route::patch('/inquiries/{inquiry}', [LandlordInquiryController::class, 'update'])->name('landlord.inquiries.update');
        Route::post('/inquiries/{inquiry}/reply', [LandlordInquiryController::class, 'reply'])->name('landlord.inquiries.reply');
    });
});

// Logout Route
Route::post('/logout', [LogoutController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

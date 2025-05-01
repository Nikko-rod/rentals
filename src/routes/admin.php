<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminPasswordResetController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Forgot Password
    Route::get('/forgot-password', [AdminPasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [AdminPasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

    // Reset Password
    Route::get('/reset-password/{token}', [AdminPasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AdminPasswordResetController::class, 'reset'])->name('password.update');

    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
         // User Management
         Route::get('/manage-users', [UserController::class, 'index'])->name('manage-users');
         Route::get('/manage-users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
         Route::patch('/manage-users/{user}', [UserController::class, 'update'])->name('users.update');
         Route::post('/manage-users/{user}/toggle-archive', [UserController::class, 'toggleArchive'])
         ->name('users.toggle-archive');
         Route::post('/{user}/approve-permit', [UserController::class, 'approvePermit'])->name('users.approve-permit');
         Route::post('/{user}/reject-permit', [UserController::class, 'rejectPermit'])->name('users.reject-permit');  
        

    });
});




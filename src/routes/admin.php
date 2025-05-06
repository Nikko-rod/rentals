<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminPasswordResetController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminPropertyController;


Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    Route::get('/forgot-password', [AdminPasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [AdminPasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AdminPasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AdminPasswordResetController::class, 'reset'])->name('password.update');

 
    Route::middleware(['auth', 'is_admin'])->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        

        Route::controller(UserController::class)->group(function () {
            Route::get('/manage-users', 'index')->name('manage-users');
            Route::get('/manage-users/{user}/edit', 'edit')->name('users.edit');
            Route::patch('/manage-users/{user}', 'update')->name('users.update');
            Route::post('/manage-users/{user}/toggle-archive', 'toggleArchive')->name('users.toggle-archive');
            Route::post('/{user}/approve-permit', 'approvePermit')->name('users.approve-permit');
            Route::post('/{user}/reject-permit', 'rejectPermit')->name('users.reject-permit');
            Route::post('/users/{user}/reset-permit-status', 'resetPermitStatus')->name('users.reset-permit-status');
            
        });

        Route::controller(AdminPropertyController::class)->group(function () {
            Route::get('/properties', 'index')->name('properties.index');
            Route::get('/properties/{property}', 'show')->name('properties.show');
            Route::patch('/properties/{property}/toggle-status', 'toggleStatus')->name('properties.toggle-status');
            Route::post('/admin/users/{user}/reset-permit-status', [AdminUserController::class, 'resetPermitStatus'])
        ->name('admin.users.reset-permit-status');
        Route::delete('/properties/{property}', [AdminPropertyController::class, 'destroy'])->name('properties.destroy');
        });
        


    });
});




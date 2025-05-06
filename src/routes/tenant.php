<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\PropertyController;
use App\Http\Controllers\Tenant\ProfileController;
use App\Http\Controllers\Auth\LogoutController;

Route::get('/register/tenant', fn () => view('auth.register-tenant'))->name('register.tenant');


Route::middleware(['auth', 'verified'])->group(function () {
 
    Route::prefix('tenant')->middleware('role:tenant')->group(function () {
        Route::get('/dashboard', fn () => view('tenant.dashboard'))
            ->name('tenant.dashboard');
            Route::post('/logout', [LogoutController::class, 'logout'])
    ->name('tenant.logout');
    });
    

     Route::get('/properties', [PropertyController::class, 'index'])
    ->name('tenant.properties.index');
    Route::get('/properties/{property}', [PropertyController::class, 'show'])
    ->name('tenant.properties.show');


    Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('tenant.profile');
Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('tenant.profile.update');


    Route::get('/inquiries', [App\Http\Controllers\Tenant\InquiryController::class, 'index'])
        ->name('tenant.inquiries.index');
    Route::post('/properties/{property}/inquire', [App\Http\Controllers\Tenant\InquiryController::class, 'store'])
        ->name('tenant.inquiries.store');

        Route::get('/inquiries/{inquiry}', [App\Http\Controllers\Tenant\InquiryController::class, 'show'])
        ->name('tenant.inquiries.show');
        Route::post('/inquiries/{inquiry}/reply', [App\Http\Controllers\Tenant\InquiryController::class, 'reply'])
        ->name('tenant.inquiries.reply');
        Route::get('/inquiries', [App\Http\Controllers\Tenant\InquiryController::class, 'index'])
        ->name('tenant.inquiries.index');
}
);
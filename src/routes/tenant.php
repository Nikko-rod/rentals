<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\PropertyController;

Route::get('/register/tenant', fn () => view('auth.register-tenant'))->name('register.tenant');


Route::middleware(['auth', 'verified'])->group(function () {
 
    Route::prefix('tenant')->middleware('role:tenant')->group(function () {
        Route::get('/dashboard', fn () => view('tenant.dashboard'))
            ->name('tenant.dashboard');
     
    });

     Route::get('/properties', [PropertyController::class, 'index'])
    ->name('tenant.properties.index');
    Route::get('/properties/{property}', [PropertyController::class, 'show'])
    ->name('tenant.properties.show');
}
);
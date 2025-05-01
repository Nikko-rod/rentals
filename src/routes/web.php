<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\TenantRegistrationController;
use App\Http\Controllers\Auth\LandlordRegistrationController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Landlord\LandlordProfileController;
use App\Http\Controllers\Landlord\PropertyController;


Auth::routes(['verify' => true]);


Route::get('/', fn () => view('welcome'))->name('home');

Route::get('/login', fn () => view('auth.login'))
    ->middleware('guest')
    ->name('login');
Route::post('/login', [LoginController::class, 'login'])
    ->middleware('guest')
    ->name('login.submit');

Route::prefix('register')->group(function () {
 
    Route::get('/tenant', [TenantRegistrationController::class, 'showRegistrationForm'])
        ->middleware('guest')
        ->name('register.tenant');
    Route::post('/tenant', [TenantRegistrationController::class, 'register'])
        ->middleware('guest');

    Route::get('/landlord', [LandlordRegistrationController::class, 'showRegistrationForm'])
        ->middleware('guest')
        ->name('register.landlord');
    Route::post('/landlord', [LandlordRegistrationController::class, 'register'])
        ->middleware('guest');
});

Route::prefix('password')->group(function () {
    Route::get('/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->middleware('guest')
        ->name('password.request');
    Route::post('/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->middleware('guest')
        ->name('password.email');
    Route::get('/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->middleware('guest')
        ->name('password.reset');
    Route::post('/reset', [ResetPasswordController::class, 'reset'])
        ->middleware('guest')
        ->name('password.update');
});

Route::prefix('email')->group(function () {
    Route::get('/verify', [VerificationController::class, 'show'])
        ->middleware(['auth'])
        ->name('verification.notice');
        
    Route::get('/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->name('verification.verify');
        
    Route::post('/verification-notification', [VerificationController::class, 'resend'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.resend');
});

Route::middleware(['auth', 'verified'])->group(function () {
 
    //landlord
    Route::prefix('landlord')->middleware('role:landlord')->group(function () {
        Route::get('/dashboard', fn () => view('landlord.dashboard'))
            ->name('landlord.dashboard');
            Route::get('/profile', [LandlordProfileController::class, 'show'])->name('landlord.profile');
            Route::post('/profile/upload-permit', [LandlordProfileController::class, 'uploadPermit'])
                 ->name('landlord.profile.upload-permit');
            Route::patch('/landlord/profile', [LandlordProfileController::class, 'update'])
                 ->name('landlord.profile.update');
         
       
    Route::get('/properties', [PropertyController::class, 'index'])
    ->name('landlord.properties.index');
    
Route::get('/properties/create', [PropertyController::class, 'create'])
    ->name('landlord.properties.create');
    
Route::post('/properties', [PropertyController::class, 'store'])
    ->name('landlord.properties.store');
    
Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])
    ->name('landlord.properties.edit');
    
Route::put('/properties/{property}', [PropertyController::class, 'update'])
    ->name('landlord.properties.update');
    
Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])
    ->name('landlord.properties.destroy');
    
Route::delete('/properties/images/{image}', [PropertyController::class, 'deleteImage'])
    ->name('landlord.properties.deleteImage');
    Route::get('/properties/{property}', [PropertyController::class, 'show'])
    ->name('landlord.properties.show');
            
                 
    
    });
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect()->route('home')
        ->with('success', 'You have been logged out successfully.');
})->middleware('auth')->name('logout');



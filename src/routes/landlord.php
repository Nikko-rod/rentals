<?php

use Illuminate\Support\Facades\Route;


//  landlord 
Route::get('/register/landlord', fn () => view('auth.register-landlord'))->name('register.landlord');

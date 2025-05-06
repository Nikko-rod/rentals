<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandlordController extends Controller
{
    public function showRegisterForm()
    {
        return view('landlord.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:landlords,email',
            'password' => 'required|confirmed|min:6',
            'business_permit' => 'required|file|mimes:pdf|max:2048',
        ]);

        return back()->with('success', 'Registration successful (stub).');
    }
}

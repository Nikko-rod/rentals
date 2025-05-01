<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Add debugging
        \Log::info('Login attempt started', ['email' => $request->email]);

        // Validate the form data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Try to authenticate
        if (Auth::attempt($credentials)) {
            \Log::info('Authentication successful', ['user' => Auth::id()]);
            
            $request->session()->regenerate();
            $user = Auth::user();

            return redirect()->intended(route($user->role . '.dashboard'))
                ->with('success', "Welcome back, {$user->first_name}!");
        }

        \Log::warning('Authentication failed', ['email' => $request->email]);

        // Authentication failed
        return back()
        ->withInput($request->only('email'))
        ->with('error', 'These credentials do not match our records.');
    }
}
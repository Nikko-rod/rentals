<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                $request->session()->regenerate();
                
                return redirect()->route('admin.dashboard')
                    ->with('success', "Welcome back, Admin {$user->first_name}!");
            }

            Auth::logout();
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Access denied. Admin privileges required.');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'The provided credentials do not match our records.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.');
    }
}
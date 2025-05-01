<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Landlord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class LandlordRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register-landlord');
    }
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_number' => 'required|string|size:11',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'business_permit' => 'required|file|mimes:pdf|max:2048',
        ]);
    
        try {
            DB::beginTransaction();
    
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'contact_number' => $validated['contact_number'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'landlord',
            ]);
    
            if ($request->hasFile('business_permit')) {
                $path = $validated['business_permit']->store('permits', 'public');
                
                Landlord::create([
                    'user_id' => $user->id,
                    'business_permit' => $path,
                    'approval_status' => 'pending',
                    'rejection_remark' => null
                ]);
            }
    
            DB::commit();
            Auth::login($user);
            
            return redirect()->route('verification.notice')
                ->with('success', 'Registration successful! Please wait for admin verification.');
    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Registration failed:', ['error' => $e->getMessage()]);
            
            return back()
                ->withInput()
                ->with('error', 'Registration failed. Please try again.');
        }
    }
}
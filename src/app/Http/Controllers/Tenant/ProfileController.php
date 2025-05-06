<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('tenant.profile', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'first_name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[A-Za-z\s]+$/',
            ],
            'last_name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[A-Za-z\s]+$/',
            ],
            'contact_number' => [
                'required',
                'string',
                'size:11',
                'regex:/^[0-9]+$/',
                Rule::unique('users')->ignore($user->id),
            ],
            'current_password' => [
                'required',
                'current_password',
            ],
        ], [
            'first_name.regex' => 'First name should contain letters and spaces only.',
            'last_name.regex' => 'Last name should contain letters and spaces only.',
            'contact_number.regex' => 'Contact number should contain numbers only.',
            'contact_number.size' => 'Contact number must be exactly 11 digits.',
            'current_password.current_password' => 'The provided password is incorrect.',
        ]);

        try {
            $user->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'contact_number' => $validated['contact_number'],
            ]);

            return back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update profile. Please try again.');
        }
    }
}
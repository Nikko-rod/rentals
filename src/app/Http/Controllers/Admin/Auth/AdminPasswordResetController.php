<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\AdminResetPassword;

class AdminPasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('admin.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)
                    ->where('role', 'admin')
                    ->first();

        if (!$user) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'This email address is not registered as an administrator.');
        }

        try {
            $token = Password::broker('admins')->createToken($user);
            $user->notify(new AdminResetPassword($token, $user->email));

            return back()->with('success', 'A password reset link has been sent to your email address.');
        } catch (\Exception $e) {
            \Log::error('Admin password reset error: ' . $e->getMessage());
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'We encountered an issue sending the reset link. Please try again.');
        }
    }

    public function showResetForm(Request $request, $token)
    {
        return view('admin.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('email', $request->email)
                    ->where('role', 'admin')
                    ->first();

        if (!$user) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'This email address is not registered as an administrator.');
        }

        $status = Password::broker('admins')->reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
                
                Auth::login($user);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Your password has been reset successfully. Welcome back!');
        }

        $errorMessages = [
            'passwords.token' => 'This password reset link is invalid or has expired.',
            'passwords.user' => 'We cannot find an administrator with that email address.',
            'passwords.throttled' => 'Please wait before retrying.',
        ];

        return back()
            ->withInput($request->only('email'))
            ->with('error', $errorMessages[$status] ?? 'An error occurred while resetting your password.');
    }
}
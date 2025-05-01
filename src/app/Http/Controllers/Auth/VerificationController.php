<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class VerificationController extends Controller
{
    use VerifiesEmails;

    public function __construct()
    {
        
    }

    public function show()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return $this->redirectBasedOnRole(auth()->user());
        }

        return view('auth.verification.notice');
    }

    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));

        if (!$user) {
            throw new AuthorizationException('Invalid user');
        }

        if (!hash_equals((string) $request->route('hash'), 
            sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException('Invalid hash');
        }

        if ($user->hasVerifiedEmail()) {
            Auth::login($user);
            return $this->redirectBasedOnRole($user);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            Auth::login($user);
        }

        return $this->redirectBasedOnRole($user)
            ->with('verified', true)
            ->with('success', 'Email verified successfully! Welcome to your dashboard.');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectBasedOnRole($request->user());
        }

        $request->user()->sendEmailVerificationNotification();

        return back()
            ->with('resent', true)
            ->with('success', 'A fresh verification link has been sent to your email.');
    }

    protected function redirectBasedOnRole($user)
    {
        return redirect()->route($user->role . '.dashboard');
    }
}
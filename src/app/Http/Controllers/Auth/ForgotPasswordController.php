<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('auth.reset-password');
    }

    /**
     * Send a password reset link to the given user.
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()->with('success', 'Password reset link has been sent to your email!');
    }

    /**
     * Get the response for a failed password reset link.
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()
            ->withInput($request->only('email'))
            ->with('error', trans($response));
    }
}
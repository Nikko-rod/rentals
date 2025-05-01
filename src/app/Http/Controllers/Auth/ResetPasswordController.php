<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Get the post password reset redirect path.
     */
    protected function redirectPath()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return route($user->role . '.dashboard');
        }
        
        return route('login');
    }

    public function showResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');
        return view('auth.reset')->with(['token' => $token, 'email' => $request->email]);
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return redirect($this->redirectPath())
            ->with('success', 'Your password has been reset successfully!');
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return back()
            ->withInput($request->only('email'))
            ->with('error', trans($response));
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view based on the user type.
     */
    public function show(Request $request): View
    {
        // Show the confirm password view for admin or user
        if ($request->is('admin/*')) {
            return view('auth.confirm-password');  // If you have a separate admin view, adjust this path
        } else {
            return view('auth.confirm-password');  // If you have a separate user view, adjust this path
        }
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the password
        if (!Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),  // Standard error message for invalid password
            ]);
        }

        // Mark password as confirmed in session
        $request->session()->put('auth.password_confirmed_at', time());

        // Redirect based on user type (admin or user)
        if ($request->is('admin/*')) {
            return redirect()->intended(route('admin.dashboard'));  // Corrected route name for admin
        } else {
            return redirect()->intended(route('user.dashboard'));   // Corrected route name for user
        }
    }
}

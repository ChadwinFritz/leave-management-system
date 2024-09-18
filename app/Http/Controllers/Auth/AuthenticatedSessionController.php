<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view based on the user type.
     */
    public function create(Request $request): View
    {
        // Check the request path to decide the login view
        if ($request->is('admin/*')) {
            return view('admin.admin_login');  // Admin login view
        } else {
            return view('user.user_login');    // User login view
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Determine if the login is for admin or user based on the request path
        $guard = $request->is('admin/*') ? 'admin' : 'web';

        // Attempt to authenticate the user for the correct guard
        $request->authenticate($guard);

        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        // Redirect to the appropriate dashboard based on the user type
        if ($guard === 'admin') {
            return redirect()->intended(route('admin.dashboard'));  // Admin dashboard route
        } else {
            return redirect()->intended(route('user.dashboard'));   // User dashboard route
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Determine the guard based on the request path
        $guard = $request->is('admin/*') ? 'admin' : 'web';

        // Log out the user for the appropriate guard
        Auth::guard($guard)->logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the homepage or login page after logout
        if ($guard === 'admin') {
            return redirect()->route('admin.login');  // Redirect to admin login page
        } else {
            return redirect()->route('user.login');   // Redirect to user login page
        }
    }
}

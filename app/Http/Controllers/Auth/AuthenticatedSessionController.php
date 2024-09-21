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
        // Determine the view to return based on the request path
        if ($request->is('admin/*')) {
            return view('admin.admin_login'); // Admin login view
        } else {
            return view('user.user_login'); // User login view
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Determine the guard based on the request path
        $guard = $request->is('admin/*') ? 'admin' : 'web';

        // Attempt to authenticate the user for the correct guard
        $credentials = $request->only('email', 'password');
        if (Auth::guard($guard)->attempt($credentials)) {
            // Regenerate the session to prevent session fixation attacks
            $request->session()->regenerate();

            // Redirect to the appropriate dashboard based on the user type
            if ($guard === 'admin') {
                return redirect()->intended(route('admin.dashboard')); // Admin dashboard route
            } else {
                return redirect()->intended(route('user.dashboard')); // User dashboard route
            }
        }

        // Authentication failed; redirect back with an error message
        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
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

        // Clear all cookies related to the session
        $cookieNames = ['remember_web', 'remember_admin']; // Adjust if your application uses different cookie names
        foreach ($cookieNames as $cookieName) {
            $request->cookies->set($cookieName, null, -1);
        }

        // Redirect to the appropriate login page after logout
        if ($guard === 'admin') {
            return redirect()->route('admin.login'); // Redirect to admin login page
        } else {
            return redirect()->route('user.login'); // Redirect to user login page
        }
    }
}

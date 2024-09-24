<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use App\Models\User;

class AdminAuthController extends Controller
{
    // Show Admin Login Form
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            // Redirect to admin dashboard if already logged in
            return redirect()->route('admin.dashboard');
        } else {
            // Return the correct admin login view
            return view('admin.admin_login');
        }
    }

    // Handle Admin Login
    public function login(Request $request)
    {
        // Validate login form input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return view('admin.admin_login')->withErrors($validator);
        }

        // Attempt to authenticate using the 'admin' guard
        if (Auth::guard('admin')->attempt([
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ])) {
            // If successfully authenticated and the user is admin
            return redirect()->route('admin.dashboard');
        } else {
            // Invalid credentials error message
            $err = new MessageBag(['i' => ['Invalid Username or Password']]);
            return redirect()->back()->withErrors($err);
        }
    }

    // Handle Admin Logout
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    // Show Admin Registration Form
    public function showRegistrationForm()
    {
        // Display the shared registration view
        return view('auth.register'); 
    }

    // Handle Admin Registration
    public function register(Request $request)
    {
        // Validate registration form input, including email
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin',  // Only allow admin role
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->route('auth.register')->withErrors($validator)->withInput();
        }

        // Create a new user
        $user = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),  // Email field added
            'password' => bcrypt($request->input('password')),
            'role' => 'admin',  // Set role to admin
            'is_admin' => true,  // Ensure proper role is set
        ]);

        // Log the user in using the default guard (web for users or admin)
        Auth::login($user);

        // Redirect to appropriate dashboard based on role
        return redirect()->route('admin.dashboard');
    }
}

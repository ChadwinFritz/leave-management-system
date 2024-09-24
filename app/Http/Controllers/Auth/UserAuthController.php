<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class UserAuthController extends Controller
{
    /**
     * Show the login page.
     */
    public function getLoginPage()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard'); // Redirect to user dashboard if already logged in
        } else {
            return view('user.user_login'); // Ensure this view exists
        }
    }

    /**
     * Handle the login POST request.
     */
    public function loginPost(Request $request)
    {
        // Validate login form input
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return redirect()->route('user.login')->withErrors($validator);
        }

        // Attempt to authenticate
        if (Auth::attempt($credentials)) {
            return redirect()->route('user.dashboard'); // Redirect to user dashboard after login
        }

        return redirect()->route('user.login')->withErrors(['login' => 'Invalid credentials']);
    }

    /**
     * Show the registration page.
     */
    public function getRegisterPage()
    {
        return view('auth.register'); // Ensure this view exists
    }

    /**
     * Handle the registration POST request.
     */
    public function register(Request $request)
    {
        // Validate registration form input, including email
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user',  // Only allow user role
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
            'password' => Hash::make($request->input('password')),
            'role' => 'user',  // Set role to user
            'is_admin' => false,  // Ensure proper role is set
        ]);

        // Log the user in
        Auth::login($user);

        // Redirect to user dashboard
        return redirect()->route('user.dashboard');
    }

    /**
     * Logout the user.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.login'); // Redirect to login page after logout
    }
}

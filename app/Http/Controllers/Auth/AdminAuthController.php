<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin; // Make sure to import the Admin model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // Show the admin login form
    public function showLoginForm()
    {
        return view('admin.index'); // Create a Blade view for the login form
    }

    // Handle the admin login request
    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Hash the password to match the stored hash
        $password = md5($request->input('password'));

        // Attempt to log the admin in
        if (Auth::attempt(['Username' => $request->input('username'), 'Password' => $password])) {
            // If successful, redirect to the dashboard
            return redirect()->intended('dashboard')->with('success', 'Login successful!');
        } else {
            // If unsuccessful, redirect back with an error message
            return back()->withErrors([
                'login_error' => 'Invalid details, please try again.',
            ]);
        }
    }

    // Handle admin logout
    public function logout()
    {
        Auth::logout();
        return redirect('admin/index')->with('success', 'You have been logged out.');
    }

    // Handle admin registration
    public function register(Request $request)
    {
        // Validate the registration form
        $request->validate([
            'Username' => 'required|string|max:100',
            'Fullname' => 'required|string|max:255',
            'Email' => 'required|string|email|max:55|unique:admin',
            'Password' => 'required|string|min:6',
        ]);

        // Create a new admin instance and save it
        Admin::create([
            'Username' => $request->Username, // Ensure the capitalization matches
            'Fullname' => $request->Fullname,
            'Email' => $request->Email,
            'Password' => bcrypt($request->Password), // Use bcrypt for password hashing
        ]);

        // Redirect to admin login page with a success message
        return redirect()->route('admin.index')->with('success', 'Registration successful! Please login.');
    }
}

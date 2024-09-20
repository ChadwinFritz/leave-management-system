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
            return view('user.user_login'); // Make sure this view exists
        }
    }

    /**
     * Handle the login POST request.
     */
    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.login')->withErrors($validator);
        }

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
        return view('auth.register'); // Make sure this view exists
    }

    /**
    * Handle the registration POST request.
    */
    public function postRegister(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'nullable|string|max:15', // Example of additional field
            'address' => 'nullable|string|max:255', // Example of additional field
        ]);

        // Create the user using the validated data
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone', null), // Optional field for phone number
            'address' => $request->input('address', null), // Optional field for address
            'is_admin' => false, // Default role is not admin, or based on your logic
        ]);

        // Log the user in after registration
        Auth::login($user);

        // Regenerate the session after logging in
        $request->session()->regenerate();

        // Redirect the user to the dashboard after registration
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

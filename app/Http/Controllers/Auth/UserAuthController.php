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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false, // Default role is not admin
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard'); // Redirect to user dashboard after registration
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

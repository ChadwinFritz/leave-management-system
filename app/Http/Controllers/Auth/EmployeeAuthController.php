<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee; // Ensure you have an Employee model set up

class EmployeeAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('employees.index'); // Create this view for the login form
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|email',
            'password' => 'required',
        ]);

        // Fetch employee details
        $employee = Employee::where('EmailId', $request->username)
            ->where('Password', md5($request->password))
            ->first();

        if ($employee) {
            if ($employee->Status == 0) {
                return back()->withErrors(['msg' => 'In-Active Account. Please contact your administrator!']);
            } else {
                // Set the session variables
                session(['eid' => $employee->id]);
                session(['emplogin' => $request->username]);

                return redirect()->route('employee.leave'); // Adjust this route as needed
            }
        } else {
            return back()->withErrors(['msg' => 'Sorry, Invalid Details.']);
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->flush(); // Clear all session data
        return redirect('/'); // Redirect to home or login page
    }
}

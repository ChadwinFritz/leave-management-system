<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator; // Ensure Validator is imported
use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType; // Ensure LeaveType model is imported

class EmployeeController extends Controller
{
    // Show the change password form
    public function showChangePasswordForm()
    {
        return view('employee.change-password'); // Adjust the view path as necessary
    }

    // Handle the change password request
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('employee.dashboard')->with('success', 'Password changed successfully.');
    }

    // Method to show the leave history
    public function showLeaveHistory()
    {
        // Check if the user is logged in
        if (Auth::check()) {
            $user = Auth::user();
            $employeeId = $user->employee_id; // Assuming employee_id is stored in the users table

            // Fetch leave history from the database
            $leaves = Leave::where('employee_id', $employeeId)->get();

            return view('employee.leave-history', compact('leaves')); // Pass the leaves to the view
        } else {
            return redirect('login')->with('error', 'You must be logged in to view your leave history.');
        }
    }

    // Display the leave application form
    public function showLeaveForm()
    {
        // Get leave types for the dropdown (You might need to create LeaveType model)
        $leaveTypes = LeaveType::all();
        return view('employee.leave_form', compact('leaveTypes'));
    }

    // Handle the leave application submission
    public function applyLeave(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'fromdate' => 'required|date|before_or_equal:todate',
            'todate' => 'required|date|after_or_equal:fromdate',
            'leavetype' => 'required|string',
            'description' => 'nullable|string|max:400',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get the authenticated employee ID
        $empid = Auth::id();

        // Create a new leave application
        Leave::create([
            'LeaveType' => $request->input('leavetype'),
            'FromDate' => $request->input('fromdate'),
            'ToDate' => $request->input('todate'),
            'Description' => $request->input('description'),
            'Status' => 0, // Default status (0 for pending)
            'IsRead' => 0, // Default read status
            'empid' => $empid,
        ]);

        // Redirect back with success message
        return redirect()->back()->with('msg', 'Your leave application has been applied, Thank You.');
    }

    // Handle employee logout
    public function logout(Request $request)
    {
        // Log out the user
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token to prevent CSRF attacks
        $request->session()->regenerateToken();

        // Redirect to the login page
        return redirect()->route('login')->with('status', 'You have been logged out successfully.');
    }

    // Show employee profile
    public function showProfile()
    {
        // Check if user is logged in
        if (Auth::check()) {
            $eid = Auth::user()->email; // Assuming email is used as the unique identifier
            $employee = DB::table('tblemployees')->where('EmailId', $eid)->first();

            return view('employee.profile', compact('employee'));
        }

        // Redirect to login if not authenticated
        return redirect()->route('login');
    }

    // Update employee profile
    public function updateProfile(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'dob' => 'required|date',
            'department' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'mobileno' => 'required|string|max:10',
        ]);

        // Get employee email from session
        $eid = Auth::user()->email; // Assuming email is used as the unique identifier

        // Update employee data
        DB::table('tblemployees')->where('EmailId', $eid)->update([
            'FirstName' => $request->firstName,
            'LastName' => $request->lastName,
            'Gender' => $request->gender,
            'Dob' => $request->dob,
            'Department' => $request->department,
            'Address' => $request->address,
            'City' => $request->city,
            'Country' => $request->country,
            'Phonenumber' => $request->mobileno,
        ]);

        return redirect()->back()->with('msg', 'Your record has been updated successfully.');
    }
}

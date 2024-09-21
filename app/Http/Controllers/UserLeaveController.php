<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserLeaveController extends Controller
{
    // Display the leave request page
    public function getLeaveReq()
    {
        if (Auth::check() && Auth::user()->role === 'user') {
            return view('user.leave_request'); // Updated view name
        }

        return Redirect::route('user_login'); // Ensure redirection to user login route
    }

    // Handle leave request post
    public function postLeaveReq(Request $request)
    {
        if (Auth::check() && Auth::user()->role === 'user') {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'start_date' => 'required|date_format:d-m-Y',
                'end_date' => 'required|date_format:d-m-Y|after_or_equal:start_date',
                'start_half' => 'nullable|integer|in:0,1',
                'end_half' => 'nullable|integer|in:0,1',
                'reason' => 'required', // Ensure reason is required
                'leave_type' => 'required',
                'contact_number' => 'required', // Ensure this matches the input name
            ]);

            if ($validator->fails()) {
                return view('user.leave_request')->withErrors($validator);
            }

            // Convert date format for saving
            $data = $request->all();
            $startDate = \DateTime::createFromFormat('d-m-Y', $data['start_date']);
            $endDate = \DateTime::createFromFormat('d-m-Y', $data['end_date']);
            
            // Calculate number of days
            $days = $startDate->diff($endDate)->days + 1; // Add 1 to include the start day
            if (isset($data['start_half']) && $data['start_half'] == 1) $days -= 0.5; // Adjust for half days
            if (isset($data['end_half']) && $data['end_half'] == 1) $days -= 0.5;

            // Create the leave application
            $leaveApplication = new LeaveApplication();
            $leaveApplication->employee_id = Auth::id();
            $leaveApplication->name = $data['name'];
            $leaveApplication->username = Auth::user()->username; // Set username from the authenticated user
            $leaveApplication->start_date = $startDate->format('Y-m-d'); // Format for saving
            $leaveApplication->end_date = $endDate->format('Y-m-d'); // Format for saving
            $leaveApplication->start_half = $data['start_half'] ?? 0;
            $leaveApplication->end_half = $data['end_half'] ?? 0;
            $leaveApplication->reason = $data['reason']; // Set reason
            $leaveApplication->leave_type = $data['leave_type'];
            $leaveApplication->number_of_days = $days; // Set the calculated number of days
            $leaveApplication->status = 'pending'; // Default status for new requests
            $leaveApplication->on_date = now()->format('d/m/Y');
            $leaveApplication->on_time = now()->format('H:i');

            $leaveApplication->save();

            return view('user.leave_request')->with('success', 'Your application was successfully submitted!');
        }

        return Redirect::route('user_login');
    }

    // Handle leave request submission
    public function submitLeaveRequest(Request $request)
    {
        // Ensure the user is authenticated and has the user role
        if (Auth::check() && Auth::user()->role === 'user') {

            // Validate the leave request input
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'leave_type' => 'required|exists:leave_types,id', // Ensure leave_type exists in leave_types table
                'reason' => 'required', // Ensure reason is validated
            ]);

            // Calculate the number of days for leave
            $startDate = \Carbon\Carbon::parse($request->input('start_date'));
            $endDate = \Carbon\Carbon::parse($request->input('end_date'));
            $numberOfDays = $startDate->diffInDays($endDate) + 1;

            // Create a new leave application record
            LeaveApplication::create([
                'employee_id' => Auth::id(), // The logged-in user ID
                'leave_type' => $request->input('leave_type'),
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'status' => 'pending', // Default status
                'number_of_days' => $numberOfDays, // Set calculated days
                'reason' => $request->input('reason'), // Include reason in the record
            ]);

            // Redirect back with success message
            return redirect()->back()->with('success', 'Leave request submitted successfully!');
        }

        // If the user is not authenticated, redirect to the login page
        return redirect()->route('user.login');
    }

    // Get the leave count for a specific leave type
    public static function getEachLeaveCount($userId)
    {
        $leaveCounts = [];
        $leaveTypes = DB::table('leave_types')->get();

        foreach ($leaveTypes as $leaveType) {
            $totalDaysYear = 0;
            $actualLeaveDates = [];

            $userLeaves = LeaveApplication::where('employee_id', $userId)
                ->where('leave_type', $leaveType->id)
                ->get();

            foreach ($userLeaves as $leave) {
                $startDate = new \DateTime($leave->start_date);
                $endDate = new \DateTime($leave->end_date);
                $endDate->modify('+1 day');
                $dateRange = new \DatePeriod($startDate, new \DateInterval('P1D'), $endDate);

                foreach ($dateRange as $date) {
                    $actualLeaveDates[] = $date->format('d/m/Y');
                    $totalDaysYear++;
                }
            }

            $leaveCounts[$leaveType->id] = [
                'totalDaysYear' => $totalDaysYear,
                'leaveDates' => $actualLeaveDates,
            ];
        }

        return $leaveCounts;
    }

    /**
     * Show the leave request form.
     *
     * @return \Illuminate\View\View
     */
    public function showLeaveRequestForm()
    {
        return view('user.leave_request'); // Ensure this view exists
    }
}

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
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'start_half' => 'nullable|integer|in:0,1',
                'end_half' => 'nullable|integer|in:0,1',
                'reason' => 'required',
                'leave_type' => 'required',
                'mobno' => 'required',
            ]);

            if ($validator->fails()) {
                return view('user.leave_request')->withErrors($validator); // Updated view name
            }

            $data = $request->all();
            $startDate = new \DateTime($data['start_date']);
            $endDate = new \DateTime($data['end_date']);
            $days = $startDate->diff($endDate)->days + 1;

            if (isset($data['start_half']) && $data['start_half'] == 1) $days -= 0.5;
            if (isset($data['end_half']) && $data['end_half'] == 1) $days -= 0.5;

            $leaveApplication = new LeaveApplication();
            $leaveApplication->employee_id = Auth::id();
            $leaveApplication->name = $data['name'];
            $leaveApplication->start_date = $data['start_date'];
            $leaveApplication->end_date = $data['end_date'];
            $leaveApplication->start_half = $data['start_half'] ?? 0;
            $leaveApplication->end_half = $data['end_half'] ?? 0;
            $leaveApplication->reason = $data['reason'];
            $leaveApplication->leave_type = $data['leave_type'];
            $leaveApplication->number_of_days = $days;
            $leaveApplication->status = 0; // Default status for new requests
            $leaveApplication->on_date = now()->format('dd/mm/YYYY');
            $leaveApplication->on_time = now()->format('dd/mm/yyyy');

            $leaveApplication->save();

            return view('user.leave_request') // Updated view name
                ->with('success', 'Your application was successfully submitted!');
        }

        return Redirect::route('user_login'); // Ensure redirection to user login route
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
            ]);

            // Create a new leave application record
            LeaveApplication::create([
                'employee_id' => Auth::id(), // The logged-in user ID
                'leave_type' => $request->input('leave_type'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'status' => 'pending', // Default status
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
                    $actualLeaveDates[] = $date->format('dd/mm/YYYY');
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

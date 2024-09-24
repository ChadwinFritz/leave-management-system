<?php 

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminLeaveController extends Controller
{
    /**
     * Show the list of leave requests.
     */
    public function showLeaveRequests()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Fetch leave requests from the LeaveApplication model
            $leaveRequests = LeaveApplication::with('employee')->get(); // Use eager loading to fetch employee data
            return view('admin.list_leave_requests', compact('leaveRequests'));
        } else {
            return redirect()->route('admin.login');
        }
    }

    /**
     * Handle leave request actions (approve/reject).
     */
    public function handleLeaveAction(Request $request)
    {
        $request->validate([
            'rejreason' => 'nullable|string|max:255',
            'id' => 'required|exists:leave_applications,id',
            'act' => 'required|in:1,2', // 1 for approve, 2 for reject
        ]);

        $leave = LeaveApplication::find($request->input('id'));

        if ($leave) {
            if ($request->input('act') == 1) {
                // Approve leave
                $leave->status = 'approved';
            } elseif ($request->input('act') == 2) {
                // Reject leave
                $leave->status = 'rejected';
                $leave->rejection_reason = $request->input('rejreason');
            }
            $leave->save();
        }

        return redirect()->route('admin.leave_requests')->with('success', 'Leave action processed successfully.');
    }

    /**
     * Display employee leave details within a specific date range.
     */
    public function showEmployeeLeaveDetails(Request $request)
    {
        $request->validate([
            'upper_date' => 'required|date',
            'lower_date' => 'required|date|after_or_equal:upper_date',
            'id' => 'required|exists:users,id', // Assuming 'users' table holds employee IDs
        ]);

        $startDate = $request->input('upper_date');
        $endDate = $request->input('lower_date');
        $employeeId = $request->input('id');

        $userLeaves = LeaveApplication::where('employee_id', $employeeId)
            ->whereBetween('start_date', [$startDate, $endDate])
            ->orWhereBetween('end_date', [$startDate, $endDate])
            ->get();

        $totalDays = 0;
        $actualLeaveDates = [];

        foreach ($userLeaves as $userLeave) {
            $leaveStartDate = new \DateTime($userLeave->start_date);
            $leaveEndDate = new \DateTime($userLeave->end_date);
            $leaveEndDate->modify('+1 day'); // Include end date in the period
            $dateRange = new \DatePeriod($leaveStartDate, new \DateInterval('P1D'), $leaveEndDate);

            foreach ($dateRange as $date) {
                $totalDays++;
                $actualLeaveDates[] = $date->format('Y-m-d');
            }
        }

        return view('admin.view_leave', [
            'leaveDetails' => $actualLeaveDates,
            'totalDays' => $totalDays
        ]);
    }

    /**
     * Calculate the total leave days for a user.
     *
     * @param int $userId
     * @return int
     */
    public static function calculateTotalLeave($userId)
    {
        return LeaveApplication::where('employee_id', $userId)
            ->sum('number_of_days'); // Assuming 'number_of_days' column exists
    }

    /**
     * Show the list of leave requests.
     */
    public function listLeaveRequests()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Fetch all leave requests
            $leaveRequests = LeaveApplication::with('employee')->get(); // Eager load employee data
            return view('admin.list_leave_request', ['leaveRequests' => $leaveRequests]);
        } else {
            return redirect()->route('admin.login');
        }
    }

    /**
     * Update the leave request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  string  $action
     * @return \Illuminate\Http\Response
     */
    public function updateLeave(Request $request, $id, $action)
    {
        $leave = LeaveApplication::find($id);

        if (!$leave) {
            return redirect()->route('admin.leave.requests')
                             ->with('error', 'Leave request not found');
        }

        // Perform the action (e.g., reject the leave request)
        if ($action === 'reject') {
            $leave->status = 'rejected';
        } elseif ($action === 'approve') {
            $leave->status = 'approved';
        }

        $leave->save();

        return redirect()->route('admin.leave.requests')
                         ->with('success', 'Leave request updated successfully');
    }
}

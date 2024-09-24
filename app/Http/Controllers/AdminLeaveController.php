<?php 

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLeaveController extends Controller
{
    /**
     * Show the list of leave requests.
     */
    public function showLeaveRequests()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            // Fetch leave requests from LeaveApplication model
            $leaveRequests = LeaveApplication::all();
            return view('admin.list_leave_requests', compact('leaveRequests'));
        }

        return redirect()->route('admin.login');
    }

    /**
     * Handle leave request actions (approve/reject).
     */
    public function handleLeaveAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:leave_applications,id',
            'act' => 'required|in:1,2', // 1: approve, 2: reject
            'rejreason' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.leave_requests')
                             ->withErrors($validator)
                             ->withInput();
        }

        $applicationId = $request->input('id');
        $action = $request->input('act');

        $leave = LeaveApplication::find($applicationId);
        if ($leave) {
            if ($action == 1) {
                // Approve leave
                $leave->status = 'approved';
            } elseif ($action == 2) {
                // Reject leave
                $leave->status = 'rejected';
                $leave->rejection_reason = $request->input('rejreason');
            }
            $leave->save();
            return redirect()->route('admin.leave_requests')->with('success', 'Leave action processed successfully.');
        }

        return redirect()->route('admin.leave_requests')->with('error', 'Leave request not found.');
    }

    /**
     * Display employee leave details within a specific date range.
     */
    public function showEmployeeLeaveDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upper_date' => 'required|date',
            'lower_date' => 'required|date|after_or_equal:upper_date',
            'id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.leave_requests')
                             ->withErrors($validator);
        }

        $startDate = $request->input('upper_date');
        $endDate = $request->input('lower_date');
        $employeeId = $request->input('id');

        $totalDays = 0;
        $actualLeaveDates = [];
        $userLeaves = LeaveApplication::where('employee_id', $employeeId)->get();

        foreach ($userLeaves as $userLeave) {
            $leaveStartDate = new \DateTime($userLeave->start_date);
            $leaveEndDate = new \DateTime($userLeave->end_date);
            $leaveEndDate->modify('+1 day');

            $dateRange = new \DatePeriod($leaveStartDate, new \DateInterval('P1D'), $leaveEndDate);
            foreach ($dateRange as $leaveDate) {
                if ($leaveDate >= new \DateTime($startDate) && $leaveDate <= new \DateTime($endDate)) {
                    $totalDays++;
                    $actualLeaveDates[] = $leaveDate->format('Y-m-d');
                }
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
        return LeaveApplication::where('employee_id', $userId)->sum('number_of_days');
    }
}

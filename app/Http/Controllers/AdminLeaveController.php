<?php 

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class AdminLeaveController extends Controller
{
    /**
     * Show the list of leave requests.
     */
    public function showLeaveRequests()
    {
        // Fetch leave requests from the Leave model
        $leaveRequests = Leave::all(); // Assuming Leave model stores leave applications
        return view('admin.list_leave_requests', compact('leaveRequests'));
    }

    /**
     * Handle leave request actions (approve/reject).
     */
    public function handleLeaveAction(Request $request)
    {
        $rejectionReason = $request->input('rejreason');
        $applicationId = $request->input('id');
        $action = $request->input('act');

        if ($applicationId && $action) {
            $leave = Leave::where('application_id', $applicationId)->first();

            if ($leave) {
                if ($action == 1) {
                    // Approve leave
                    $leave->status = 1;
                    $leave->save();
                    DB::table('leaveapply')->where('id', $applicationId)
                        ->update(['status' => 1, 'rejreason' => ""]);
                } elseif ($action == 2) {
                    // Reject leave
                    $leave->status = 2; // Update status to rejected instead of deleting
                    $leave->rejection_reason = $rejectionReason; // Save rejection reason
                    $leave->save();
                    DB::table('leaveapply')->where('id', $applicationId)
                        ->update(['status' => 2, 'rejreason' => $rejectionReason]);
                }
            }
        }

        return redirect()->route('admin.leave_requests')->with('success', 'Leave action processed successfully.');
    }

    /**
     * Display employee leave details within a specific date range.
     */
    public function showEmployeeLeaveDetails(Request $request)
    {
        $startDate = $request->input('upper_date');
        $endDate = $request->input('lower_date');
        $employeeId = $request->input('id');

        if ($startDate && $endDate && $employeeId) {
            $totalDays = 0;
            $actualLeaveDates = [];
            $userLeaves = Leave::where('user_id', $employeeId)->get(); // Changed 'empid' to 'user_id'
            $upperDate = new \DateTime($startDate);
            $lowerDate = new \DateTime($endDate);
            $lowerDate->modify('+1 day');
            $datePeriod = new \DatePeriod($upperDate, new \DateInterval('P1D'), $lowerDate);

            foreach ($userLeaves as $userLeave) {
                $leaveStartDate = new \DateTime($userLeave->startdate);
                $leaveEndDate = new \DateTime($userLeave->enddate);
                $leaveEndDate->modify('+1 day');
                $leavePeriod = new \DatePeriod($leaveStartDate, new \DateInterval('P1D'), $leaveEndDate);

                foreach ($datePeriod as $date) {
                    foreach ($leavePeriod as $leaveDate) {
                        if ($date->format('Y-m-d') == $leaveDate->format('Y-m-d')) {
                            $totalDays++;
                            $actualLeaveDates[] = $date->format('Y-m-d');
                        }
                    }
                }
            }

            $viewData = [
                'leaveDetails' => $actualLeaveDates,
                'totalDays' => $totalDays
            ];

            return view('admin.view_leave', $viewData);
        }

        // Handle cases where required data is missing
        return redirect()->route('admin.leave_requests')->withErrors('Invalid data provided.');
    }

    /**
     * Calculate the total leave days for a user.
     *
     * @param int $userId
     * @return int
     */
    public static function calculateTotalLeave($userId)
    {
        // Calculate total leave days for the user from the Leave model
        return Leave::where('user_id', $userId)->sum('days'); // Assuming 'days' is the number of leave days
    }

    /**
     * Show the list of leave requests.
     */
    public function listLeaveRequests()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            // Fetch all leave requests
            $leaveRequests = LeaveApplication::all();  // Adjust the query as needed

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
        } else {
            // Handle other actions if needed
        }

        $leave->save();

        return redirect()->route('admin.leave.requests')
                         ->with('success', 'Leave request updated successfully');
    }
}

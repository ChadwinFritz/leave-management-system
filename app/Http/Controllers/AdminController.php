<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LeaveApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Show the form for adding a new employee.
     */
    public function showAddEmployeeForm()
    {
        $this->authorizeAdmin();
        return view('admin.add_employee');
    }

    /**
     * Handle the request to add a new employee.
     */
    public function addEmployee(Request $request)
    {
        $this->validateEmployeeRequest($request);

        $user = new User();
        $this->fillUserData($user, $request);

        $user->save();
        return redirect()->route('user.login')->with('success', 'Employee successfully saved');
    }

    /**
     * Delete an employee.
     */
    public function deleteEmployee($id)
    {
        if ($id) {
            User::destroy($id);
        }
        return redirect()->route('admin.dashboard')->with('success', 'Employee deleted successfully.');
    }

    /**
     * Show the profile view for an employee.
     */
    public function showEmployeeProfile($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('admin.dashboard')->with('error', 'Employee not found.');
        }

        $leaveInfo = \App\Models\Leave::where('empid', $user->id)->first();
        $totalLeave = $leaveInfo ? $leaveInfo->totalleave : 0;

        return view('admin.employee_details', [
            'user' => $user,
            'totalLeave' => $totalLeave,
        ]);
    }

    /**
     * Show the form for editing an employee.
     */
    public function showEditEmployeeForm($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_employee', ['employee' => $user]);
    }

    /**
     * Handle the request to update an employee.
     */
    public function updateEmployee(Request $request, $id)
    {
        $this->validateEmployeeRequest($request, $id);

        $user = User::findOrFail($id);
        $this->fillUserData($user, $request);

        $user->save();
        return redirect()->route('admin.dashboard')->with('success', 'Employee updated successfully');
    }

    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $this->authorizeAdmin();
        $users = User::all();
        return view('admin.admin_dashboard', ['users' => $users]);
    }

    /**
     * Show the list of employees.
     */
    public function listEmployees()
    {
        $this->authorizeAdmin();
        $users = User::all();
        return view('admin.admin_dashboard', ['users' => $users]);
    }

    // Get the leave count for a specific leave type for an employee
    public function getEachLeaveCount($userId)
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
                    $actualLeaveDates[] = $date->format('Y-m-d');
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
     * Authorize admin access.
     */
    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('admin.login');
        }
    }

    /**
     * Validate employee request.
     */
    private function validateEmployeeRequest(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username' . ($id ? ",$id" : ''),
            'email' => 'required|email|unique:users,email' . ($id ? ",$id" : ''),
            'password' => 'nullable|string|min:8',
            'admincheck' => 'nullable|boolean',
            'proimg' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
    }

    /**
     * Fill user data from the request.
     */
    private function fillUserData(User $user, Request $request)
    {
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->role = $request->input('admincheck') ? 'admin' : 'user';

        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('proimg')) {
            $imageFile = $request->file('proimg');
            $filename = time() . '-profile_photo.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('profileimg'), $filename);
            $user->image = $filename;
        }
    }

    /**
     * Calculate the total leave for a given user ID.
     *
     * @param int $userId
     * @return int
     */
    public static function calculateTotalLeave($userId)
    {
        if (!$userId) {
            return 0;
        }

        $totalLeave = LeaveApplication::where('employee_id', $userId)
            ->whereYear('start_date', date('Y'))
            ->sum('number_of_days');

        return $totalLeave;
    }
}

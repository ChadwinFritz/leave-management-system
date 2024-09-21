<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LeaveApplication; // Ensure this model is imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // Ensure DB is imported

class AdminController extends Controller
{
    /**
     * Show the form for adding a new employee.
     */
    public function showAddEmployeeForm()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('admin.add_employee'); // Ensure this view exists
        } else {
            return redirect()->route('admin.login');
        }
    }

    /**
     * Handle the request to add a new employee.
     */
    public function addEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8',
            'email' => 'required|email|unique:users,email',
            'admincheck' => 'nullable|boolean',
            'proimg' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.employees.add')
                             ->withErrors($validator)
                             ->withInput();
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->email = $request->input('email');
        $user->role = $request->input('admincheck') ? 'admin' : 'user';

        if ($request->hasFile('proimg')) {
            $imageFile = $request->file('proimg');
            $filename = time() . '-profile_photo.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('profileimg'), $filename);
            $user->image = $filename;
        }

        $user->save();
        return redirect()->route('admin.employees.add')->with('success', 'Employee successfully saved');
    }

    /**
     * Delete an employee.
     */
    public function deleteEmployee($id)
    {
        if ($id) {
            User::destroy($id);
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Show the profile view for an employee.
     */
    public function showEmployeeProfile($id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            // Redirect to an appropriate page, e.g., back to the employee list, with an error message
            return redirect()->route('admin.dashboard')->with('error', 'Employee not found.');
        }

        // Get leave information for the user
        $leaveInfo = \App\Models\Leave::where('empid', $user->id)->first();
        $totalLeave = $leaveInfo ? $leaveInfo->totalleave : 0;

        // Return the view with user and leave details
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
        // Find the user by ID
        $user = User::findOrFail($id);

        // Return the view with user data
        return view('admin.edit_employee', ['employee' => $user]); // Ensure variable name matches the view
    }

    /**
     * Handle the request to update an employee.
     */
    public function updateEmployee(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'admincheck' => 'nullable|boolean',
            'proimg' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.employees.edit', ['id' => $id])
                             ->withErrors($validator)
                             ->withInput();
        }

        $user = User::find($id);

        // Check if a new profile image is uploaded
        if ($request->hasFile('proimg')) {
            $imageFile = $request->file('proimg');
            $filename = time() . '-profile_photo.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('profileimg'), $filename);
            $user->image = $filename;
        }

        // Update user information
        $user->name = $request->input('name');
        $user->designation = $request->input('designation');
        $user->duty = $request->input('duty');
        $user->note = $request->input('note');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->role = $request->input('admincheck') ? 'admin' : 'user';

        // If the password is changed, hash and update it
        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();
        return redirect()->route('admin.employees.details', ['id' => $id])
                         ->with('success', 'Employee updated successfully');
    }

    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Fetch all users to be displayed in the dashboard
            $users = User::all();

            return view('admin.admin_dashboard', ['users' => $users]);
        } else {
            return redirect()->route('admin.login');
        }
    }

    /**
     * Show the list of employees.
     */
    public function listEmployees()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Fetch all users to be displayed
            $users = User::all();

            return view('admin.admin_dashboard', ['users' => $users]);
        } else {
            return redirect()->route('admin.login');
        }
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
     * Show the form for editing an employee and handle updates.
     */
    public function editEmployee(Request $request, $id = null)
    {
        if ($request->isMethod('get')) {
            // Show the edit form
            $user = User::findOrFail($id);
            return view('admin.edit_employee', ['employee' => $user]);
        } elseif ($request->isMethod('post')) {
            // Handle the form submission to update an employee
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'username' => 'required|string|unique:users,username,' . $id,
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|string|min:8',
                'admincheck' => 'nullable|boolean',
                'proimg' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->route('admin.employees.edit', ['id' => $id])
                                 ->withErrors($validator)
                                 ->withInput();
            }

            $user = User::findOrFail($id);

            // Check if a new profile image is uploaded
            if ($request->hasFile('proimg')) {
                $imageFile = $request->file('proimg');
                $filename = time() . '-profile_photo.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('profileimg'), $filename);
                $user->image = $filename;
            }

            // Update user information
            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->role = $request->input('admincheck') ? 'admin' : 'user';

            // If the password is changed, hash and update it
            if ($request->input('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->save();
            return redirect()->route('admin.employees.details', ['id' => $id])
                             ->with('success', 'Employee updated successfully');
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
        // Ensure the user ID is valid
        if (!$userId) {
            return 0;
        }

        // Fetch leave applications for the user for the current year
        $totalLeave = LeaveApplication::where('employee_id', $userId)
            ->whereYear('start_date', date('Y')) // Filter by the current year
            ->sum('number_of_days'); // Assuming 'number_of_days' column exists in LeaveApplication

        return $totalLeave;
    }
}

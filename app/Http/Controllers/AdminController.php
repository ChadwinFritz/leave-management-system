<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    // Middleware to restrict access unless logged in
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // Show form to add a new admin
    public function create()
    {
        return view('admin.create-admin'); // Return a view to create a new admin
    }

    // Handle form submission for adding a new admin
    public function storeAdmin(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin,email',
            'username' => 'required|string|max:255|unique:admin,UserName',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Create a new admin record
            $admin = new Admin();
            $admin->fullname = $request->fullname;
            $admin->email = $request->email;
            $admin->UserName = $request->username;
            $admin->Password = Hash::make($request->password); // Hash the password

            // Save the new admin to the database
            if ($admin->save()) {
                // If successful, redirect with a success message
                return redirect()->back()->with('success', 'New admin has been added successfully.');
            } else {
                // Handle failure
                return redirect()->back()->with('error', 'Failed to add admin.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the department creation form
     */
    public function createDepartmentForm()
    {
        return view('admin.department.create');
    }

    /**
     * Handle the department creation request
     */
    public function createDepartment(Request $request)
    {
        // Validate the input data
        $request->validate([
            'departmentname' => 'required|string|max:255',
            'departmentshortname' => 'required|string|max:10',
            'deptcode' => 'required|string|max:10|unique:departments,DepartmentCode',
        ]);

        try {
            // Create a new department
            $department = new Department();
            $department->DepartmentName = $request->input('departmentname');
            $department->DepartmentShortName = $request->input('departmentshortname');
            $department->DepartmentCode = $request->input('deptcode');
            $department->save();

            // Redirect with success message
            return redirect()->route('admin.department.create')
                             ->with('success', 'Department Created Successfully');
        } catch (\Exception $e) {
            // Redirect with error message
            return redirect()->back()
                             ->with('error', 'Something went wrong. Please try again.');
        }
    }

    // Display the form to add a new employee
    public function showAddEmployeeForm()
    {
        $departments = \DB::table('departments')->pluck('name', 'id'); // Assuming you have a 'departments' table
        return view('admin.add-employee', compact('departments'));
    }

    // Add new employee
    public function storeEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'empcode' => 'required|unique:employees,emp_id',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|min:6|confirmed',
            'gender' => 'required',
            'dob' => 'required|date',
            'department' => 'required',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'mobileno' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Create employee record
            $employee = new Employee();
            $employee->emp_id = $request->empcode;
            $employee->first_name = $request->firstName;
            $employee->last_name = $request->lastName;
            $employee->email = $request->email;
            $employee->password = Hash::make($request->password); // Encrypt password
            $employee->gender = $request->gender;
            $employee->dob = $request->dob;
            $employee->department = $request->department;
            $employee->address = $request->address;
            $employee->city = $request->city;
            $employee->country = $request->country;
            $employee->phone_number = $request->mobileno;
            $employee->status = 1; // Active status

            $employee->save();

            return redirect()->back()->with('msg', 'Record has been added Successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error adding employee: ' . $e->getMessage());
        }
    }

    // Display the form for adding a new leave type
    public function showAddLeaveTypeForm()
    {
        return view('admin.add-leave-type'); // Refers to the add leave type view
    }

    // Handle the form submission to add a new leave type
    public function storeLeaveType(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'leavetype' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        try {
            // Create new leave type
            $leaveType = new LeaveType();
            $leaveType->LeaveType = $request->leavetype;
            $leaveType->Description = $request->description;
            $leaveType->save();

            // If successful, redirect with a success message
            return redirect()->back()->with('success', 'Leave type added successfully');
        } catch (\Exception $e) {
            // If there's an error, redirect back with an error message
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    // Admin dashboard view with approved leaves
    public function index()
    {
        // Fetch only approved leaves (status = 1)
        $status = 1;
        $approvedLeaves = Leave::with('employee')
            ->where('status', $status)
            ->orderBy('id', 'desc')
            ->get();

        // Return the view with data
        return view('admin.dashboard', compact('approvedLeaves'));
    }

    // Consolidated showLeaveDetails method
    public function showLeaveDetails($leaveId)
    {
        // Check if the admin is authenticated
        if (Session::has('alogin')) {
            // Fetch leave details
            $leave = Leave::with('employee') // Assuming you have a relation in your Leave model
                ->where('id', $leaveId)
                ->firstOrFail();

            return view('admin.leave-details', compact('leave')); // Replace with your actual view path
        } else {
            return redirect('index'); // Redirect if not logged in
        }
    }

    // Admin logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    // Show the dashboard with a list of declined leaves
    public function showDeclinedLeaves()
    {
        // Check if the admin is logged in (handled by middleware)
        // Fetch the list of declined leaves
        $status = 2; // 2 represents declined status
        $declinedLeaves = Leave::join('employees', 'leaves.employee_id', '=', 'employees.id')
            ->select('leaves.id as leave_id', 'employees.first_name', 'employees.last_name', 'employees.emp_id', 'leaves.leave_type', 'leaves.posting_date', 'leaves.status')
            ->where('leaves.status', $status)
            ->orderBy('leaves.id', 'desc')
            ->get();

        // Return the view with declined leaves
        return view('admin.declined_leaves', compact('declinedLeaves'));
    }

    // Show the department management page
    public function departmentManagement()
    {
        $departments = Department::all();
        return view('admin.department-management', compact('departments'));
    }

    // Delete a department
    public function deleteDepartment($id)
    {
        try {
            $department = Department::findOrFail($id);
            $department->delete();

            Session::flash('success', 'The selected department has been deleted.');
        } catch (\Exception $e) {
            Session::flash('error', 'Error deleting department: ' . $e->getMessage());
        }

        return redirect()->route('admin.departments');
    }

    // Render the add department page
    public function showAddDepartmentForm()
    {
        return view('admin.add-department');
    }

    // Add a new department
    public function storeDepartment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:10',
            'code' => 'required|string|max:10|unique:departments,code',
        ]);

        Department::create([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'code' => $request->code,
            'created_at' => now(),
        ]);

        return redirect()->route('admin.departments')->with('success', 'Department added successfully.');
    }

    public function updateDepartmentForm($deptid)
    {
        $department = Department::findOrFail($deptid); // Retrieve the department by ID
        return view('admin.update_department', compact('department')); // Pass the department data to the view
    }

    public function updateDepartment(Request $request, $deptid)
    {
        // Validate the incoming request
        $request->validate([
            'departmentname' => 'required|string|max:255',
            'departmentshortname' => 'required|string|max:10',
            'deptcode' => 'required|string|max:10',
        ]);

        // Retrieve the department and update it
        $department = Department::findOrFail($deptid);
        $department->DepartmentName = $request->departmentname;
        $department->DepartmentShortName = $request->departmentshortname;
        $department->DepartmentCode = $request->deptcode;
        $department->save(); // Save the updated department

        Session::flash('msg', 'Department updated successfully'); // Flash success message
        return redirect()->route('departments'); // Redirect to the department listing page
    }

    public function editLeaveType($id)
    {
        // Check if the admin is logged in
        if (Auth::check() && Auth::user()->isAdmin()) {
            $leaveType = LeaveType::findOrFail($id); // Fetch leave type by ID
            return view('admin.edit-leave-type', compact('leaveType')); // Return view with leave type data
        } else {
            return redirect()->route('login'); // Redirect to login if not authenticated
        }
    }

    public function updateLeave(Request $request, $leaveId)
    {
        // Validate request
        $request->validate([
            'status' => 'required|in:1,2', // Assuming 1 for approved, 2 for declined
            'description' => 'required|string|max:500',
        ]);

        // Update leave status and remarks
        $leave = Leave::findOrFail($leaveId);
        $leave->AdminRemark = $request->description;
        $leave->Status = $request->status;
        $leave->AdminRemarkDate = now();
        $leave->IsRead = 1; // Mark as read
        $leave->save();

        return redirect()->back()->with('msg', 'Leave updated successfully'); // Flash message for success
    }

    public function employeeIndex()
    {
        // Fetch all employees
        $employees = Employee::all();
        return view('admin.employees.index', compact('employees'));
    }

    public function activate($id)
    {
        // Activate employee
        $employee = Employee::findOrFail($id);
        $employee->status = 1; // 1 for active
        $employee->save();

        return redirect()->route('admin.employees.index')->with('msg', 'Employee activated successfully!');
    }

    public function deactivate($id)
    {
        // Deactivate employee
        $employee = Employee::findOrFail($id);
        $employee->status = 0; // 0 for inactive
        $employee->save();

        return redirect()->route('admin.employees.index')->with('msg', 'Employee deactivated successfully!');
    }

    // Display the leave history
    public function leaveHistory()
    {
        // Fetching leave data from the database
        $leaves = Leave::join('employees', 'leaves.employee_id', '=', 'employees.id')
            ->select('leaves.id as lid', 'employees.FirstName', 'employees.LastName', 'employees.EmpId', 'leaves.LeaveType', 'leaves.PostingDate', 'leaves.Status')
            ->orderBy('lid', 'desc')
            ->get();

        // Returning the view with the leave data
        return view('admin.leave_history', [
            'leaves' => $leaves
        ]);
    }

    // Handle any messages or errors
    protected function handleMessages($msg = null, $error = null)
    {
        if ($error) {
            return redirect()->back()->with('error', $error);
        } elseif ($msg) {
            return redirect()->back()->with('msg', $msg);
        }
    }

    public function leaveIndex()
    {
        $leaveTypes = LeaveType::all(); // Retrieve all leave types
        return view('admin.leave.index', compact('leaveTypes')); // Return view with leave types
    }

    public function destroy($id)
    {
        $leaveType = LeaveType::find($id);
        
        if ($leaveType) {
            $leaveType->delete();
            return redirect()->route('admin.leave.index')->with('success', 'Leave type record deleted');
        }

        return redirect()->route('admin.leave.index')->with('error', 'Leave type not found');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'leave_type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create a new leave type
        LeaveType::create([
            'LeaveType' => $request->leave_type,
            'Description' => $request->description,
            'CreationDate' => now(), // Set current date as creation date
        ]);

        return redirect()->route('admin.leave.index')->with('success', 'Leave type created successfully');
    }

    public function edit($id)
    {
        $leaveType = LeaveType::find($id);
        if (!$leaveType) {
            return redirect()->route('admin.leave.index')->with('error', 'Leave type not found');
        }
        
        return view('admin.leave.edit', compact('leaveType')); // Return edit view with leave type
    }

    public function updateLeaveType(Request $request, $id)
    {
        $request->validate([
            'leave_type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $leaveType = LeaveType::find($id);
        if (!$leaveType) {
            return redirect()->route('admin.leave.index')->with('error', 'Leave type not found');
        }

        $leaveType->update([
            'LeaveType' => $request->leave_type,
            'Description' => $request->description,
        ]);

        return redirect()->route('admin.leave.index')->with('success', 'Leave type updated successfully');
    }

    public function manageAdmins()
    {
        // Fetch all admin accounts
        $admins = Admin::all(); // You can add pagination if needed

        return view('admin.manage-admin', compact('admins'));
    }

    public function delete($id)
    {
        // Check if the admin account exists
        $admin = Admin::find($id);
        if (!$admin) {
            return redirect()->back()->withErrors('Admin account not found.');
        }

        // Delete the admin account
        $admin->delete();

        return redirect()->route('admin.manage')->with('msg', 'The selected admin account has been deleted');
    }

    // Display the dashboard with pending leave applications
    public function dashboard()
    {
        // Get the required data using Eloquent models
        $leaveTypesCount = LeaveType::count();
        $employeesCount = Employee::where('status', 'active')->count();
        $departmentsCount = Department::count();

        // Leave application status counts
        $pendingApplicationsCount = Leave::where('status', 0)->count();
        $declinedApplicationsCount = Leave::where('status', 2)->count();
        $approvedApplicationsCount = Leave::where('status', 1)->count();

        // Fetch recent leave applications
        $recentLeaveApplications = Leave::with('employee')
            ->orderBy('id', 'desc')
            ->limit(7)
            ->get();

        // Return the view with the retrieved data
        return view('admin.dashboard', compact(
            'leaveTypesCount',
            'employeesCount',
            'departmentsCount',
            'pendingApplicationsCount',
            'declinedApplicationsCount',
            'approvedApplicationsCount',
            'recentLeaveApplications'
        ));
    }

    // Approve or decline a leave application
    public function updateLeaveStatus(Request $request, $leaveId)
    {
        $leave = Leave::findOrFail($leaveId);
        
        $leave->status = $request->input('status'); // Assume status is passed as 1 (approved) or 2 (declined)
        $leave->save();

        return redirect()->back()->with('success', 'Leave status updated successfully!');
    }

    public function showUpdateForm($empid)
    {
        // Fetch employee details
        $employee = Employee::findOrFail($empid);
        
        // Render the update view with employee data
        return view('admin.update_employee', compact('employee'));
    }

    public function update(Request $request, $empid)
    {
        // Validate the incoming request data
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'department' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'mobileno' => 'required|string|max:10',
        ]);

        // Update employee details
        $employee = Employee::findOrFail($empid);
        $employee->update([
            'FirstName' => $request->input('firstName'),
            'LastName' => $request->input('lastName'),
            'Gender' => $request->input('gender'),
            'Dob' => $request->input('dob'),
            'Department' => $request->input('department'),
            'Address' => $request->input('address'),
            'City' => $request->input('city'),
            'Country' => $request->input('country'),
            'Phonenumber' => $request->input('mobileno'),
        ]);

        return redirect()->route('admin.employees')->with('success', 'Employee record updated successfully');
    }

    // Method to get the count of unread notifications
    public function getUnreadNotifications()
    {
        $isRead = 0; // Represents unread status
        $unreadCount = Leave::where('IsRead', $isRead)->count();

        return $unreadCount;
    }

    // Method to fetch unread leave applications and return a view
    public function getLeaveNotifications()
    {
        $isRead = 0; // Represents unread status
        $leaves = Leave::with('employee') // Assuming 'employee' is a defined relationship in the Leave model
            ->where('IsRead', $isRead)
            ->get();

        return view('admin.leave_notifications', compact('leaves'));
    }

    // Optionally, you could have a method to mark notifications as read
    public function markAsRead($leaveId)
    {
        $leave = Leave::find($leaveId);
        if ($leave) {
            $leave->IsRead = 1; // Set the leave as read
            $leave->save();

            return redirect()->back()->with('success', 'Leave marked as read');
        }

        return redirect()->back()->with('error', 'Leave not found');
    }

    /**
     * Show the password recovery form.
     *
     * @return \Illuminate\View\View
     */
    public function showRecoverPasswordForm()
    {
        return view('admin.recover-password'); // Adjust view path as necessary
    }

    /**
     * Handle the password recovery request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recoverPassword(Request $request)
    {
        $request->validate([
            'emailid' => 'required|email',
            'empid' => 'required|string',
        ]);

        // Check if the employee exists
        $employee = DB::table('tblemployees')
            ->where('EmailId', $request->input('emailid'))
            ->where('EmpId', $request->input('empid'))
            ->first();

        if ($employee) {
            // Store employee ID in session
            Session::put('empid', $employee->id);
            return redirect()->route('admin.showChangePasswordForm'); // Redirect to change password form
        }

        return back()->withErrors(['Invalid Details. Please try again.']);
    }

    /**
     * Show the form for changing the password.
     *
     * @return \Illuminate\View\View
     */
    public function showChangePasswordForm()
    {
        return view('admin.change-password'); // Adjust view path as necessary
    }

    /**
     * Change the employee password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'newpassword' => 'required|string|min:6|confirmed',
        ]);

        $empid = Session::get('empid');

        // Update password in the database
        DB::table('tblemployees')
            ->where('id', $empid)
            ->update(['Password' => Hash::make($request->input('newpassword'))]);

        // Clear the session
        Session::forget('empid');

        return redirect()->route('admin.login')->with('success', 'Your Password has been changed successfully.');
    }

    /**
     * Get the count of approved leave applications.
     *
     * @return int
     */
    public function approvedLeaveCount()
    {
        // Query to count approved leave applications
        $approvedLeaveCount = DB::table('tblleaves')
            ->where('Status', '1') // Status '1' indicates approved
            ->count();

        return response()->json(['approvedLeaveCount' => $approvedLeaveCount]);
    }

    /**
     * Get the count of declined leave applications.
     *
     * @return int
     */
    public function declinedLeaveCount()
    {
        // Query to count declined leave applications
        $declinedLeaveCount = DB::table('tblleaves')
            ->where('Status', '2') // Status '2' indicates declined
            ->count();

        return response()->json(['declinedLeaveCount' => $declinedLeaveCount]);
    }

    /**
     * Get the count of departments.
     *
     * @return int
     */
    public function departmentCount()
    {
        // Query to count departments
        $departmentCount = DB::table('tbldepartments')->count();

        return response()->json(['departmentCount' => $departmentCount]);
    }

    /**
     * Get the count of employees.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function employeeCount()
    {
        // Query to count employees
        $employeeCount = DB::table('tblemployees')->count();

        return response()->json(['employeeCount' => $employeeCount]);
    }

    /**
     * Get the count of leave types.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function leaveTypeCount()
    {
        // Query to count leave types
        $leaveTypeCount = DB::table('tblleavetype')->count();

        return response()->json(['leaveTypeCount' => $leaveTypeCount]);
    }

    /**
     * Get the count of pending leave applications.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function pendingLeaveCount()
    {
        // Query to count pending leave applications where status is '0'
        $pendingLeaveCount = DB::table('tblleaves')->where('Status', '0')->count();

        return response()->json(['pendingLeaveCount' => $pendingLeaveCount]);
    }
}

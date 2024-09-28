<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\EmployeeAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;

// Welcome Route
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Admin Authentication Routes
Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login']);
Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Employee Authentication Routes
Route::get('employee/login', [EmployeeAuthController::class, 'showLoginForm'])->name('employee.login');
Route::post('employee/login', [EmployeeAuthController::class, 'login']);
Route::post('employee/logout', [EmployeeAuthController::class, 'logout'])->name('employee.logout');

// Employee Index (Login View)
Route::get('employees', function () {
    return view('employees.index');
})->name('employee.index');

// Admin Dashboard
Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Admin Management
Route::get('admin/manage-admin', [AdminController::class, 'manageAdmin'])->name('admin.manage-admin');
Route::get('admin/add-admin', [AdminController::class, 'showAddAdminForm'])->name('admin.add-admin');
Route::post('admin/add-admin', [AdminController::class, 'addAdmin']);

// Department Management
Route::get('admin/department', [AdminController::class, 'viewDepartments'])->name('admin.department');
Route::get('admin/add-department', [AdminController::class, 'showAddDepartmentForm'])->name('admin.add-department');
Route::post('admin/add-department', [AdminController::class, 'addDepartment']);
Route::get('admin/edit-department/{id}', [AdminController::class, 'editDepartment'])->name('admin.edit-department');
Route::post('admin/update-department/{id}', [AdminController::class, 'updateDepartment']);

// Employee Management
Route::get('admin/employees', [AdminController::class, 'viewEmployees'])->name('admin.employees');
Route::get('admin/add-employee', [AdminController::class, 'showAddEmployeeForm'])->name('admin.add-employee');
Route::post('admin/add-employee', [AdminController::class, 'addEmployee']);
Route::get('admin/update-employee/{id}', [AdminController::class, 'editEmployee'])->name('admin.update-employee');
Route::post('admin/update-employee/{id}', [AdminController::class, 'updateEmployee']);

// Leave Type Management
Route::get('admin/leave-section', [AdminController::class, 'viewLeaveTypes'])->name('admin.leave-section');
Route::get('admin/add-leavetype', [AdminController::class, 'showAddLeaveTypeForm'])->name('admin.add-leavetype');
Route::post('admin/add-leavetype', [AdminController::class, 'addLeaveType']);
Route::get('admin/edit-leavetype/{id}', [AdminController::class, 'editLeaveType'])->name('admin.edit-leavetype');
Route::post('admin/update-leavetype/{id}', [AdminController::class, 'updateLeaveType']);

// Leave History and Status
Route::get('admin/leave-history', [AdminController::class, 'leaveHistory'])->name('admin.leave-history');
Route::get('admin/pending-history', [AdminController::class, 'pendingHistory'])->name('admin.pending-history');
Route::get('admin/approved-history', [AdminController::class, 'approvedHistory'])->name('admin.approved-history');
Route::get('admin/declined-history', [AdminController::class, 'declinedHistory'])->name('admin.declined-history');
Route::get('admin/employeeLeave-details/{leaveId}', [AdminController::class, 'leaveDetails'])->name('admin.employeeLeave-details');

// Employee Profile and Leave
Route::get('employee/profile', [EmployeeController::class, 'viewProfile'])->name('employee.my-profile');
Route::get('employee/leave', [EmployeeController::class, 'viewLeaveForm'])->name('employee.leave');
Route::post('employee/apply-leave', [EmployeeController::class, 'applyLeave'])->name('employee.apply-leave');
Route::get('employee/leave-history', [EmployeeController::class, 'leaveHistory'])->name('employee.leave-history');
Route::get('employee/change-password', [EmployeeController::class, 'showChangePasswordForm'])->name('employee.change-password');
Route::post('employee/change-password', [EmployeeController::class, 'changePassword']);

// Includes Views (components like notification, sidebar, profile, footer)
Route::get('admin/includes/admin-notification', function () {
    return view('admin.includes.admin-notification');
})->name('admin.includes.notification');

Route::get('admin/includes/admin-sidebar', function () {
    return view('admin.includes.admin-sidebar');
})->name('admin.includes.sidebar');

Route::get('includes/employee-profile-section', function () {
    return view('includes.employee-profile-section');
})->name('includes.employee-profile-section');

Route::get('includes/footer', function () {
    return view('includes.footer');
})->name('includes.footer');

// Admin Index
Route::get('admin', function () {
    return view('admin.index');
})->name('admin.index');

// Logout Routes
Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::post('employee/logout', [EmployeeAuthController::class, 'logout'])->name('employee.logout');

require base_path('routes/auth.php');

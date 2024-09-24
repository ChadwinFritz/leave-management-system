<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLeaveController;
use App\Http\Controllers\AdminLeaveTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLeaveController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Welcome Route
Route::get('/', function () {
    return view('welcome'); // resources/views/welcome.blade.php
})->name('welcome');

// Registration Routes (Admin Only)
Route::middleware('guest')->group(function () {
    Route::get('register', [AdminAuthController::class, 'showRegistrationForm'])
        ->name('auth.register'); // resources/views/auth/register.blade.php

    Route::post('register', [AdminAuthController::class, 'register']);
});

// Admin Routes
Route::middleware('auth:admin')->group(function () {
    Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])
        ->name('admin.login'); // This is the route that was missing

    Route::post('admin/login', [AdminAuthController::class, 'login']);
    
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard'); // resources/views/admin/admin_dashboard.blade.php

    Route::get('admin/employees', [AdminController::class, 'listEmployees'])
        ->name('admin.employees'); // Assuming a view exists for employee listing

    Route::post('admin/employees/add', [AdminController::class, 'addEmployee'])
        ->name('admin.employees.store');

    Route::get('admin/employees/add', [AdminController::class, 'showAddEmployeeForm'])
        ->name('admin.employees.add');    

    // Show the edit form for an employee
    Route::get('admin/employees/edit/{id}', [AdminController::class, 'showEditEmployeeForm'])
        ->name('admin.employees.edit');

    // Handle the update request for an employee
    Route::put('admin/employees/update/{id}', [AdminController::class, 'updateEmployee'])
        ->name('admin.employees.update');

    Route::get('admin/employees/{id}', [AdminController::class, 'showEmployeeProfile'])
        ->name('admin.employees.details'); // resources/views/admin/employee_details.blade.php

    Route::delete('admin/employees/{id}', [AdminController::class, 'deleteEmployee'])
        ->name('admin.employees.delete');

    Route::get('admin/leave/requests', [AdminLeaveController::class, 'listLeaveRequests'])
        ->name('admin.leave.requests');    

    Route::get('admin/leave/types', [AdminLeaveTypeController::class, 'listLeaveTypes'])
        ->name('admin.leave.types'); // Assuming a view exists for leave types

    Route::put('leave/update/{id}/{action}', [AdminLeaveController::class, 'updateLeave'])
        ->name('leave.update');

    Route::post('employee/{id}/leave-dates', [UserController::class, 'handleLeaveDates'])
        ->name('employee.leaveDates');
});

// User Routes
Route::middleware('guest')->group(function () {
    Route::get('user/login', [UserAuthController::class, 'getLoginPage'])
        ->name('user.login'); // resources/views/user/user_login.blade.php

    Route::post('user/login', [UserAuthController::class, 'loginPost'])
        ->name('user.login.post'); // Updated to avoid name conflict with GET route

    Route::get('user/register', [UserAuthController::class, 'getRegisterPage'])
        ->name('user.register'); // resources/views/auth/register.blade.php (shared registration view)

    Route::post('user/register', [UserAuthController::class, 'postRegister'])
        ->name('user.register.post'); // Added for clarity and consistency
});

// Add default login route to handle login view dynamically for admin or user
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login'); // This is the default login route (will detect whether user or admin)

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    // User Dashboard
    Route::get('user/dashboard', [UserController::class, 'getDashUser'])
        ->name('user.dashboard'); // View: resources/views/user/user_dashboard.blade.php

    // Show Leave Request Form
    Route::get('user/leave/request', [UserLeaveController::class, 'showLeaveRequestForm'])
        ->name('user.leave.request'); // View: resources/views/user/leave_request.blade.php

    // Submit Leave Request
    Route::post('user/leave/request', [UserLeaveController::class, 'submitLeaveRequest'])
        ->name('user.leave.request.submit');

    // User Profile
    Route::get('user/profile', [UserController::class, 'getProfile'])
        ->name('user.profile'); // View: resources/views/user/user_profile.blade.php

    // Post Profile Leave Dates
    Route::post('user/profile/leave-dates', [UserController::class, 'postProfileLeaveDates'])
        ->name('user.profile.leave-dates');

    Route::post('/user/profile/update', [UserController::class, 'updateProfile'])
        ->name('user.profile.update');

    Route::get('/user/leave-count', [UserController::class, 'getEachLeaveCount']);

});

// Auth Logout Route
Route::post('logout', function () {
    auth()->logout();
    return redirect()->route('welcome');
})->name('logout');

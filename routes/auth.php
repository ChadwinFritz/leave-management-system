<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\EmployeeAuthController;

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Admin Registration Routes
    Route::get('register', function () {
        return view('auth.register'); // Ensure this points to your register view
    })->name('admin.register.view');
    
    Route::post('register', [AdminAuthController::class, 'register'])->name('admin.register');
});

// Employee Authentication Routes
Route::prefix('employee')->group(function () {
    Route::get('login', [EmployeeAuthController::class, 'showLoginForm'])->name('employee.login');
    Route::post('login', [EmployeeAuthController::class, 'login']);
    Route::post('logout', [EmployeeAuthController::class, 'logout'])->name('employee.logout');
});

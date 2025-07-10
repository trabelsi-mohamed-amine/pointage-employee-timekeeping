<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Admin;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes
Auth::routes();

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {

    // Employee dashboard
    Route::get('/dashboard', function () {
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('timesheets.index');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Timesheet routes for employees
    Route::get('/timesheets', [TimesheetController::class, 'index'])->name('timesheets.index');
    Route::post('/timesheets/clock-in', [TimesheetController::class, 'clockIn'])->name('timesheets.clock-in');
    Route::post('/timesheets/clock-out', [TimesheetController::class, 'clockOut'])->name('timesheets.clock-out');
    Route::get('/timesheets/history', [TimesheetController::class, 'history'])->name('timesheets.history');

    // Employee Leave Routes
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
    Route::get('/leaves/create', [LeaveController::class, 'create'])->name('leaves.create');
    Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Admin dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard')->middleware(Admin::class);

    // Employee management routes
    Route::middleware([Admin::class])->group(function() {
        Route::resource('employees', EmployeeController::class);

        // Reporting routes
        Route::get('/reports', function() {
            return view('admin.reports');
        })->name('admin.reports');

        // Admin Leave Management Routes
        Route::get('/leaves', [LeaveController::class, 'adminIndex'])->name('admin.leaves.index');
        Route::put('/leaves/{leave}/status', [LeaveController::class, 'updateStatus'])->name('admin.leaves.update-status');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

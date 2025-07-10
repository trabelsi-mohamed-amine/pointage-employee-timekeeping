<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TimesheetController extends Controller
{
    /**
     * Display employee's timesheet dashboard.
     */
    public function index()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            return redirect()->route('home')->with('error', 'No employee profile found.');
        }

        $activeTimesheet = $employee->activeTimesheet();
        $recentTimesheets = $employee->timesheets()
                            ->where('status', 'completed')
                            ->orderBy('clock_out', 'desc')
                            ->take(10)
                            ->get();

        return view('timesheets.index', compact('employee', 'activeTimesheet', 'recentTimesheets'));
    }

    /**
     * Clock in the employee.
     */
    public function clockIn()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            return redirect()->back()->with('error', 'No employee profile found.');
        }

        // Check if employee already has an active timesheet
        if ($employee->activeTimesheet()) {
            return redirect()->back()->with('error', 'You are already clocked in.');
        }

        // Create a new timesheet entry
        $timesheet = new Timesheet([
            'employee_id' => $employee->id,
            'clock_in' => Carbon::now(),
            'status' => 'active'
        ]);

        $timesheet->save();

        return redirect()->back()->with('success', 'You have successfully clocked in.');
    }

    /**
     * Clock out the employee.
     */
    public function clockOut()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            return redirect()->back()->with('error', 'No employee profile found.');
        }

        $activeTimesheet = $employee->activeTimesheet();

        if (!$activeTimesheet) {
            return redirect()->back()->with('error', 'You are not clocked in.');
        }

        // Update the active timesheet with clock out time
        $activeTimesheet->clock_out = Carbon::now();
        $activeTimesheet->status = 'completed';
        $activeTimesheet->save();

        return redirect()->back()->with('success', 'You have successfully clocked out.');
    }

    /**
     * Show employee's timesheet history.
     */
    public function history()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            return redirect()->route('home')->with('error', 'No employee profile found.');
        }

        $timesheets = $employee->timesheets()
                    ->where('status', 'completed')
                    ->orderBy('clock_out', 'desc')
                    ->paginate(20);

        return view('timesheets.history', compact('employee', 'timesheets'));
    }
}

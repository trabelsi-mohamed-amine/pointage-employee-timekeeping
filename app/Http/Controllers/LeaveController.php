<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of leaves for employees.
     */
    public function index()
    {
        $employee = Auth::user()->employee;
        $leaves = Leave::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('leaves.index', compact('leaves'));
    }

    /**
     * Display a listing of all leaves for admin.
     */
    public function adminIndex()
    {
        $leaves = Leave::with('employee')->orderBy('created_at', 'desc')->get();
        return view('leaves.admin', compact('leaves'));
    }

    /**
     * Show the form for creating a new leave request.
     */
    public function create()
    {
        return view('leaves.create');
    }

    /**
     * Store a newly created leave request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'leave_type' => 'required|string',
            'reason' => 'required|string',
        ]);

        $employee = Auth::user()->employee;

        Leave::create([
            'employee_id' => $employee->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'leave_type' => $request->leave_type,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave request submitted successfully');
    }

    /**
     * Update the status of a leave request (for admin).
     */
    public function updateStatus(Request $request, Leave $leave)
    {
        $request->validate([
            'status' => 'required|in:accepted,refused',
            'comment' => 'nullable|string',
        ]);

        // Explicitly convert status to string and use query builder to ensure proper SQL formatting
        $leave->status =  $request->status;
        if ($request->has('comment')) {
            $leave->comment = $request->comment;
        }
        $leave->save();

        return redirect()->route('admin.leaves.index')
            ->with('success', 'Leave request ' . $request->status . ' successfully');
    }
}

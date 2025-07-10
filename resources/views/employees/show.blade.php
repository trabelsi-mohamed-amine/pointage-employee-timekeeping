@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Employee Details</span>
                        <div>
                            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-primary">Edit</a>
                            <a href="{{ route('employees.index') }}" class="btn btn-sm btn-secondary">Back to List</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Employee Information</div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <th width="30%">Employee ID</th>
                                            <td>{{ $employee->employee_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $employee->full_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $employee->user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Position</th>
                                            <td>{{ $employee->position ?? 'Not assigned' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <td>{{ $employee->department ?? 'Not assigned' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ $employee->phone ?? 'Not provided' }}</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Current Status</div>
                                <div class="card-body">
                                    @php
                                        $activeTimesheet = $employee->activeTimesheet();
                                    @endphp

                                    @if ($activeTimesheet)
                                        <div class="alert alert-info">
                                            <h5 class="alert-heading">Currently Working</h5>
                                            <p>Clocked in at: {{ $activeTimesheet->clock_in->format('M d, Y - H:i') }}</p>
                                            <p>Duration: {{ now()->diffForHumans($activeTimesheet->clock_in, true) }}</p>
                                        </div>
                                    @else
                                        <div class="alert alert-secondary">
                                            <h5 class="alert-heading">Not Working</h5>
                                            <p>This employee is currently clocked out.</p>
                                        </div>
                                    @endif

                                    <div class="mt-3">
                                        <h5>Timesheet Summary</h5>
                                        <table class="table table-sm">
                                            <tr>
                                                <th>This Week</th>
                                                <td>{{ $employee->timesheets()->whereDate('clock_in', '>=', now()->startOfWeek())->count() }} entries</td>
                                            </tr>
                                            <tr>
                                                <th>This Month</th>
                                                <td>{{ $employee->timesheets()->whereDate('clock_in', '>=', now()->startOfMonth())->count() }} entries</td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <td>{{ $employee->timesheets()->count() }} entries</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">Recent Timesheets</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Clock In</th>
                                            <th>Clock Out</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($employee->timesheets()->orderBy('created_at', 'desc')->take(10)->get() as $timesheet)
                                            <tr>
                                                <td>{{ $timesheet->clock_in->format('M d, Y') }}</td>
                                                <td>{{ $timesheet->clock_in->format('H:i') }}</td>
                                                <td>{{ $timesheet->clock_out ? $timesheet->clock_out->format('H:i') : 'Active' }}</td>
                                                <td>
                                                    @if ($timesheet->clock_out)
                                                        {{ number_format($timesheet->duration, 2) }} hours
                                                    @else
                                                        {{ now()->diffForHumans($timesheet->clock_in, true) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge {{ $timesheet->status === 'completed' ? 'bg-success' : 'bg-info' }}">
                                                        {{ ucfirst($timesheet->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No timesheet records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

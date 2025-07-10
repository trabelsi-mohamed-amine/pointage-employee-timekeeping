@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Employee Dashboard - {{ $employee->full_name }}
                    <span class="badge {{ $employee->is_active ? 'bg-success' : 'bg-danger' }} float-end">
                        {{ $employee->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Employee Info</div>
                                <div class="card-body">
                                    <p><strong>ID:</strong> {{ $employee->employee_id }}</p>
                                    <p><strong>Name:</strong> {{ $employee->full_name }}</p>
                                    <p><strong>Position:</strong> {{ $employee->position ?? 'Not assigned' }}</p>
                                    <p><strong>Department:</strong> {{ $employee->department ?? 'Not assigned' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Current Status</div>
                                <div class="card-body text-center">
                                    @if ($activeTimesheet)
                                        <div class="alert alert-info" role="alert">
                                            <h4>Currently Working</h4>
                                            <p>Clocked in at: {{ $activeTimesheet->clock_in->format('M d, Y - H:i') }}</p>
                                            <p>Duration: {{ now()->diffForHumans($activeTimesheet->clock_in, true) }}</p>
                                        </div>
                                        <form action="{{ route('timesheets.clock-out') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-lg">
                                                <i class="fas fa-sign-out-alt"></i> Clock Out
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-secondary" role="alert">
                                            <h4>Not Working</h4>
                                            <p>You are currently clocked out</p>
                                        </div>
                                        <form action="{{ route('timesheets.clock-in') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-lg">
                                                <i class="fas fa-sign-in-alt"></i> Clock In
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            Recent Timesheets
                            <a href="{{ route('timesheets.history') }}" class="btn btn-sm btn-outline-primary float-end">
                                View All History
                            </a>
                        </div>
                        <div class="card-body">
                            @if ($recentTimesheets->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Clock In</th>
                                                <th>Clock Out</th>
                                                <th>Duration</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentTimesheets as $timesheet)
                                                <tr>
                                                    <td>{{ $timesheet->clock_in->format('M d, Y') }}</td>
                                                    <td>{{ $timesheet->clock_in->format('H:i') }}</td>
                                                    <td>{{ $timesheet->clock_out->format('H:i') }}</td>
                                                    <td>{{ number_format($timesheet->duration, 2) }} hours</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-center">No recent timesheet history available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

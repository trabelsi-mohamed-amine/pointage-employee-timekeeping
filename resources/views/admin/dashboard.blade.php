@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header">Employees</div>
                                <div class="card-body text-center">
                                    <h3>{{ \App\Models\Employee::count() }}</h3>
                                    <p>Total Employees</p>
                                    <a href="{{ route('employees.index') }}" class="btn btn-primary">Manage Employees</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header">Active Employees</div>
                                <div class="card-body text-center">
                                    <h3>{{ \App\Models\Timesheet::whereNull('clock_out')->count() }}</h3>
                                    <p>Currently Working</p>
                                    <a href="{{ route('admin.reports') }}" class="btn btn-info">View Reports</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header">Today's Activity</div>
                                <div class="card-body text-center">
                                    <h3>{{ \App\Models\Timesheet::whereDate('clock_in', today())->count() }}</h3>
                                    <p>Clock-ins Today</p>
                                    <a href="{{ route('admin.reports') }}?filter=today" class="btn btn-success">Today's Report</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">Recent Activity</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Action</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(\App\Models\Timesheet::with('employee')->orderBy('created_at', 'desc')->take(10)->get() as $timesheet)
                                            <tr>
                                                <td>{{ $timesheet->employee->full_name }}</td>
                                                <td>
                                                    @if($timesheet->clock_out)
                                                        Clocked Out
                                                    @else
                                                        Clocked In
                                                    @endif
                                                </td>
                                                <td>{{ $timesheet->clock_out ? $timesheet->clock_out->diffForHumans() : $timesheet->clock_in->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
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

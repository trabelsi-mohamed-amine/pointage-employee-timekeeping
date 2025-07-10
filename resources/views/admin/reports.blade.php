@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Timesheet Reports</span>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary">Back to Dashboard</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card mb-4">
                        <div class="card-header">Filter Options</div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('admin.reports') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="employee" class="form-label">Employee</label>
                                    <select class="form-select" id="employee" name="employee_id">
                                        <option value="">All Employees</option>
                                        @foreach(\App\Models\Employee::orderBy('first_name')->get() as $emp)
                                            <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="department" class="form-label">Department</label>
                                    <select class="form-select" id="department" name="department">
                                        <option value="">All Departments</option>
                                        @foreach(\App\Models\Employee::select('department')->distinct()->whereNotNull('department')->pluck('department') as $dept)
                                            <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                                    <a href="{{ route('admin.reports') }}" class="btn btn-outline-secondary">Clear Filters</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-header">Total Hours</div>
                                <div class="card-body">
                                    <h3>
                                        {{ number_format(\App\Models\Timesheet::query()
                                            ->when(request('start_date'), function($query) {
                                                return $query->whereDate('clock_in', '>=', request('start_date'));
                                            })
                                            ->when(request('end_date'), function($query) {
                                                return $query->whereDate('clock_in', '<=', request('end_date'));
                                            })
                                            ->whereNotNull('clock_out')
                                            ->sum(\DB::raw('TIMESTAMPDIFF(HOUR, clock_in, clock_out)')), 0) }}
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-header">Total Entries</div>
                                <div class="card-body">
                                    <h3>
                                        {{ \App\Models\Timesheet::query()
                                            ->when(request('start_date'), function($query) {
                                                return $query->whereDate('clock_in', '>=', request('start_date'));
                                            })
                                            ->when(request('end_date'), function($query) {
                                                return $query->whereDate('clock_in', '<=', request('end_date'));
                                            })
                                            ->count() }}
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-header">Active Employees</div>
                                <div class="card-body">
                                    <h3>
                                        {{ \App\Models\Timesheet::whereNull('clock_out')
                                            ->distinct('employee_id')
                                            ->count('employee_id') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">Timesheet Data</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Department</th>
                                            <th>Date</th>
                                            <th>Clock In</th>
                                            <th>Clock Out</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $timesheets = \App\Models\Timesheet::with('employee')
                                                ->when(request('start_date'), function($query) {
                                                    return $query->whereDate('clock_in', '>=', request('start_date'));
                                                })
                                                ->when(request('end_date'), function($query) {
                                                    return $query->whereDate('clock_in', '<=', request('end_date'));
                                                })
                                                ->when(request('employee_id'), function($query) {
                                                    return $query->where('employee_id', request('employee_id'));
                                                })
                                                ->when(request('department'), function($query) {
                                                    return $query->whereHas('employee', function($q) {
                                                        $q->where('department', request('department'));
                                                    });
                                                })
                                                ->orderBy('clock_in', 'desc')
                                                ->paginate(15);
                                        @endphp

                                        @forelse ($timesheets as $timesheet)
                                            <tr>
                                                <td>{{ $timesheet->employee->full_name }}</td>
                                                <td>{{ $timesheet->employee->department ?? 'N/A' }}</td>
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
                                                <td colspan="7" class="text-center">No timesheet records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                {{ $timesheets->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

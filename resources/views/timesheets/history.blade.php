@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Timesheet History - {{ $employee->full_name }}
                    <a href="{{ route('timesheets.index') }}" class="btn btn-sm btn-outline-secondary float-end">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
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

                    <div class="card mb-4">
                        <div class="card-header">Filter Options</div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('timesheets.history') }}" class="row g-3">
                                <div class="col-md-4">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Clock In</th>
                                    <th>Clock Out</th>
                                    <th>Duration (hours)</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($timesheets as $timesheet)
                                    <tr>
                                        <td>{{ $timesheet->clock_in->format('M d, Y') }}</td>
                                        <td>{{ $timesheet->clock_in->format('H:i') }}</td>
                                        <td>{{ $timesheet->clock_out ? $timesheet->clock_out->format('H:i') : 'N/A' }}</td>
                                        <td>{{ $timesheet->duration ? number_format($timesheet->duration, 2) : 'N/A' }}</td>
                                        <td>
                                            <span class="badge {{ $timesheet->status === 'completed' ? 'bg-success' : 'bg-warning' }}">
                                                {{ ucfirst($timesheet->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $timesheet->notes ?? 'No notes' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No timesheet records found.</td>
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
@endsection

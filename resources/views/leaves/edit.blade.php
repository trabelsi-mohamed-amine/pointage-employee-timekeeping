@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Leave Request</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('leaves.update', $leave->id) }}">
                        @csrf
                        @method('PUT')

                        @if(Auth::user()->hasRole(['admin', 'manager']))
                            <div class="mb-3">
                                <label for="employee_id" class="form-label">Employee</label>
                                <select class="form-control @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ $leave->employee_id == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="leave_type" class="form-label">Leave Type</label>
                            <select class="form-control @error('leave_type') is-invalid @enderror" id="leave_type" name="leave_type" required>
                                <option value="">Select Leave Type</option>
                                <option value="annual" {{ $leave->leave_type == 'annual' ? 'selected' : '' }}>Annual Leave</option>
                                <option value="sick" {{ $leave->leave_type == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                                <option value="personal" {{ $leave->leave_type == 'personal' ? 'selected' : '' }}>Personal Leave</option>
                                <option value="maternity" {{ $leave->leave_type == 'maternity' ? 'selected' : '' }}>Maternity Leave</option>
                                <option value="paternity" {{ $leave->leave_type == 'paternity' ? 'selected' : '' }}>Paternity Leave</option>
                                <option value="unpaid" {{ $leave->leave_type == 'unpaid' ? 'selected' : '' }}>Unpaid Leave</option>
                                <option value="other" {{ $leave->leave_type == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('leave_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" required value="{{ old('start_date', $leave->start_date->format('Y-m-d')) }}">
                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" required value="{{ old('end_date', $leave->end_date->format('Y-m-d')) }}">
                                @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason</label>
                            <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="3" required>{{ old('reason', $leave->reason) }}</textarea>
                            @error('reason')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        @if(Auth::user()->hasRole(['admin', 'manager']))
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="pending" {{ $leave->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ $leave->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="refused" {{ $leave->status == 'refused' ? 'selected' : '' }}>Refused</option>
                                    <option value="cancelled" {{ $leave->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label">Admin Comment</label>
                                <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="3">{{ old('comment', $leave->comment) }}</textarea>
                                @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @elseif($leave->status == 'pending')
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="cancelled" id="cancelRequest" name="status">
                                    <label class="form-check-label" for="cancelRequest">
                                        Cancel this leave request
                                    </label>
                                </div>
                            </div>
                        @endif

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('leaves.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

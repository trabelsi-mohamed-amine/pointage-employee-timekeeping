@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Leave Request Details</span>
                    <a href="{{ route('leaves.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Employee:</div>
                        <div class="col-md-8">{{ $leave->employee->full_name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Leave Type:</div>
                        <div class="col-md-8">{{ ucfirst($leave->leave_type) }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Duration:</div>
                        <div class="col-md-8">{{ $leave->start_date->format('M d, Y') }} to {{ $leave->end_date->format('M d, Y') }} ({{ $leave->duration }} day(s))</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status:</div>
                        <div class="col-md-8">
                            <span class="badge bg-{{
                                $leave->status == 'pending' ? 'warning' :
                                ($leave->status == 'approved' ? 'success' :
                                ($leave->status == 'rejected' ? 'danger' : 'secondary'))
                            }}">
                                {{ ucfirst($leave->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Reason:</div>
                        <div class="col-md-8">{{ $leave->reason }}</div>
                    </div>

                    @if($leave->comment)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Admin Comment:</div>
                        <div class="col-md-8">{{ $leave->comment }}</div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Submitted:</div>
                        <div class="col-md-8">{{ $leave->created_at->format('M d, Y H:i') }}</div>
                    </div>

                    @if($leave->created_at->ne($leave->updated_at))
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Last Updated:</div>
                        <div class="col-md-8">{{ $leave->updated_at->format('M d, Y H:i') }}</div>
                    </div>
                    @endif

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        @if($leave->status == 'pending')
                            @if(Auth::user()->hasRole(['admin', 'manager']))
                                <form action="{{ route('leaves.approve', $leave->id) }}" method="POST" class="me-2">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Approve</button>
                                </form>
                                <form action="{{ route('leaves.reject', $leave->id) }}" method="POST" class="me-2">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                            @endif

                            @if(Auth::user()->employee->id == $leave->employee_id || Auth::user()->hasRole(['admin', 'manager']))
                                <a href="{{ route('leaves.edit', $leave->id) }}" class="btn btn-primary me-2">Edit</a>
                                <form action="{{ route('leaves.destroy', $leave->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this leave request?')">Delete</button>
                                </form>
                            @endif
                        @elseif(Auth::user()->hasRole(['admin', 'manager']))
                            <a href="{{ route('leaves.edit', $leave->id) }}" class="btn btn-primary me-2">Edit</a>
                            <form action="{{ route('leaves.destroy', $leave->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this leave request?')">Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

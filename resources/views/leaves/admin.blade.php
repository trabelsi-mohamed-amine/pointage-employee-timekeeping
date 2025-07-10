@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Manage Leave Requests') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Employee') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Duration') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Reason') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Comment') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($leaves as $leave)
                                    <tr class="{{ $leave->status === 'pending' ? 'table-secondary' :
                                               ($leave->status === 'accepted' ? 'table-success' :
                                               ($leave->status === 'refused' ? 'table-danger' : '')) }}">
                                        <td>{{ $leave->employee->employee_id }}</td>
                                        <td>{{ $leave->start_date->format('Y-m-d') }}</td>
                                        <td>{{ $leave->end_date->format('Y-m-d') }}</td>
                                        <td>{{ $leave->duration }} days</td>
                                        <td>{{ $leave->leave_type }}</td>
                                        <td>{{ $leave->reason }}</td>
                                        <td>
                                            <span class="badge bg-{{
                                                $leave->status === 'pending' ? 'secondary' :
                                                ($leave->status === 'accepted' ? 'success' :
                                                ($leave->status === 'refused' ? 'danger' : 'primary'))
                                            }}">
                                                {{ ucfirst($leave->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $leave->comment ?? '-' }}</td>
                                        <td>
                                            @if($leave->status === 'pending')
                                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveModal{{ $leave->id }}">
                                                    {{ __('Accept') }}
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $leave->id }}">
                                                    {{ __('Refuse') }}
                                                </button>

                                                <!-- Approve Modal -->
                                                <div class="modal fade" id="approveModal{{ $leave->id }}" tabindex="-1" aria-labelledby="approveModalLabel{{ $leave->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('admin.leaves.update-status', $leave->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="accepted">

                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="approveModalLabel{{ $leave->id }}">{{ __('Accept Leave Request') }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>{{ __('Are you sure you want to accept this leave request?') }}</p>
                                                                    <div class="mb-3">
                                                                        <label for="comment{{ $leave->id }}" class="form-label">{{ __('Comment (Optional)') }}</label>
                                                                        <textarea class="form-control" id="comment{{ $leave->id }}" name="comment" rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                                    <button type="submit" class="btn btn-success">{{ __('Accept') }}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Reject Modal -->
                                                <div class="modal fade" id="rejectModal{{ $leave->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $leave->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('admin.leaves.update-status', $leave->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="refused">

                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="rejectModalLabel{{ $leave->id }}">{{ __('Refuse Leave Request') }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>{{ __('Are you sure you want to refuse this leave request?') }}</p>
                                                                    <div class="mb-3">
                                                                        <label for="comment{{ $leave->id }}" class="form-label">{{ __('Comment (Optional)') }}</label>
                                                                        <textarea class="form-control" id="comment{{ $leave->id }}" name="comment" rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                                    <button type="submit" class="btn btn-danger">{{ __('Refuse') }}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">{{ __('Processed') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">{{ __('No leave requests found.') }}</td>
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
@endsection

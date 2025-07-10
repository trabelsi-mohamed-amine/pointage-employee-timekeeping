@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('My Leave Requests') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <a href="{{ route('leaves.create') }}" class="btn btn-primary">{{ __('Request Leave') }}</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Duration') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Reason') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Comment') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($leaves as $leave)
                                    <tr class="{{ $leave->status === 'pending' ? 'table-secondary' :
                                               ($leave->status === 'accepted' ? 'table-success' :
                                               ($leave->status === 'refused' ? 'table-danger' : '')) }}">
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
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ __('No leave requests found.') }}</td>
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

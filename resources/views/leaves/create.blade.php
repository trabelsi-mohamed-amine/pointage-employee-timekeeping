@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Request Leave') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('leaves.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="start_date" class="form-label">{{ __('Start Date') }}</label>
                            <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}" required>

                            @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label">{{ __('End Date') }}</label>
                            <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}" required>

                            @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="leave_type" class="form-label">{{ __('Leave Type') }}</label>
                            <select id="leave_type" class="form-select @error('leave_type') is-invalid @enderror" name="leave_type" required>
                                <option value="">-- Select Leave Type --</option>
                                <option value="Vacation" {{ old('leave_type') == 'Vacation' ? 'selected' : '' }}>Vacation</option>
                                <option value="Sick" {{ old('leave_type') == 'Sick' ? 'selected' : '' }}>Sick Leave</option>
                                <option value="Personal" {{ old('leave_type') == 'Personal' ? 'selected' : '' }}>Personal Leave</option>
                                <option value="Other" {{ old('leave_type') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>

                            @error('leave_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="reason" class="form-label">{{ __('Reason') }}</label>
                            <textarea id="reason" class="form-control @error('reason') is-invalid @enderror" name="reason" rows="3" required>{{ old('reason') }}</textarea>

                            @error('reason')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Submit Request') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

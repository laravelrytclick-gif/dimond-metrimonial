@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Log New Call - {{ $profile->full_name }}
                </div>

                <div class="card-body">
                    <form action="{{ route('profiles.calls.store', $profile) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="call_type" class="form-label">Call Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('call_type') is-invalid @enderror" id="call_type" name="call_type" required>
                                <option value="">Select Call Type</option>
                                @foreach($callTypes as $value => $label)
                                    <option value="{{ $value }}" {{ old('call_type') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('call_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="call_status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('call_status') is-invalid @enderror" id="call_status" name="call_status" required>
                                <option value="">Select Status</option>
                                @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ old('call_status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('call_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                      id="remarks" name="remarks" rows="3">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="followup_date" class="form-label">Follow-up Date/Time</label>
                            <input type="datetime-local" 
                                   class="form-control @error('followup_date') is-invalid @enderror" 
                                   id="followup_date" name="followup_date" 
                                   value="{{ old('followup_date') }}">
                            @error('followup_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profiles.calls.index', $profile) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Call Log</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Schedule New Meeting - {{ $profile->full_name }}
                </div>

                <div class="card-body">
                    <form action="{{ route('profiles.meetings.store', $profile) }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="meeting_type" class="form-label">Meeting Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('meeting_type') is-invalid @enderror" 
                                        id="meeting_type" name="meeting_type" required>
                                    <option value="">Select Type</option>
                                    @foreach($meetingTypes as $value => $label)
                                        <option value="{{ $value }}" {{ old('meeting_type') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('meeting_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="matched_profile_id" class="form-label">With (Optional)</label>
                                <select class="form-select @error('matched_profile_id') is-invalid @enderror" 
                                        id="matched_profile_id" name="matched_profile_id">
                                    <option value="">Select Profile</option>
                                    @foreach($profiles as $id => $name)
                                        <option value="{{ $id }}" {{ old('matched_profile_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('matched_profile_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="meeting_date" class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('meeting_date') is-invalid @enderror" 
                                       id="meeting_date" 
                                       name="meeting_date" 
                                       value="{{ old('meeting_date', now()->format('Y-m-d')) }}"
                                       required>
                                @error('meeting_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="meeting_time" class="form-label">Time <span class="text-danger">*</span></label>
                                <input type="time" 
                                       class="form-control @error('meeting_time') is-invalid @enderror" 
                                       id="meeting_time" 
                                       name="meeting_time" 
                                       value="{{ old('meeting_time', '14:00') }}"
                                       required>
                                @error('meeting_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="venue" class="form-label">Venue <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('venue') is-invalid @enderror" 
                                   id="venue" 
                                   name="venue" 
                                   value="{{ old('venue') }}"
                                   required>
                            @error('venue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Attendees</label>
                            <select class="form-select select2-multiple" 
                                    name="attendees[]" 
                                    multiple="multiple"
                                    data-placeholder="Select attendees">
                                @foreach($users as $id => $name)
                                    <option value="{{ $id }}" {{ in_array($id, old('attendees', [])) ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    @foreach(['scheduled' => 'Scheduled', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
                                        <option value="{{ $value }}" {{ old('status', 'scheduled') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="next_action_date" class="form-label">Next Action Date</label>
                                <input type="date" 
                                       class="form-control @error('next_action_date') is-invalid @enderror" 
                                       id="next_action_date" 
                                       name="next_action_date" 
                                       value="{{ old('next_action_date') }}">
                                @error('next_action_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="outcome" class="form-label">Outcome</label>
                            <input type="text" 
                                   class="form-control @error('outcome') is-invalid @enderror" 
                                   id="outcome" 
                                   name="outcome" 
                                   value="{{ old('outcome') }}">
                            @error('outcome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" 
                                      name="notes" 
                                      rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profiles.meetings.index', $profile) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Schedule Meeting</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-multiple').select2({
            placeholder: "Select attendees",
            allowClear: true
        });
    });
</script>
@endpush
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    New Proposal - {{ $profile->full_name }}
                </div>

                <div class="card-body">
                    <form action="{{ route('profiles.proposals.store', $profile) }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="receiver_profile_id" class="form-label">Recipient Profile <span class="text-danger">*</span></label>
                                <select class="form-select @error('receiver_profile_id') is-invalid @enderror" 
                                        id="receiver_profile_id" 
                                        name="receiver_profile_id" 
                                        required>
                                    <option value="">Select Profile</option>
                                    @foreach($profiles as $id => $name)
                                        <option value="{{ $id }}" {{ old('receiver_profile_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('receiver_profile_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="medium" class="form-label">Medium <span class="text-danger">*</span></label>
                                <select class="form-select @error('medium') is-invalid @enderror" 
                                        id="medium" 
                                        name="medium" 
                                        required>
                                    <option value="">Select Medium</option>
                                    @foreach($mediums as $value => $label)
                                        <option value="{{ $value }}" {{ old('medium') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('medium')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="side" class="form-label">Side <span class="text-danger">*</span></label>
                                <select class="form-select @error('side') is-invalid @enderror" 
                                        id="side" 
                                        name="side" 
                                        required>
                                    @foreach($sides as $value => $label)
                                        <option value="{{ $value }}" {{ old('side') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('side')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="proposal_status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('proposal_status') is-invalid @enderror" 
                                        id="proposal_status" 
                                        name="proposal_status" 
                                        required>
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" {{ old('proposal_status') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('proposal_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="sent_at" class="form-label">Sent At</label>
                            <input type="datetime-local" 
                                   class="form-control @error('sent_at') is-invalid @enderror" 
                                   id="sent_at" 
                                   name="sent_at" 
                                   value="{{ old('sent_at', now()->format('Y-m-d\TH:i')) }}">
                            @error('sent_at')
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
                            <a href="{{ route('profiles.proposals.index', $profile) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Proposal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
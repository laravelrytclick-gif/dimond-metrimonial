@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add Interaction - {{ $profile->full_name }}</h5>
                    <a href="{{ route('profiles.interactions.index', $profile) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Interactions
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profiles.interactions.store', $profile) }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="interaction_type" class="form-label">Interaction Type</label>
                                    <select class="form-select" id="interaction_type" name="interaction_type" required>
                                        <option value="">Select Type</option>
                                        @foreach($interactionTypes as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Priority</label>
                                    <select class="form-select" id="priority" name="priority">
                                        @foreach($priorities as $key => $value)
                                            <option value="{{ $key }}" {{ $key == 'medium' ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="interaction_date" class="form-label">Interaction Date</label>
                                    <input type="datetime-local" class="form-control" id="interaction_date" name="interaction_date" 
                                           value="{{ now()->format('Y-m-d\TH:i') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        @foreach($statuses as $key => $value)
                                            <option value="{{ $key }}" {{ $key == 'pending' ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="4" required 
                                      placeholder="Enter detailed notes about this interaction..."></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('profiles.interactions.index', $profile) }}" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Interaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

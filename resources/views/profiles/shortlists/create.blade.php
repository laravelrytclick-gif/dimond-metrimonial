@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-heart me-2"></i>
                        Shortlist Profile: {{ $profile->first_name }} {{ $profile->last_name }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profiles.shortlists.store', $profile) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="shortlisted_profile_id" class="form-label">Select Profile to Shortlist</label>
                            <select class="form-select" id="shortlisted_profile_id" name="shortlisted_profile_id" required>
                                <option value="">Choose a profile...</option>
                                @foreach($profiles as $p)
                                    <option value="{{ $p->id }}">
                                        {{ $p->first_name }} {{ $p->last_name }} 
                                        ({{ $p->gender }}, {{ $p->dob ? \Carbon\Carbon::parse($p->dob)->age : 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('shortlisted_profile_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profiles.shortlists.index', $profile) }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Back to Shortlists
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-heart me-2"></i>Add to Shortlist
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
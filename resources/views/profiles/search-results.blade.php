@extends('layouts.app')

@section('title', 'Profile Search Results')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-search me-2"></i>Search Results</h5>
                    <span class="badge bg-light text-dark">{{ $profiles->total() }} Profiles Found</span>
                </div>
                <div class="card-body">
                    @if($profiles->count() > 0)
                        <div class="row">
                            @foreach($profiles as $profile)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start">
                                                @if($profile->profile_photo_path)
                                                    <img src="{{ asset('storage/' . $profile->profile_photo_path) }}" 
                                                         alt="{{ $profile->full_name }}" 
                                                         class="rounded-circle me-3" 
                                                         style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" 
                                                         style="width: 60px; height: 60px;">
                                                        <i class="bi bi-person text-white fs-4"></i>
                                                    </div>
                                                @endif
                                                
                                                <div class="flex-grow-1">
                                                    <h6 class="card-title mb-1">{{ $profile->full_name }}</h6>
                                                    <p class="card-text text-muted small mb-1">
                                                        <i class="bi bi-credit-card me-1"></i>{{ $profile->user_code }}
                                                    </p>
                                                    <p class="card-text text-muted small mb-1">
                                                        <i class="bi bi-calendar me-1"></i>{{ $profile->age ?? 'N/A' }} years
                                                    </p>
                                                    <p class="card-text text-muted small mb-1">
                                                        <i class="bi bi-geo-alt me-1"></i>{{ $profile->city ?? 'N/A' }}
                                                    </p>
                                                    <p class="card-text text-muted small mb-0">
                                                        <i class="bi bi-briefcase me-1"></i>{{ $profile->occupation ?? 'N/A' }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-3">
                                                <span class="badge bg-primary me-1">{{ $profile->religion ?? 'N/A' }}</span>
                                                <span class="badge bg-secondary me-1">{{ $profile->marital_status ?? 'N/A' }}</span>
                                                <span class="badge bg-info">{{ $profile->highest_education ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <div class="btn-group w-100" role="group">
                                                <a href="{{ route('profiles.show', $profile) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-eye me-1"></i>View
                                                </a>
                                                <a href="{{ route('profiles.edit', $profile) }}" class="btn btn-outline-secondary btn-sm">
                                                    <i class="bi bi-pencil me-1"></i>Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $profiles->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-search fs-1 text-muted"></i>
                            <h5 class="mt-3">No profiles found</h5>
                            <p class="text-muted">Try adjusting your search criteria</p>
                            <a href="{{ route('profiles.search') }}" class="btn btn-primary">
                                <i class="bi bi-arrow-left me-2"></i>Back to Search
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

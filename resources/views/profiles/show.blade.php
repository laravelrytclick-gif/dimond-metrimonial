@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Profile Details') }}: {{ $profile->full_name }}</span>
                    <div class="btn-group">
                        @can('update', $profile)
                            <a href="{{ route('profiles.edit', $profile) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                            </a>
                        @endcan
                        <a href="{{ route('profiles.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            @if($profile->profile_photo_path)
                                <img src="{{ asset('storage/' . $profile->profile_photo_path) }}" 
                                     alt="{{ $profile->full_name }}" 
                                     class="img-thumbnail mb-3" 
                                     style="max-width: 200px;">
                            @else
                                <div class="bg-light p-5 text-center">
                                    <i class="fas fa-user-circle fa-5x text-muted"></i>
                                </div>
                            @endif
                            
                            <h4 class="mt-3">{{ $profile->full_name }}</h4>
                            <p class="text-muted">{{ $profile->user_code }}</p>
                            
                            <div class="mt-3">
                                <span class="badge bg-{{ $profile->status === 'Active' ? 'success' : ($profile->status === 'Inactive' ? 'danger' : 'warning') }}">
                                    {{ $profile->status }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="border-bottom pb-2">{{ __('Personal Information') }}</h5>
                                    <dl class="row">
                                        <dt class="col-sm-4">{{ __('Gender') }}:</dt>
                                        <dd class="col-sm-8">{{ $profile->gender ?? 'N/A' }}</dd>
                                        
                                        <dt class="col-sm-4">{{ __('Date of Birth') }}:</dt>
                                        <dd class="col-sm-8">{{ $profile->dob ? $profile->dob->format('d M Y') : 'N/A' }}</dd>
                                        
                                        <dt class="col-sm-4">{{ __('Birth Time') }}:</dt>
                                        <dd class="col-sm-8">{{ $profile->birth_time ? $profile->birth_time->format('h:i A') : 'N/A' }}</dd>
                                        
                                        <dt class="col-sm-4">{{ __('Birth Place') }}:</dt>
                                        <dd class="col-sm-8">{{ $profile->birth_place ?? 'N/A' }}</dd>
                                        
                                        <dt class="col-sm-4">{{ __('Religion') }}:</dt>
                                        <dd class="col-sm-8">{{ $profile->religion ?? 'N/A' }}</dd>
                                        
                                        <dt class="col-sm-4">{{ __('Marital Status') }}:</dt>
                                        <dd class="col-sm-8">{{ $profile->marital_status ?? 'N/A' }}</dd>
                                    </dl>
                                </div>
                                
                                <div class="col-md-6">
                                    <h5 class="border-bottom pb-2">{{ __('Contact Information') }}</h5>
                                    <dl class="row">
                                        <dt class="col-sm-4">{{ __('Email') }}:</dt>
                                        <dd class="col-sm-8">{{ $profile->email ?? 'N/A' }}</dd>
                                        
                                        <dt class="col-sm-4">{{ __('Phone') }}:</dt>
                                        <dd class="col-sm-8">{{ $profile->phone ?? 'N/A' }}</dd>
                                        
                                        <dt class="col-sm-4">{{ __('Alternate Phone') }}:</dt>
                                        <dd class="col-sm-8">{{ $profile->alternate_phone ?? 'N/A' }}</dd>
                                        
                                        <dt class="col-sm-4">{{ __('Address') }}:</dt>
                                        <dd class="col-sm-8">
                                            {{ $profile->address }}<br>
                                            {{ $profile->city }}, {{ $profile->state }}<br>
                                            {{ $profile->country }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <h5 class="border-bottom pb-2">{{ __('Professional Information') }}</h5>
                                    <dl class="row">
                                        <dt class="col-sm-4">{{ __('Occupation') }}:</dt>
                                        <dd class="col-sm-8">{{ $profile->occupation ?? 'N/A' }}</dd>
                                        
                                        <dt class="col-sm-4">{{ __('Income') }}:</dt>
                                        <dd class="col-sm-8">{{ $profile->income ? '₹' . number_format($profile->income, 2) : 'N/A' }}</dd>
                                        
                                        <dt class="col-sm-4">{{ __('Work Location') }}:</dt>
                                        <dd class="col-sm-8">{{ $profile->work_location ?? 'N/A' }}</dd>
                                    </dl>
                                </div>
                                
                                <div class="col-md-6">
                                    <h5 class="border-bottom pb-2">{{ __('Other Information') }}</h5>
                                    <dl class="row">
                                        <dt class="col-sm-4">{{ __('RM') }}:</dt>
                                        <dd class="col-sm-8">
                                            @if($profile->relationshipManager)
                                                {{ $profile->relationshipManager->name }}
                                            @else
                                                {{ __('Not Assigned') }}
                                            @endif
                                        </dd>
                                        
                                        <dt class="col-sm-4">{{ __('Registration Date') }}:</dt>
                                        <dd class="col-sm-8">{{ $profile->registration_date->format('d M Y') }}</dd>
                                        
                                        <dt class="col-sm-4">{{ __('Last Updated') }}:</dt>
                                        <dd class="col-sm-8">{{ $profile->updated_at->format('d M Y h:i A') }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header d-flex justify-content-between align-items-center">
    <span>Profile Details</span>
    <div>
        <a href="{{ route('profiles.family.index', $profile) }}" class="btn btn-sm btn-info me-2">
            <i class="fas fa-users"></i> Family Members
        </a>
        @can('update', $profile)
            <a href="{{ route('profiles.edit', $profile) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit Profile
            </a>
        @endcan
    </div>
</div>
        </div>
    </div>
</div>
@endsection

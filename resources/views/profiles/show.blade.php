@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #8B0000;">
                    <span class="h4 mb-0 text-white"><i class="fas fa-user-circle me-2"></i>Customer Details</span>
                    <div>
                        <a href="{{ route('profiles.family.index', $profile) }}" class="btn btn-sm me-2" style="background-color: white; color: #333; border: 1px solid #ddd; border-radius: 20px;">
                            <i class="fas fa-users"></i> Family
                        </a>
                        <a href="{{ route('profiles.backgrounds.index', $profile) }}" class="btn btn-sm me-2" style="background-color: white; color: #333; border: 1px solid #ddd; border-radius: 20px;">
                            <i class="fas fa-graduation-cap"></i> Background
                        </a>
                        @if($profile->matchPreference)
                            <a href="{{ route('profiles.match-preferences.edit', [$profile, $profile->matchPreference]) }}" 
                               class="btn btn-sm me-2" style="background-color: white; color: #333; border: 1px solid #ddd; border-radius: 20px;">
                                <i class="fas fa-heart"></i> Match Preferences
                            </a>
                        @endif
                        @can('update', $profile)
                            <a href="{{ route('profiles.meetings.index', $profile) }}" class="btn btn-sm me-2" style="background-color: white; color: #333; border: 1px solid #ddd; border-radius: 20px;">
                                <i class="fas fa-calendar-alt"></i> Meetings
                            </a>
                            <a href="{{ route('profiles.proposals.index', $profile) }}" class="btn btn-sm me-2" style="background-color: white; color: #333; border: 1px solid #ddd; border-radius: 20px;">
                                <i class="fas fa-paper-plane"></i> Proposals
                            </a>
                            <a href="{{ route('profiles.status-history.index', $profile) }}" class="btn btn-sm me-2" style="background-color: white; color: #333; border: 1px solid #ddd; border-radius: 20px;">
                                <i class="fas fa-history"></i> Status History
                            </a>
                            <a href="{{ route('profiles.finance.index', $profile) }}" class="btn btn-sm me-2" style="background-color: white; color: #333; border: 1px solid #ddd; border-radius: 20px;">
                                <i class="fas fa-rupee-sign"></i> Payments
                            </a>
                            <a href="{{ route('profiles.attachments.index', $profile) }}" class="btn btn-sm me-2" style="background-color: white; color: #333; border: 1px solid #ddd; border-radius: 20px;">
                                <i class="fas fa-paperclip"></i> Attachments
                            </a>
                            <a href="{{ route('profiles.shortlists.index', $profile) }}" class="btn btn-sm me-2" style="background-color: white; color: #333; border: 1px solid #ddd; border-radius: 20px;">
                                <i class="fas fa-list"></i> Shortlists
                            </a>
                            <a href="{{ route('profiles.calls.index', $profile) }}" class="btn btn-sm me-2" style="background-color: white; color: #333; border: 1px solid #ddd; border-radius: 20px;">
                                <i class="fas fa-phone"></i> Call Logs
                            </a>
                            <a href="{{ route('profiles.edit', $profile) }}" class="btn btn-sm btn-warning me-2" style="border-radius: 20px;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endcan
                        <a href="{{ route('profiles.index') }}" class="btn btn-sm btn-secondary" style="border-radius: 20px;">
                            <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <!-- Profile Header with Photo and Basic Info -->
                    <div class="row bg-light p-4 border-bottom">
                        <div class="col-md-3 text-center">
                            @if($profile->profile_photo_path)
                                <img src="{{ asset('storage/' . $profile->profile_photo_path) }}" 
                                     alt="{{ $profile->full_name }}" 
                                     class="img-thumbnail shadow mb-3" 
                                     style="max-width: 250px; border-radius: 10px;">
                            @else
                                <div class="bg-white p-5 text-center shadow-sm rounded">
                                    <i class="fas fa-user-circle fa-8x text-muted"></i>
                                </div>
                            @endif
                            
                            <h4 class="mt-3 mb-1">{{ $profile->full_name ?? 'N/A' }}</h4>
                            <p class="text-muted mb-2">Registration No.: {{ $profile->user_code ?? 'N/A' }}</p>
                            
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <span class="badge bg-{{ $profile->status === 'Active' ? 'success' : ($profile->status === 'Inactive' ? 'danger' : 'warning') }} fs-6">
                                    {{ $profile->status ?? 'N/A' }}
                                </span>
                                @if($profile->gender)
                                    <span class="badge bg-info fs-6">{{ $profile->gender }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-9">
                            <h3 class="mb-3 text-primary">Personal Information</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex border-bottom pb-2">
                                        <strong class="text-muted" style="width: 180px;">GENDER:</strong>
                                        <span>{{ $profile->gender ?? 'N/A' }}</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">D.O.B & TIME:</strong>
                                        <span>{{ $profile->dob ? $profile->dob->format('d-m-Y') : 'N/A' }} 
                                            @if($profile->birth_time) Time : {{ $profile->birth_time->format('H:iHRS') }}@endif</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">AGE:</strong>
                                        <span>{{ $profile->age ? $profile->age . ' Year' : 'N/A' }}</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">PLACE OF BIRTH:</strong>
                                        <span>{{ $profile->birth_place ?? 'N/A' }}</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">RELIGION:</strong>
                                        <span>{{ $profile->religion ?? 'N/A' }}</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">CASTE:</strong>
                                        <span>{{ $profile->caste ?? 'N/A' }}</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">SUBCASTE:</strong>
                                        <span>{{ $profile->sub_caste ?? 'N/A' }}</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">GOTRA:</strong>
                                        <span>{{ $profile->gotra ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="d-flex border-bottom pb-2">
                                        <strong class="text-muted" style="width: 180px;">HEIGHT:</strong>
                                        <span>{{ $profile->height ?? 'N/A' }}</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">WEIGHT:</strong>
                                        <span>{{ $profile->weight ? $profile->weight . 'KGS' : 'N/A' }}</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">COMPLEXION:</strong>
                                        <span>{{ $profile->complexion ?? 'N/A' }}</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">COLOR OF EYES:</strong>
                                        <span>Black</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">COLOR OF HAIR:</strong>
                                        <span>Black</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">DISEASE / DISABILITY:</strong>
                                        <span>No</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">BLOOD GROUP:</strong>
                                        <span>{{ $profile->blood_group ?? 'N/A' }}</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">ASTRO STATUS:</strong>
                                        <span>Non-Manglik</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <div class="d-flex border-bottom pb-2">
                                        <strong class="text-muted" style="width: 180px;">DRINKING HABIT:</strong>
                                        <span>{{ $profile->drinking_habit ?? 'Non-Drinker' }}</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">SMOKING HABIT:</strong>
                                        <span>{{ $profile->smoking_habit ?? 'Non Smoker' }}</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">EATING HABIT:</strong>
                                        <span>{{ $profile->eating_habit ?? 'Dont Know' }}</span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="d-flex border-bottom pb-2">
                                        <strong class="text-muted" style="width: 180px;">HOBBIES:</strong>
                                        <span>TRAVELLING, MOVIES, MUSIC.</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">CHARACTERISTICS:</strong>
                                        <span>SIMPLE, FRIENDLY, CARING</span>
                                    </div>
                                    <div class="d-flex border-bottom pb-2 pt-2">
                                        <strong class="text-muted" style="width: 180px;">EDUCATION:</strong>
                                        <span>{{ $profile->highest_education ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Education Information -->
                    <div class="p-4 border-bottom">
                        <h3 class="mb-3 text-primary">Education Information</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>S.NO</th>
                                        <th>COURSES</th>
                                        <th>INSTITUTION</th>
                                        <th>YEARS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>{{ $profile->highest_education ?? 'N/A' }}</td>
                                        <td>University of Delhi</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="p-4 border-bottom">
                        <h3 class="mb-3 text-primary">Professional Information</h3>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="d-flex border-bottom pb-2">
                                    <strong class="text-muted" style="width: 180px;">OCCUPATION:</strong>
                                    <span>{{ $profile->occupation ?? 'Homely' }}</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">PERSONAL INCOME(P.A):</strong>
                                    <span>{{ $profile->income ? number_format($profile->income, 2) : 'Dont Want to Specify' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex border-bottom pb-2">
                                    <strong class="text-muted" style="width: 180px;">VISA STATUS:</strong>
                                    <span>CITIZEN</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">RESIDENTIAL STATUS:</strong>
                                    <span>Indian</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>S.NO</th>
                                        <th>ORGANISATION</th>
                                        <th>DESIGNATION</th>
                                        <th>YEAR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <div class="d-flex border-bottom pb-2">
                                    <strong class="text-muted" style="width: 180px;">RESIDING CITY:</strong>
                                    <span>{{ $profile->city ?? 'NEW DELHI' }}</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">RESIDING COUNTRY:</strong>
                                    <span>{{ $profile->country ?? 'INDIA' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex border-bottom pb-2">
                                    <strong class="text-muted" style="width: 180px;">NATIONALITY:</strong>
                                    <span>Indian</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">MARITAL STATUS:</strong>
                                    <span>{{ $profile->marital_status ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Family Information -->
                    <div class="p-4 border-bottom">
                        <h3 class="mb-3 text-primary">Family Information</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex border-bottom pb-2">
                                    <strong class="text-muted" style="width: 180px;">FATHER NAME:</strong>
                                    <span>Mr Mukesh Behl</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">FATHER OCCUPATION:</strong>
                                    <span>BUSINESSMAN</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">FATHER DETAILS:</strong>
                                    <span>Rodium platting</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">MOTHER NAME:</strong>
                                    <span>Mrs Anita</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">MOTHER OCCUPATION:</strong>
                                    <span>HOMEMAKER</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex border-bottom pb-2">
                                    <strong class="text-muted" style="width: 180px;">TYPE OF FAMILY:</strong>
                                    <span>Nuclear</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">FAMILY STATUS:</strong>
                                    <span>UPPER MIDDLE CLASS</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">FAMILY INCOME:</strong>
                                    <span>Dont Want to Specify</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">FAMILY NATIVE:</strong>
                                    <span>-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sibling Details -->
                    <div class="p-4 border-bottom">
                        <h3 class="mb-3 text-primary">Sibling Details</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>S.NO</th>
                                        <th>NAME</th>
                                        <th>B/S</th>
                                        <th>AGE</th>
                                        <th>STATUS</th>
                                        <th>DETAILS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>SISTER</td>
                                        <td>Elder Sister</td>
                                        <td>-</td>
                                        <td>MARRIED</td>
                                        <td>WELL SETTLED</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <div class="p-4">
                        <h3 class="mb-3 text-primary">Contact Details</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex border-bottom pb-2">
                                    <strong class="text-muted" style="width: 180px;">CONTACT PERSON:</strong>
                                    <span>MR. BEHL</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">ADDRESS:</strong>
                                    <span>Geeta colony first block east delhi.<br>Own house/floor: own floor</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">LOCATION:</strong>
                                    <span>Geeta colony</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex border-bottom pb-2">
                                    <strong class="text-muted" style="width: 180px;">CITY:</strong>
                                    <span>{{ $profile->city ?? 'New Delhi' }}</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">STATE:</strong>
                                    <span>{{ $profile->state ?? 'Delhi' }}</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">POSTAL CODE:</strong>
                                    <span>110031</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">COUNTRY:</strong>
                                    <span>{{ $profile->country ?? 'India' }}</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">MOBILE:</strong>
                                    <span>{{ $profile->phone ?? '-' }}</span>
                                </div>
                                <div class="d-flex border-bottom pb-2 pt-2">
                                    <strong class="text-muted" style="width: 180px;">EMAIL:</strong>
                                    <span>{{ $profile->email ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
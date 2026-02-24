@extends('layouts.app')

@section('title', 'Profile Search')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-search me-2"></i>Profile Search</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('profiles.search.results') }}" id="searchForm">
                        @csrf
                        
                        <div class="row">
                            <!-- Age Range -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Age From</label>
                                <input type="number" name="age_from" class="form-control" min="18" max="100" value="{{ request('age_from') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Age To</label>
                                <input type="number" name="age_to" class="form-control" min="18" max="100" value="{{ request('age_to') }}">
                            </div>
                            
                            <!-- Height Range -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Height From</label>
                                <select name="height_from" class="form-select">
                                    <option value="">Select Height</option>
                                    @for($i = 140; $i <= 200; $i+=5)
                                        <option value="{{ $i }}" {{ request('height_from') == $i ? 'selected' : '' }}>{{ $i }} cm</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Height To</label>
                                <select name="height_to" class="form-select">
                                    <option value="">Select Height</option>
                                    @for($i = 140; $i <= 200; $i+=5)
                                        <option value="{{ $i }}" {{ request('height_to') == $i ? 'selected' : '' }}>{{ $i }} cm</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Gender -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender[]" class="form-select" multiple>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender }}" {{ in_array($gender, request('gender', [])) ? 'selected' : '' }}>{{ $gender }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Religion -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Religion</label>
                                <select name="religion[]" class="form-select" multiple>
                                    @foreach($religions as $religion)
                                        <option value="{{ $religion }}" {{ in_array($religion, request('religion', [])) ? 'selected' : '' }}>{{ $religion }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Caste -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Caste</label>
                                <select name="caste[]" class="form-select" multiple>
                                    @foreach($castes as $caste)
                                        <option value="{{ $caste }}" {{ in_array($caste, request('caste', [])) ? 'selected' : '' }}>{{ $caste }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sub Caste -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Sub Caste</label>
                                <select name="sub_caste[]" class="form-select" multiple>
                                    @foreach($subCastes as $subCaste)
                                        <option value="{{ $subCaste }}" {{ in_array($subCaste, request('sub_caste', [])) ? 'selected' : '' }}>{{ $subCaste }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Eating Habits -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Eating Habits</label>
                                <select name="eating_habit[]" class="form-select" multiple>
                                    @foreach($eatingHabits as $habit)
                                        <option value="{{ $habit }}" {{ in_array($habit, request('eating_habit', [])) ? 'selected' : '' }}>{{ $habit }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Drinking Habits -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Drinking Habits</label>
                                <select name="drinking_habit[]" class="form-select" multiple>
                                    @foreach($drinkingHabits as $habit)
                                        <option value="{{ $habit }}" {{ in_array($habit, request('drinking_habit', [])) ? 'selected' : '' }}>{{ $habit }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Smoking Habits -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Smoking Habits</label>
                                <select name="smoking_habit[]" class="form-select" multiple>
                                    @foreach($smokingHabits as $habit)
                                        <option value="{{ $habit }}" {{ in_array($habit, request('smoking_habit', [])) ? 'selected' : '' }}>{{ $habit }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Blood Group -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Blood Group</label>
                                <select name="blood_group[]" class="form-select" multiple>
                                    @foreach($bloodGroups as $bloodGroup)
                                        <option value="{{ $bloodGroup }}" {{ in_array($bloodGroup, request('blood_group', [])) ? 'selected' : '' }}>{{ $bloodGroup }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Education -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Education</label>
                                <select name="highest_education[]" class="form-select" multiple>
                                    @foreach($educations as $education)
                                        <option value="{{ $education }}" {{ in_array($education, request('highest_education', [])) ? 'selected' : '' }}>{{ $education }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Marital Status -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Marital Status</label>
                                <select name="marital_status[]" class="form-select" multiple>
                                    @foreach($maritalStatuses as $status)
                                        <option value="{{ $status }}" {{ in_array($status, request('marital_status', [])) ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Occupation -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Occupation</label>
                                <select name="occupation[]" class="form-select" multiple>
                                    @foreach($occupations as $occupation)
                                        <option value="{{ $occupation }}" {{ in_array($occupation, request('occupation', [])) ? 'selected' : '' }}>{{ $occupation }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Income -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Income</label>
                                <select name="income[]" class="form-select" multiple>
                                    @foreach($incomes as $income)
                                        <option value="{{ $income }}" {{ in_array($income, request('income', [])) ? 'selected' : '' }}>{{ $income }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- City -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">City</label>
                                <select name="city[]" class="form-select" multiple>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}" {{ in_array($city, request('city', [])) ? 'selected' : '' }}>{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- State -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">State</label>
                                <select name="state[]" class="form-select" multiple>
                                    @foreach($states as $state)
                                        <option value="{{ $state }}" {{ in_array($state, request('state', [])) ? 'selected' : '' }}>{{ $state }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Country -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Country</label>
                                <select name="country[]" class="form-select" multiple>
                                    @foreach($countries as $country)
                                        <option value="{{ $country }}" {{ in_array($country, request('country', [])) ? 'selected' : '' }}>{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Work Location -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Work Location</label>
                                <select name="work_location[]" class="form-select" multiple>
                                    @foreach($workLocations as $workLocation)
                                        <option value="{{ $workLocation }}" {{ in_array($workLocation, request('work_location', [])) ? 'selected' : '' }}>{{ $workLocation }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Status -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status[]" class="form-select" multiple>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ in_array($status, request('status', [])) ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Complexion -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Complexion</label>
                                <select name="complexion[]" class="form-select" multiple>
                                    @foreach($complexions as $complexion)
                                        <option value="{{ $complexion }}" {{ in_array($complexion, request('complexion', [])) ? 'selected' : '' }}>{{ $complexion }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Gotra -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Gotra</label>
                                <select name="gotra[]" class="form-select" multiple>
                                    @foreach($gotras as $gotra)
                                        <option value="{{ $gotra }}" {{ in_array($gotra, request('gotra', [])) ? 'selected' : '' }}>{{ $gotra }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-2"></i>Search Filter
                                </button>
                                <a href="{{ route('profiles.search') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('select[multiple]').select2({
        placeholder: 'Select options...',
        allowClear: true
    });
});
</script>
@endpush

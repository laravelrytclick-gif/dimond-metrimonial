@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Edit Match Preferences for {{ $profile->full_name }}
                </div>

                <div class="card-body">
                    <form action="{{ route('profiles.match-preferences.update', $profile) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <h5>Partner Preferences</h5>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Age Range</label>
                                    <div class="input-group">
                                        <input type="number" name="preferences[age_range][min]" 
                                               class="form-control" placeholder="Min" 
                                               value="{{ $preference->preferences['age_range']['min'] ?? '' }}">
                                        <span class="input-group-text">to</span>
                                        <input type="number" name="preferences[age_range][max]" 
                                               class="form-control" placeholder="Max"
                                               value="{{ $preference->preferences['age_range']['max'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Height Range (cm)</label>
                                    <div class="input-group">
                                        <input type="number" name="preferences[height_range][min]" 
                                               class="form-control" placeholder="Min"
                                               value="{{ $preference->preferences['height_range']['min'] ?? '' }}">
                                        <span class="input-group-text">to</span>
                                        <input type="number" name="preferences[height_range][max]" 
                                               class="form-control" placeholder="Max"
                                               value="{{ $preference->preferences['height_range']['max'] ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Marital Status</label>
                                    <select name="preferences[marital_status]" class="form-select">
                                        <option value="">Any</option>
                                        <option value="never_married" {{ ($preference->preferences['marital_status'] ?? '') == 'never_married' ? 'selected' : '' }}>Never Married</option>
                                        <option value="divorced" {{ ($preference->preferences['marital_status'] ?? '') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                        <option value="widowed" {{ ($preference->preferences['marital_status'] ?? '') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Religion</label>
                                    <input type="text" name="preferences[religion]" 
                                           class="form-control" 
                                           value="{{ $preference->preferences['religion'] ?? '' }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Caste</label>
                                    <input type="text" name="preferences[caste]" 
                                           class="form-control" 
                                           value="{{ $preference->preferences['caste'] ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Sub Caste</label>
                                    <input type="text" name="preferences[sub_caste]" 
                                           class="form-control" 
                                           value="{{ $preference->preferences['sub_caste'] ?? '' }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Education</label>
                                    <input type="text" name="preferences[education]" 
                                           class="form-control" 
                                           value="{{ $preference->preferences['education'] ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Occupation</label>
                                    <input type="text" name="preferences[occupation]" 
                                           class="form-control" 
                                           value="{{ $preference->preferences['occupation'] ?? '' }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Income Range (₹)</label>
                                    <div class="input-group">
                                        <input type="number" name="preferences[income_range][min]" 
                                               class="form-control" placeholder="Min"
                                               value="{{ $preference->preferences['income_range']['min'] ?? '' }}">
                                        <span class="input-group-text">to</span>
                                        <input type="number" name="preferences[income_range][max]" 
                                               class="form-control" placeholder="Max"
                                               value="{{ $preference->preferences['income_range']['max'] ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Eating Habits</label>
                                    <select name="preferences[eating_habits]" class="form-select">
                                        <option value="">Any</option>
                                        <option value="veg" {{ ($preference->preferences['eating_habits'] ?? '') == 'veg' ? 'selected' : '' }}>Vegetarian</option>
                                        <option value="non_veg" {{ ($preference->preferences['eating_habits'] ?? '') == 'non_veg' ? 'selected' : '' }}>Non-Vegetarian</option>
                                        <option value="eggetarian" {{ ($preference->preferences['eating_habits'] ?? '') == 'eggetarian' ? 'selected' : '' }}>Eggetarian</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Drinking</label>
                                    <select name="preferences[drinking_habits]" class="form-select">
                                        <option value="">Any</option>
                                        <option value="no" {{ ($preference->preferences['drinking_habits'] ?? '') == 'no' ? 'selected' : '' }}>No</option>
                                        <option value="occasionally" {{ ($preference->preferences['drinking_habits'] ?? '') == 'occasionally' ? 'selected' : '' }}>Occasionally</option>
                                        <option value="yes" {{ ($preference->preferences['drinking_habits'] ?? '') == 'yes' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Smoking</label>
                                    <select name="preferences[smoking_habits]" class="form-select">
                                        <option value="">Any</option>
                                        <option value="no" {{ ($preference->preferences['smoking_habits'] ?? '') == 'no' ? 'selected' : '' }}>No</option>
                                        <option value="occasionally" {{ ($preference->preferences['smoking_habits'] ?? '') == 'occasionally' ? 'selected' : '' }}>Occasionally</option>
                                        <option value="yes" {{ ($preference->preferences['smoking_habits'] ?? '') == 'yes' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="comments" class="form-label">Additional Comments</label>
                            <textarea class="form-control" id="comments" name="comments" 
                                     rows="3">{{ old('comments', $preference->comments) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profiles.show', $profile) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Preferences</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group">
            <label for="first_name">{{ __('First Name') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" 
                   name="first_name" value="{{ old('first_name', $profile->first_name ?? '') }}" required>
            @error('first_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label for="last_name">{{ __('Last Name') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" 
                   name="last_name" value="{{ old('last_name', $profile->last_name ?? '') }}" required>
            @error('last_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group">
            <label for="gender">{{ __('Gender') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                <option value="">{{ __('Select Gender') }}</option>
                <option value="Male" {{ old('gender', $profile->gender ?? '') == 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                <option value="Female" {{ old('gender', $profile->gender ?? '') == 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                <option value="Other" {{ old('gender', $profile->gender ?? '') == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
            </select>
            @error('gender')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label for="dob">{{ __('Date of Birth') }}</label>
            <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" 
                   name="dob" value="{{ old('dob', isset($profile->dob) ? $profile->dob->format('Y-m-d') : '') }}">
            @error('dob')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">{{ __('Email') }} <span class="text-danger">*</span></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" 
                   name="email" value="{{ old('email', $profile->email ?? '') }}" required>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label for="phone">{{ __('Phone') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" 
                   name="phone" value="{{ old('phone', $profile->phone ?? '') }}" required>
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group">
            <label for="alternate_phone">{{ __('Alternate Phone') }}</label>
            <input type="text" class="form-control @error('alternate_phone') is-invalid @enderror" id="alternate_phone" 
                   name="alternate_phone" value="{{ old('alternate_phone', $profile->alternate_phone ?? '') }}">
            @error('alternate_phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label for="marital_status">{{ __('Marital Status') }}</label>
            <select class="form-select @error('marital_status') is-invalid @enderror" id="marital_status" name="marital_status">
                <option value="">{{ __('Select Marital Status') }}</option>
                <option value="Unmarried" {{ old('marital_status', $profile->marital_status ?? '') == 'Unmarried' ? 'selected' : '' }}>{{ __('Unmarried') }}</option>
                <option value="Divorced" {{ old('marital_status', $profile->marital_status ?? '') == 'Divorced' ? 'selected' : '' }}>{{ __('Divorced') }}</option>
                <option value="Widowed" {{ old('marital_status', $profile->marital_status ?? '') == 'Widowed' ? 'selected' : '' }}>{{ __('Widowed') }}</option>
                <option value="Separated" {{ old('marital_status', $profile->marital_status ?? '') == 'Separated' ? 'selected' : '' }}>{{ __('Separated') }}</option>
            </select>
            @error('marital_status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group">
            <label for="religion">{{ __('Religion') }}</label>
            <input type="text" class="form-control @error('religion') is-invalid @enderror" id="religion" 
                   name="religion" value="{{ old('religion', $profile->religion ?? '') }}">
            @error('religion')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label for="caste">{{ __('Caste') }}</label>
            <input type="text" class="form-control @error('caste') is-invalid @enderror" id="caste" 
                   name="caste" value="{{ old('caste', $profile->caste ?? '') }}">
            @error('caste')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group">
            <label for="occupation">{{ __('Occupation') }}</label>
            <input type="text" class="form-control @error('occupation') is-invalid @enderror" id="occupation" 
                   name="occupation" value="{{ old('occupation', $profile->occupation ?? '') }}">
            @error('occupation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label for="income">{{ __('Income') }}</label>
            <div class="input-group">
                <span class="input-group-text">₹</span>
                <input type="number" step="0.01" class="form-control @error('income') is-invalid @enderror" 
                       id="income" name="income" value="{{ old('income', $profile->income ?? '') }}">
            </div>
            @error('income')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group">
            <label for="rm_id">{{ __('Relationship Manager') }}</label>
            <select class="form-select @error('rm_id') is-invalid @enderror" id="rm_id" name="rm_id">
                <option value="">{{ __('Select RM') }}</option>
                @foreach($rms as $rm)
                    <option value="{{ $rm->id }}" {{ old('rm_id', $profile->rm_id ?? '') == $rm->id ? 'selected' : '' }}>
                        {{ $rm->name }}
                    </option>
                @endforeach
            </select>
            @error('rm_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label for="status">{{ __('Status') }}</label>
            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                <option value="Active" {{ old('status', $profile->status ?? '') == 'Active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                <option value="Inactive" {{ old('status', $profile->status ?? '') == 'Inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                <option value="On Hold" {{ old('status', $profile->status ?? '') == 'On Hold' ? 'selected' : '' }}>{{ __('On Hold') }}</option>
            </select>
            @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="form-group">
            <label for="address">{{ __('Address') }}</label>
            <textarea class="form-control @error('address') is-invalid @enderror" id="address" 
                      name="address" rows="2">{{ old('address', $profile->address ?? '') }}</textarea>
            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <div class="form-group">
            <label for="city">{{ __('City') }}</label>
            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" 
                   name="city" value="{{ old('city', $profile->city ?? '') }}">
            @error('city')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group">
            <label for="state">{{ __('State') }}</label>
            <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" 
                   name="state" value="{{ old('state', $profile->state ?? '') }}">
            @error('state')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group">
            <label for="country">{{ __('Country') }}</label>
            <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" 
                   name="country" value="{{ old('country', $profile->country ?? '') }}">
            @error('country')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="form-group">
            <label for="profile_photo">{{ __('Profile Photo') }}</label>
            <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" 
                   id="profile_photo" name="profile_photo">
            @error('profile_photo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            @if(isset($profile) && $profile->profile_photo_path)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $profile->profile_photo_path) }}" 
                         alt="{{ $profile->full_name }}" class="img-thumbnail" style="max-width: 150px;">
                </div>
            @endif
        </div>
    </div>
</div>

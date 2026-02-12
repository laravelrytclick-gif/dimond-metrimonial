@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Edit Background Information for {{ $profile->full_name }}
                </div>

                <div class="card-body">
                    <form action="{{ route('profiles.backgrounds.update', ['profile' => $profile, 'background' => $background]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                @foreach($types as $value => $label)
                                    <option value="{{ $value }}" {{ old('type', $background->type) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">
                                        <span id="titleLabel">{{ $background->type === 'profession' ? 'Designation' : 'Title' }}</span> <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $background->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="organization" class="form-label">
                                        <span id="orgLabel">{{ $background->type === 'profession' ? 'Company' : 'Institution' }}</span> <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('organization') is-invalid @enderror" 
                                           id="organization" name="organization" value="{{ old('organization', $background->organization) }}" required>
                                    @error('organization')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="specialization" class="form-label">Specialization/Field</label>
                                    <input type="text" class="form-control @error('specialization') is-invalid @enderror" 
                                           id="specialization" name="specialization" value="{{ old('specialization', $background->specialization) }}">
                                    @error('specialization')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                           id="location" name="location" value="{{ old('location', $background->location) }}">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="year_from" class="form-label">From Year <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('year_from') is-invalid @enderror" 
                                           id="year_from" name="year_from" 
                                           min="1900" max="{{ date('Y') + 1 }}" 
                                           value="{{ old('year_from', $background->year_from) }}" required>
                                    @error('year_from')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="year_to" class="form-label">To Year (Leave empty if current)</label>
                                    <input type="number" class="form-control @error('year_to') is-invalid @enderror" 
                                           id="year_to" name="year_to" 
                                           min="1900" max="{{ date('Y') + 1 }}"
                                           value="{{ old('year_to', $background->year_to) }}">
                                    @error('year_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3" id="incomeField" style="{{ $background->type === 'profession' ? '' : 'display: none;' }}">
                            <label for="income" class="form-label">Income (Optional)</label>
                            <input type="text" class="form-control @error('income') is-invalid @enderror" 
                                   id="income" name="income" value="{{ old('income', $background->income) }}">
                            @error('income')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('profiles.backgrounds.index', $profile) }}" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Information</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const incomeField = document.getElementById('incomeField');
        const titleLabel = document.getElementById('titleLabel');
        const orgLabel = document.getElementById('orgLabel');

        function updateFormFields() {
            if (typeSelect.value === 'profession') {
                incomeField.style.display = 'block';
                titleLabel.textContent = 'Designation';
                orgLabel.textContent = 'Company';
            } else {
                incomeField.style.display = 'none';
                titleLabel.textContent = 'Title';
                orgLabel.textContent = 'Institution';
            }
        }

        // Initial update
        updateFormFields();

        // Update on change
        typeSelect.addEventListener('change', updateFormFields);
    });
</script>
@endpush
@endsection
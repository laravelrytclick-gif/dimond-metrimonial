@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Bulk Upload Profiles') }}</span>
                    <a href="{{ route('profiles.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-4">
                        <h5>{{ __('Instructions') }}</h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check-circle text-success"></i> Upload a CSV file containing profile data</li>
                            <li><i class="fas fa-check-circle text-success"></i> First row should contain column headers</li>
                            <li><i class="fas fa-check-circle text-success"></i> Required fields: first_name, last_name, gender, email, phone</li>
                            <li><i class="fas fa-info-circle text-info"></i> Download sample template below</li>
                        </ul>
                    </div>

                    @if(session('import_errors'))
                        <div class="alert alert-warning">
                            <h6>{{ __('Import Errors') }}:</h6>
                            <ul class="mb-0 small">
                                @foreach(session('import_errors') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profiles.bulk-upload.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">{{ __('Choose File') }} (CSV)</label>
                            <input type="file" class="form-control" id="file" name="file" required accept=".csv">
                            <div class="form-text">{{ __('Maximum file size: 10MB') }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="skip_duplicates" name="skip_duplicates" value="1" checked>
                                <label class="form-check-label" for="skip_duplicates">
                                    {{ __('Skip duplicate records (based on email)') }}
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profiles.bulk-upload.template') }}" class="btn btn-outline-primary">
                                <i class="fas fa-download"></i> {{ __('Download Template') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> {{ __('Upload & Import') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

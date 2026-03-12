@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-upload me-2"></i>
                        {{ __('Bulk Upload Profiles') }}
                    </h5>
                    <div>
                        <a href="{{ route('profiles.index') }}" class="btn btn-sm btn-secondary me-2">
                            <i class="bi bi-arrow-left"></i> {{ __('Back to List') }}
                        </a>
                        <button type="button" class="btn btn-sm btn-info" onclick="showFieldHelp()">
                            <i class="bi bi-question-circle"></i> Field Help
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Validation Errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Field Help Modal -->
                    <div class="modal fade" id="fieldHelpModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <i class="bi bi-info-circle me-2"></i>
                                        All Available Fields for Bulk Upload
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Field Name</th>
                                                    <th>Required</th>
                                                    <th>Description</th>
                                                    <th>Example</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><code>first_name</code></td>
                                                    <td><span class="badge bg-danger">Required</span></td>
                                                    <td>First name of the profile</td>
                                                    <td>John</td>
                                                </tr>
                                                <tr>
                                                    <td><code>last_name</code></td>
                                                    <td><span class="badge bg-danger">Required</span></td>
                                                    <td>Last name of the profile</td>
                                                    <td>Doe</td>
                                                </tr>
                                                <tr>
                                                    <td><code>gender</code></td>
                                                    <td><span class="badge bg-danger">Required</span></td>
                                                    <td>Gender (Male, Female, Other)</td>
                                                    <td>Male</td>
                                                </tr>
                                                <tr>
                                                    <td><code>email</code></td>
                                                    <td><span class="badge bg-danger">Required</span></td>
                                                    <td>Email address</td>
                                                    <td>john@example.com</td>
                                                </tr>
                                                <tr>
                                                    <td><code>phone</code></td>
                                                    <td><span class="badge bg-danger">Required</span></td>
                                                    <td>Phone number</td>
                                                    <td>+1234567890</td>
                                                </tr>
                                                <tr>
                                                    <td><code>alternate_phone</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Alternate phone number</td>
                                                    <td>+0987654321</td>
                                                </tr>
                                                <tr>
                                                    <td><code>dob</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Date of birth (YYYY-MM-DD)</td>
                                                    <td>1990-01-15</td>
                                                </tr>
                                                <tr>
                                                    <td><code>birth_time</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Birth time (HH:MM)</td>
                                                    <td>14:30</td>
                                                </tr>
                                                <tr>
                                                    <td><code>birth_place</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Place of birth</td>
                                                    <td>Mumbai</td>
                                                </tr>
                                                <tr>
                                                    <td><code>religion</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Religion</td>
                                                    <td>Hindu</td>
                                                </tr>
                                                <tr>
                                                    <td><code>caste</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Caste</td>
                                                    <td>Brahmin</td>
                                                </tr>
                                                <tr>
                                                    <td><code>sub_caste</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Sub-caste</td>
                                                    <td>Sharma</td>
                                                </tr>
                                                <tr>
                                                    <td><code>gotra</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Gotra</td>
                                                    <td>Kashyap</td>
                                                </tr>
                                                <tr>
                                                    <td><code>height</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Height</td>
                                                    <td>5'10"</td>
                                                </tr>
                                                <tr>
                                                    <td><code>weight</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Weight</td>
                                                    <td>70kg</td>
                                                </tr>
                                                <tr>
                                                    <td><code>complexion</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Skin complexion</td>
                                                    <td>Fair</td>
                                                </tr>
                                                <tr>
                                                    <td><code>blood_group</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Blood group</td>
                                                    <td>O+</td>
                                                </tr>
                                                <tr>
                                                    <td><code>eating_habit</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Eating habit</td>
                                                    <td>Vegetarian</td>
                                                </tr>
                                                <tr>
                                                    <td><code>smoking_habit</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Smoking habit</td>
                                                    <td>No</td>
                                                </tr>
                                                <tr>
                                                    <td><code>drinking_habit</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Drinking habit</td>
                                                    <td>No</td>
                                                </tr>
                                                <tr>
                                                    <td><code>address</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Full address</td>
                                                    <td>123 Main St, City</td>
                                                </tr>
                                                <tr>
                                                    <td><code>city</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>City</td>
                                                    <td>Mumbai</td>
                                                </tr>
                                                <tr>
                                                    <td><code>state</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>State</td>
                                                    <td>Maharashtra</td>
                                                </tr>
                                                <tr>
                                                    <td><code>country</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Country</td>
                                                    <td>India</td>
                                                </tr>
                                                <tr>
                                                    <td><code>highest_education</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Highest education</td>
                                                    <td>Graduate</td>
                                                </tr>
                                                <tr>
                                                    <td><code>occupation</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Occupation</td>
                                                    <td>Software Engineer</td>
                                                </tr>
                                                <tr>
                                                    <td><code>income</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Annual income</td>
                                                    <td>500000</td>
                                                </tr>
                                                <tr>
                                                    <td><code>work_location</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Work location</td>
                                                    <td>Pune</td>
                                                </tr>
                                                <tr>
                                                    <td><code>marital_status</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Marital status</td>
                                                    <td>Unmarried</td>
                                                </tr>
                                                <tr>
                                                    <td><code>rm_id</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Relationship Manager ID</td>
                                                    <td>123</td>
                                                </tr>
                                                <tr>
                                                    <td><code>status</code></td>
                                                    <td><span class="badge bg-secondary">Optional</span></td>
                                                    <td>Profile status</td>
                                                    <td>Active</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a href="{{ route('profiles.bulk-upload.template') }}" class="btn btn-primary">
                                        <i class="bi bi-download"></i> Download Template
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Form -->
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <form action="{{ route('profiles.bulk-upload.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="bi bi-file-earmark-arrow-up me-2"></i>
                                            Upload CSV File
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="file" class="form-label">
                                                <i class="bi bi-file-earmark-csv me-1"></i>
                                                Choose CSV File <span class="text-danger">*</span>
                                            </label>
                                            <input type="file" class="form-control" id="file" name="file" required accept=".csv">
                                            <div class="form-text text-muted">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Maximum file size: 10MB. Only CSV files are accepted.
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="skip_duplicates" name="skip_duplicates" value="1" checked>
                                                <label class="form-check-label" for="skip_duplicates">
                                                    <i class="bi bi-check-square me-1"></i>
                                                    Skip duplicate records (based on email)
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="update_existing" name="update_existing" value="1">
                                                <label class="form-check-label" for="update_existing">
                                                    <i class="bi bi-arrow-repeat me-1"></i>
                                                    Update existing profiles (based on email)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-3">
                                    <a href="{{ route('profiles.bulk-upload.template') }}" class="btn btn-outline-primary">
                                        <i class="bi bi-download"></i> Download Template
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-upload"></i> Upload & Import
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="bi bi-lightning me-2"></i>
                                        Quick Tips
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled small">
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <strong>Required Fields:</strong> first_name, last_name, gender, email, phone
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-info-circle text-info me-2"></i>
                                            <strong>File Format:</strong> CSV with headers in first row
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                            <strong>No Headers:</strong> Don't include empty columns
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-shield-check text-primary me-2"></i>
                                            <strong>Duplicates:</strong> Check to skip duplicate emails
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-database text-secondary me-2"></i>
                                            <strong>Large Files:</strong> Use chunk upload for 500+ records
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(session('import_errors'))
                        <div class="alert alert-warning mt-4">
                            <h6 class="alert-heading">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Import Errors:
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Row</th>
                                            <th>Error</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(session('import_errors') as $index => $error)
                                            <tr>
                                                <td>{{ $index + 2 }}</td>
                                                <td>{{ $error }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showFieldHelp() {
    const modal = new bootstrap.Modal(document.getElementById('fieldHelpModal'));
    modal.show();
}
</script>
@endsection

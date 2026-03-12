@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Profile Number System Test</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>Test Profile Number Generation</h6>
                        <button class="btn btn-primary" onclick="testProfileNumberGeneration()">
                            Generate Test Profile Number
                        </button>
                        <div id="testResult" class="mt-3"></div>
                    </div>
                    
                    <div class="mb-3">
                        <h6>Existing Profiles with Numbers</h6>
                        <div id="existingProfiles">
                            Loading...
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6>Test Convert to Paid</h6>
                        <button class="btn btn-success" onclick="testConvertToPaid()">
                            Test Convert to Paid
                        </button>
                        <div id="convertResult" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function testProfileNumberGeneration() {
    fetch('/api/test-profile-number', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('testResult').innerHTML = `
            <div class="alert alert-success">
                <strong>Generated Profile Number:</strong> ${data.profile_number}<br>
                <strong>Type:</strong> ${data.type}<br>
                <strong>Valid:</strong> ${data.is_valid ? 'Yes' : 'No'}
            </div>
        `;
    })
    .catch(error => {
        document.getElementById('testResult').innerHTML = `
            <div class="alert alert-danger">
                Error: ${error.message}
            </div>
        `;
    });
}

function testConvertToPaid() {
    fetch('/api/test-convert-to-paid', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('convertResult').innerHTML = `
            <div class="alert alert-${data.success ? 'success' : 'danger'}">
                <strong>Result:</strong> ${data.message}<br>
                ${data.old_number ? `<strong>Old Number:</strong> ${data.old_number}<br>` : ''}
                ${data.new_number ? `<strong>New Number:</strong> ${data.new_number}` : ''}
            </div>
        `;
    })
    .catch(error => {
        document.getElementById('convertResult').innerHTML = `
            <div class="alert alert-danger">
                Error: ${error.message}
            </div>
        `;
    });
}

// Load existing profiles
fetch('/api/profiles-with-numbers')
    .then(response => response.json())
    .then(data => {
        let html = '<div class="table-responsive"><table class="table table-striped"><thead><tr><th>ID</th><th>Name</th><th>Profile Number</th><th>Type</th><th>Actions</th></tr></thead><tbody>';
        
        data.profiles.forEach(profile => {
            const type = profile.profile_number.startsWith('66') ? 'Paid' : 'Free';
            html += `<tr>
                <td>${profile.id}</td>
                <td>${profile.first_name} ${profile.last_name}</td>
                <td><code>${profile.profile_number}</code></td>
                <td><span class="badge bg-${type === 'Paid' ? 'success' : 'primary'}">${type}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-success" onclick="convertProfile(${profile.id})">Convert to Paid</button>
                </td>
            </tr>`;
        });
        
        html += '</tbody></table></div>';
        document.getElementById('existingProfiles').innerHTML = html;
    })
    .catch(error => {
        document.getElementById('existingProfiles').innerHTML = `
            <div class="alert alert-danger">Error loading profiles: ${error.message}</div>
        `;
    });

function convertProfile(profileId) {
    fetch(`/api/convert-profile/${profileId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
}
</script>
@endsection

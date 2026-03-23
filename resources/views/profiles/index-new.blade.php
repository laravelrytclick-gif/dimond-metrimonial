@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Actions</h6>
                    <button type="button" class="btn btn-sm btn-outline-light" onclick="toggleSidebar()">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <div class="card-body p-2" id="sidebarActions">
                    <div class="list-group list-group-flush">
                        <!-- Hide/Unhide -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('hide')">
                            <span><i class="bi bi-eye-slash me-2"></i>Hide/Unhide</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        
                        <!-- Convert To Paid -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('convert-paid')">
                            <span><i class="bi bi-currency-rupee me-2"></i>Convert To Paid</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        
                        <!-- Change TME/RM/ME -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('change-tme')">
                            <span><i class="bi bi-person-badge me-2"></i>Change TME/RM/ME</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        
                        <!-- Visited/Non-Visited -->
                        <div class="dropdown">
                            <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <span><i class="bi bi-check-circle me-2"></i>Visited/Non-Visited</span>
                                <i class="bi bi-chevron-right"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="performAction('visited')">
                                    <i class="bi bi-check-circle me-2"></i>Mark as Visited
                                </a></li>
                                <li><a class="dropdown-item" href="#" onclick="performAction('not-visited')">
                                    <i class="bi bi-x-circle me-2"></i>Mark as Not Visited
                                </a></li>
                            </ul>
                        </div>
                        
                        <!-- Find Match -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('find-match')">
                            <span><i class="bi bi-heart me-2"></i>Find Match</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        
                        <!-- Save SL/Send Mail -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('save-sl')">
                            <span><i class="bi bi-envelope me-2"></i>Save SL/Send Mail</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        
                        <!-- Hold/Release -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('hold')">
                            <span><i class="bi bi-pause-circle me-2"></i>Hold/Release</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        
                        <!-- Add Interactions -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('add-interaction')">
                            <span><i class="bi bi-chat-dots me-2"></i>Add Interactions</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        
                        <!-- Interactions Record -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('interactions-record')">
                            <span><i class="bi bi-journal-text me-2"></i>Interactions Record</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        
                        <!-- Add Follow-up -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('add-followup')">
                            <span><i class="bi bi-telephone me-2"></i>Add Follow-up</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        
                        <!-- Add FeedBack -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('add-feedback')">
                            <span><i class="bi bi-star me-2"></i>Add FeedBack</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        
                        <!-- Done/Active -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('done-active')">
                            <span><i class="bi bi-check2-square me-2"></i>Done/Active</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        
                        <!-- Save Single SL -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('save-single-sl')">
                            <span><i class="bi bi-save me-2"></i>Save Single SL</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        
                        <!-- Add Meeting -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('add-meeting')">
                            <span><i class="bi bi-calendar-plus me-2"></i>Add Meeting</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        
                        <!-- Update More Info -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('update-info')">
                            <span><i class="bi bi-pencil-square me-2"></i>Update More Info</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        
                        <!-- Update Match Making -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('update-match')">
                            <span><i class="bi bi-heart-arrow me-2"></i>Update Match Making</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        
                        <!-- Add Photo -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('add-photo')">
                            <span><i class="bi bi-image me-2"></i>Add Photo</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        
                        <!-- Update Finance -->
                        <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="performAction('update-finance')">
                            <span><i class="bi bi-cash-stack me-2"></i>Update Finance</span>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <!-- Red Header Section -->
            <div class="alert alert-danger mb-3" style="background-color: #dc3545; border-color: #dc3545; color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 text-white">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Important Notice</strong>
                        </h5>
                        <p class="mb-0 mt-2 text-white">
                            Please ensure all profile information is accurate and up-to-date. 
                            Profiles with incomplete information may not appear in search results.
                        </p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-light text-dark p-2">
                            <i class="bi bi-clock me-1"></i>
                            Last Updated: {{ now()->format('M d, Y') }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Profiles') }}</h5>
                    <div>
                        @can('create', App\Models\Profile::class)
                            <button class="btn btn-success btn-sm me-2" onclick="window.location.href='{{ route('profiles.bulk-upload') }}'">
                                <i class="bi bi-upload"></i> {{ __('Bulk Upload') }}
                            </button>
                        @endcan
                        <button class="btn btn-primary btn-sm" onclick="window.location.href='{{ route('profiles.create') }}'">
                            <i class="bi bi-plus"></i> {{ __('Add New Profile') }}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search and Filters -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Search profiles..." id="searchInput">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="hidden">Hidden</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="tmeFilter">
                                <option value="">All TME</option>
                                <option value="tme1">TME 1</option>
                                <option value="tme2">TME 2</option>
                                <option value="tme3">TME 3</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="rmFilter">
                                <option value="">All RM</option>
                                <option value="rm1">RM 1</option>
                                <option value="rm2">RM 2</option>
                                <option value="rm3">RM 3</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-secondary w-100" onclick="applyFilters()">
                                <i class="bi bi-funnel"></i> Apply
                            </button>
                        </div>
                    </div>
                    
                    <!-- Tabs Navigation -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                                        All Profiles
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab">
                                        Active Profiles
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                                        Pending Profiles
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="paid-tab" data-bs-toggle="tab" data-bs-target="#paid" type="button" role="tab">
                                        Paid Profiles
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="blocked-tab" data-bs-toggle="tab" data-bs-target="#blocked" type="button" role="tab">
                                        Blocked Profiles
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Tab Content -->
                    <div class="tab-content" id="profileTabContent">
                        <!-- All Profiles Tab -->
                        <div class="tab-pane fade show active" id="all" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="selectAll" onchange="toggleAllProfiles()">
                                            </th>
                                            <th>RNo.</th>
                                            <th>G</th>
                                            <th>SD</th>
                                            <th>Member Name</th>
                                            <th>Y</th>
                                            <th>Cst</th>
                                            <th>HG</th>
                                            <th>WT</th>
                                            <th>EH</th>
                                            <th>Ast</th>
                                            <th>ED</th>
                                            <th>OC</th>
                                            <th>PI</th>
                                            <th>RS</th>
                                            <th>MS</th>
                                            <th>FI</th>
                                            <th>TME</th>
                                            <th>ME</th>
                                            <th>RM</th>
                                            <th>L_call</th>
                                            <th>L_Ma</th>
                                            <th>L_mtng</th>
                                            <th>R_DT</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Visited Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($profiles as $profile)
                                        <tr data-profile-id="{{ $profile->id }}">
                                            <td>
                                                <input type="checkbox" name="profile_ids[]" value="{{ $profile->id }}">
                                            </td>
                                            <td>{{ $profile->id }}</td>
                                            <td>{{ $profile->gender }}</td>
                                            <td>{{ $profile->sub_caste ?? $profile->caste }}</td>
                                            <td>
                                                <strong>{{ $profile->first_name }} {{ $profile->last_name }}</strong>
                                                @if($profile->marital_status)
                                                    <span class="badge bg-secondary ms-2">{{ $profile->marital_status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $profile->dob ? \Carbon\Carbon::parse($profile->dob)->age : 'N/A' }}</td>
                                            <td>{{ $profile->caste }}</td>
                                            <td>{{ $profile->height ?? 'N/A' }}</td>
                                            <td>{{ $profile->weight ?? 'N/A' }}</td>
                                            <td>{{ $profile->highest_education ?? 'N/A' }}</td>
                                            <td>{{ $profile->occupation ?? 'N/A' }}</td>
                                            <td>{{ $profile->education_detail ?? 'N/A' }}</td>
                                            <td>{{ $profile->occupation_detail ?? 'N/A' }}</td>
                                            <td>{{ $profile->income ?? 'N/A' }}</td>
                                            <td>{{ $profile->complexion ?? 'N/A' }}</td>
                                            <td>{{ $profile->blood_group ?? 'N/A' }}</td>
                                            <td>{{ $profile->religion ?? 'N/A' }}</td>
                                            <td>
                                                @if($profile->tme)
                                                    {{ $profile->tme->name }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if($profile->me)
                                                    {{ $profile->me->name }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if($profile->relationshipManager)
                                                    {{ $profile->relationshipManager->name }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if($profile->callFollowups->count() > 0)
                                                    {{ $profile->callFollowups->first()->followup_date->format('M d') }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if($profile->meetings->count() > 0)
                                                    {{ $profile->meetings->first()->meeting_date->format('M d') }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if($profile->meetings->count() > 0)
                                                    {{ $profile->meetings->first()->meeting_date->format('H:i') }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $profile->registration_date ? $profile->registration_date->format('M d, Y') : 'N/A' }}</td>
                                            <td>{{ $profile->phone ?? 'N/A' }}</td>
                                            <td>{{ $profile->email ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge {{ $profile->has_been_visited ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $profile->visited_status_text }}
                                                </span>
                                                @if($profile->last_visited_date)
                                                    <br><small class="text-muted">{{ $profile->last_visited_date->format('M d, Y') }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-sm btn-outline-primary" onclick="viewProfile({{ $profile->id }})">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-success" onclick="editProfile({{ $profile->id }})">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-info" onclick="contactProfile({{ $profile->id }})">
                                                        <i class="bi bi-telephone"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Active Profiles Tab -->
                        <div class="tab-pane fade" id="active" role="tabpanel">
                            <div class="text-center py-5">
                                <i class="bi bi-person-check display-1 text-success"></i>
                                <h5>Active Profiles</h5>
                                <p class="text-muted">Profiles that are currently active and looking for matches.</p>
                            </div>
                        </div>
                        
                        <!-- Pending Profiles Tab -->
                        <div class="tab-pane fade" id="pending" role="tabpanel">
                            <div class="text-center py-5">
                                <i class="bi bi-clock-history display-1 text-warning"></i>
                                <h5>Pending Profiles</h5>
                                <p class="text-muted">Profiles that are pending verification or approval.</p>
                            </div>
                        </div>
                        
                        <!-- Paid Profiles Tab -->
                        <div class="tab-pane fade" id="paid" role="tabpanel">
                            <div class="text-center py-5">
                                <i class="bi bi-currency-rupee display-1 text-info"></i>
                                <h5>Paid Profiles</h5>
                                <p class="text-muted">Profiles with paid membership.</p>
                            </div>
                        </div>
                        
                        <!-- Blocked Profiles Tab -->
                        <div class="tab-pane fade" id="blocked" role="tabpanel">
                            <div class="text-center py-5">
                                <i class="bi bi-shield-x display-1 text-danger"></i>
                                <h5>Blocked Profiles</h5>
                                <p class="text-muted">Profiles that are blocked or suspended.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="text-muted">Showing {{ $profiles->firstItem() }} to {{ $profiles->lastItem() }} of {{ $profiles->total() }} entries</span>
                        {{ $profiles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.sidebar-collapsed {
    transform: translateX(-100%);
    transition: transform 0.3s ease;
}

@media (min-width: 768px) {
    .sidebar-collapsed {
        transform: translateX(0);
    }
}

.list-group-item {
    border: none;
    border-bottom: 1px solid #dee2e6;
    transition: all 0.2s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa;
    color: #8B0000;
}

.list-group-item i:first-child {
    color: #8B0000;
}

.table-responsive {
    max-height: 70vh;
    overflow-y: auto;
}

.table th {
    font-weight: 600;
    font-size: 0.85rem;
    white-space: nowrap;
}

.table td {
    font-size: 0.875rem;
    vertical-align: middle;
}

.badge {
    font-size: 0.7rem;
}
</style>

<script>
// Global variables
let currentProfileId = null;

function toggleSidebar() {
    const sidebar = document.getElementById('sidebarActions');
    sidebar.classList.toggle('d-none');
}

function performAction(action) {
    // Get selected profile IDs
    const selectedProfiles = getSelectedProfiles();
    
    if (selectedProfiles.length === 0) {
        showNotification('Please select at least one profile', 'warning');
        return;
    }
    
    switch(action) {
        case 'hide':
            toggleVisibility(selectedProfiles);
            break;
        case 'convert-paid':
            convertToPaid(selectedProfiles);
            break;
        case 'change-tme':
            showChangeTeamMemberModal(selectedProfiles);
            break;
        case 'visited':
            markVisited(selectedProfiles);
            break;
        case 'not-visited':
            markNotVisited(selectedProfiles);
            break;
        case 'find-match':
            findMatch(selectedProfiles[0]);
            break;
        case 'save-sl':
            showSaveShortlistModal(selectedProfiles[0]);
            break;
        case 'hold':
            toggleHold(selectedProfiles);
            break;
        case 'add-interaction':
            window.location.href = `{{ route('profiles.interactions.create', ':profileId') }}`.replace(':profileId', selectedProfiles[0]);
            break;
        case 'interactions-record':
            window.location.href = `{{ route('profiles.interactions.index', ':profileId') }}`.replace(':profileId', selectedProfiles[0]);
            break;
        case 'add-followup':
            window.location.href = `{{ route('profiles.calls.create', ':profileId') }}`.replace(':profileId', selectedProfiles[0]);
            break;
        case 'add-feedback':
            showAddFeedbackModal(selectedProfiles[0]);
            break;
        case 'done-active':
            toggleDoneActive(selectedProfiles);
            break;
        case 'save-single-sl':
            window.location.href = `{{ route('profiles.shortlists.create', ':profileId') }}`.replace(':profileId', selectedProfiles[0]);
            break;
        case 'add-meeting':
            window.location.href = `{{ route('profiles.meetings.create', ':profileId') }}`.replace(':profileId', selectedProfiles[0]);
            break;
        case 'update-info':
            window.location.href = `{{ route('profiles.edit', ':profileId') }}`.replace(':profileId', selectedProfiles[0]);
            break;
        case 'update-match':
            window.location.href = `{{ route('profiles.match-preferences.edit', ':profileId') }}`.replace(':profileId', selectedProfiles[0]);
            break;
        case 'add-photo':
            window.location.href = `{{ route('profiles.attachments.index', ':profileId') }}`.replace(':profileId', selectedProfiles[0]);
            break;
        case 'update-finance':
            window.location.href = `{{ route('profiles.finance.index', ':profileId') }}`.replace(':profileId', selectedProfiles[0]);
            break;
        default:
            console.log('Unknown action:', action);
    }
}

function getSelectedProfiles() {
    const checkboxes = document.querySelectorAll('input[name="profile_ids[]"]:checked');
    return Array.from(checkboxes).map(cb => cb.value);
}

// API Functions
async function toggleVisibility(profileIds) {
    try {
        const response = await fetch('{{ route("profiles.actions.toggle-visibility") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                profile_ids: profileIds
            })
        });
        
        const data = await response.json();
        showNotification(data.message, 'success');
        location.reload();
    } catch (error) {
        showNotification('Error toggling visibility', 'error');
    }
}

async function convertToPaid(profileIds) {
    try {
        const response = await fetch('{{ route("profiles.actions.convert-to-paid") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                profile_ids: profileIds
            })
        });
        
        const data = await response.json();
        showNotification(data.message, 'success');
        location.reload();
    } catch (error) {
        showNotification('Error converting to paid', 'error');
    }
}

async function markVisited(profileIds) {
    try {
        const response = await fetch('{{ route("profiles.actions.mark-visited") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                profile_ids: profileIds,
                mark_as_visited: true
            })
        });
        
        const data = await response.json();
        showNotification(data.message, 'success');
        location.reload();
    } catch (error) {
        showNotification('Error marking visited status', 'error');
    }
}

async function markNotVisited(profileIds) {
    try {
        const response = await fetch('{{ route("profiles.actions.mark-visited") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                profile_ids: profileIds,
                mark_as_visited: false
            })
        });
        
        const data = await response.json();
        showNotification(data.message, 'success');
        location.reload();
    } catch (error) {
        showNotification('Error marking not visited status', 'error');
    }
}

async function findMatch(profileId) {
    try {
        const response = await fetch('{{ route("profiles.actions.find-match") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                profile_id: profileId
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showMatchesModal(data.matches);
        }
    } catch (error) {
        showNotification('Error finding matches', 'error');
    }
}

// Modal Functions
function showChangeTeamMemberModal(profileIds) {
    const modal = `
        <div class="modal fade" id="teamMemberModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Team Members</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Relationship Manager</label>
                            <select class="form-select" id="rm_id">
                                <option value="">Select RM</option>
                                <!-- Add RM options dynamically -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">TME</label>
                            <select class="form-select" id="tme_id">
                                <option value="">Select TME</option>
                                <!-- Add TME options dynamically -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ME</label>
                            <select class="form-select" id="me_id">
                                <option value="">Select ME</option>
                                <!-- Add ME options dynamically -->
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="saveTeamMembers(${profileIds})">Save</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modal);
    const modalElement = new bootstrap.Modal(document.getElementById('teamMemberModal'));
    modalElement.show();
}

async function saveTeamMembers(profileIds) {
    const rmId = document.getElementById('rm_id').value;
    const tmeId = document.getElementById('tme_id').value;
    const meId = document.getElementById('me_id').value;
    
    try {
        const response = await fetch('{{ route("profiles.actions.change-team-member") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                profile_ids: profileIds,
                rm_id: rmId,
                tme_id: tmeId,
                me_id: meId
            })
        });
        
        const data = await response.json();
        showNotification(data.message, 'success');
        bootstrap.Modal.getInstance(document.getElementById('teamMemberModal')).hide();
        location.reload();
    } catch (error) {
        showNotification('Error updating team members', 'error');
    }
}

function showMatchesModal(matches) {
    const matchesHtml = matches.map(match => {
        const age = match.dob ? Math.floor((new Date() - new Date(match.dob)) / (365.25 * 24 * 60 * 60 * 1000)) : 'N/A';
        return `
        <div class="border rounded p-3 mb-2">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="mb-1">${match.first_name} ${match.last_name}</h6>
                    <div class="text-muted small">
                        <div><strong>Age:</strong> ${age}</div>
                        <div><strong>Gender:</strong> ${match.gender}</div>
                        <div><strong>Religion:</strong> ${match.religion || 'N/A'}</div>
                        <div><strong>Caste:</strong> ${match.caste || 'N/A'}</div>
                        <div><strong>Phone:</strong> ${match.phone || 'N/A'}</div>
                        <div><strong>Email:</strong> ${match.email || 'N/A'}</div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-sm btn-primary" onclick="viewProfile(${match.id})">
                        <i class="bi bi-eye"></i> View
                    </button>
                </div>
            </div>
        </div>
    `;
    }).join('');
    
    const modal = `
        <div class="modal fade" id="matchesModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-heart me-2"></i>Potential Matches (${matches.length})
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        ${matchesHtml || '<div class="alert alert-info">No matches found. Try adjusting your profile preferences.</div>'}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove any existing modal
    const existingModal = document.getElementById('matchesModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    document.body.insertAdjacentHTML('beforeend', modal);
    const modalElement = new bootstrap.Modal(document.getElementById('matchesModal'));
    modalElement.show();
    
    // Clean up modal after hidden
    document.getElementById('matchesModal').addEventListener('hidden.bs.modal', function () {
        this.remove();
    });
}

async function toggleHold(profileIds) {
    try {
        const response = await fetch('{{ route("profiles.actions.toggle-hold") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                profile_ids: profileIds
            })
        });
        
        const data = await response.json();
        showNotification(data.message, 'success');
        location.reload();
    } catch (error) {
        showNotification('Error toggling hold status', 'error');
    }
}

async function toggleDoneActive(profileIds) {
    try {
        const response = await fetch('{{ route("profiles.actions.toggle-done-active") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                profile_ids: profileIds
            })
        });
        
        const data = await response.json();
        showNotification(data.message, 'success');
        location.reload();
    } catch (error) {
        showNotification('Error toggling done/active status', 'error');
    }
}

function showSaveShortlistModal(profileId) {
    const modal = `
        <div class="modal fade" id="shortlistModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Save Shortlist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Target Profile ID</label>
                            <input type="text" class="form-control" id="target_profile_id" placeholder="Enter target profile ID">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="saveShortlist(${profileId})">Save</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modal);
    const modalElement = new bootstrap.Modal(document.getElementById('shortlistModal'));
    modalElement.show();
}

async function saveShortlist(profileId) {
    const targetProfileId = document.getElementById('target_profile_id').value;
    
    if (!targetProfileId) {
        showNotification('Please enter target profile ID', 'warning');
        return;
    }
    
    try {
        const response = await fetch('{{ route("profiles.actions.save-shortlist") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                profile_id: profileId,
                target_profile_id: targetProfileId
            })
        });
        
        const data = await response.json();
        showNotification(data.message, 'success');
        bootstrap.Modal.getInstance(document.getElementById('shortlistModal')).hide();
    } catch (error) {
        showNotification('Error saving shortlist', 'error');
    }
}

function showAddFeedbackModal(profileId) {
    const modal = `
        <div class="modal fade" id="feedbackModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Feedback</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select class="form-select" id="rating">
                                <option value="">Select Rating</option>
                                <option value="5">5 - Excellent</option>
                                <option value="4">4 - Good</option>
                                <option value="3">3 - Average</option>
                                <option value="2">2 - Poor</option>
                                <option value="1">1 - Very Poor</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Feedback</label>
                            <textarea class="form-control" id="feedback" rows="3" placeholder="Enter feedback"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="addFeedback(${profileId})">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modal);
    const modalElement = new bootstrap.Modal(document.getElementById('feedbackModal'));
    modalElement.show();
}

async function addFeedback(profileId) {
    const rating = document.getElementById('rating').value;
    const feedback = document.getElementById('feedback').value;
    
    if (!rating || !feedback) {
        showNotification('Please fill all fields', 'warning');
        return;
    }
    
    try {
        const response = await fetch('{{ route("profiles.actions.add-feedback") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                profile_id: profileId,
                rating: rating,
                feedback: feedback
            })
        });
        
        const data = await response.json();
        showNotification(data.message, 'success');
        bootstrap.Modal.getInstance(document.getElementById('feedbackModal')).hide();
    } catch (error) {
        showNotification('Error adding feedback', 'error');
    }
}

function showNotification(message, type = 'info') {
    const toast = `
        <div class="toast align-items-center text-white bg-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', toast);
    const toastElement = document.body.lastElementChild;
    const bsToast = new bootstrap.Toast(toastElement);
    bsToast.show();
    
    setTimeout(() => toastElement.remove(), 5000);
}

// Profile Actions
function viewProfile(profileId) {
    window.location.href = `{{ route('profiles.show', ':profileId') }}`.replace(':profileId', profileId);
}

function editProfile(profileId) {
    window.location.href = `{{ route('profiles.edit', ':profileId') }}`.replace(':profileId', profileId);
}

function contactProfile(profileId) {
    // Implement contact functionality
    showNotification('Contact feature coming soon', 'info');
}

function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('statusFilter').value;
    const tme = document.getElementById('tmeFilter').value;
    const rm = document.getElementById('rmFilter').value;
    
    // Build URL with filters
    let url = '{{ route("profiles.index") }}?';
    const params = [];
    
    if (search) params.push('search=' + encodeURIComponent(search));
    if (status) params.push('status=' + status);
    if (tme) params.push('tme=' + tme);
    if (rm) params.push('rm=' + rm);
    
    url += params.join('&');
    
    window.location.href = url;
}

// Auto-hide sidebar on mobile
if (window.innerWidth < 768) {
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebarActions');
        if (sidebar) {
            sidebar.classList.add('d-none');
        }
    });
}

// Add checkbox column to table
document.addEventListener('DOMContentLoaded', function() {
    const table = document.querySelector('table');
    if (table) {
        const headerRow = table.querySelector('thead tr');
        const selectAllTh = document.createElement('th');
        selectAllTh.innerHTML = '<input type="checkbox" id="selectAll" onchange="toggleAllProfiles()">';
        headerRow.insertBefore(selectAllTh, headerRow.firstChild);
        
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            const firstCell = row.querySelector('td');
            const checkboxCell = document.createElement('td');
            checkboxCell.innerHTML = `<input type="checkbox" name="profile_ids[]" value="${row.dataset.profileId || index + 1}">`;
            row.insertBefore(checkboxCell, firstCell);
        });
    }
});

function toggleAllProfiles() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('input[name="profile_ids[]"]');
    checkboxes.forEach(cb => cb.checked = selectAll.checked);
}
</script>
@endsection

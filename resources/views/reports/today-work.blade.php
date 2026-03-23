@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        Today Work History
                    </h5>
                    <div class="d-flex gap-2">
                        <form method="GET" action="{{ route('reports.today-work') }}" class="d-flex gap-2">
                            <input type="date" name="date" value="{{ $date }}" class="form-control form-control-sm" style="width: auto;">
                            <select name="rm_id" class="form-select form-select-sm" style="width: auto;">
                                <option value="all" {{ $selectedRM == 'all' ? 'selected' : '' }}>All RMs</option>
                                @foreach($rms as $rm)
                                    <option value="{{ $rm->id }}" {{ $selectedRM == $rm->id ? 'selected' : '' }}>{{ $rm->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-search"></i> Filter
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if($allActivities->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Time</th>
                                        <th>Activity Type</th>
                                        <th>Profile</th>
                                        <th>Relationship Manager</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allActivities as $activity)
                                        <tr>
                                            <td>
                                                @if($activity->activity_type == 'Status Change')
                                                    {{ \Carbon\Carbon::parse($activity->changed_at)->format('h:i A') }}
                                                @else
                                                    {{ \Carbon\Carbon::parse($activity->changed_at)->format('h:i A') }}
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ 
                                                    $activity->activity_type == 'Status Change' ? 'info' : 
                                                    ($activity->activity_type == 'Meeting' ? 'success' : 
                                                    ($activity->activity_type == 'Call Followup' ? 'warning' : 'primary')) 
                                                }}">
                                                    {{ $activity->activity_type }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('profiles.show', $activity->profile_id) }}" class="text-decoration-none">
                                                    {{ $activity->profile_name }}
                                                </a>
                                            </td>
                                            <td>{{ $activity->rm_name }}</td>
                                            <td>
                                                @if($activity->activity_type == 'Status Change')
                                                    <small class="text-muted">
                                                        From: {{ $activity->old_status ?? 'N/A' }}<br>
                                                        To: {{ $activity->new_status ?? 'N/A' }}
                                                    </small>
                                                @else
                                                    <small>{{ $activity->comments ?? 'No details available' }}</small>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-3">
                            <small class="text-muted">
                                Total Activities: {{ $allActivities->count() }} | 
                                Date: {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}
                            </small>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <h5 class="mt-3 text-muted">No activities found</h5>
                            <p class="text-muted">
                                No work activities were recorded on {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}
                                @if($selectedRM != 'all')
                                    for {{ $rms->find($selectedRM)->name ?? 'Selected RM' }}
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

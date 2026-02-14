@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Meetings - {{ $profile->full_name }}</span>
                    <div>
                        <a href="{{ route('profiles.meetings.create', $profile) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Schedule Meeting
                        </a>
                        <a href="{{ route('profiles.show', $profile) }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Profile
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($meetings->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date/Time</th>
                                        <th>Type</th>
                                        <th>With</th>
                                        <th>Venue</th>
                                        <th>Status</th>
                                        <th>Outcome</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($meetings as $meeting)
                                        <tr class="{{ $meeting->meeting_date->isPast() && $meeting->status === 'scheduled' ? 'table-warning' : '' }}">
                                            <td>
                                                {{ $meeting->meeting_date->format('M d, Y') }}<br>
                                                <small class="text-muted">{{ $meeting->meeting_time }}</small>
                                            </td>
                                            <td>{{ ucfirst($meeting->meeting_type) }}</td>
                                            <td>
                                                @if($meeting->matchedProfile)
                                                    {{ $meeting->matchedProfile->full_name }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($meeting->venue, 30) }}</td>
                                            <td>
                                                <span class="badge bg-{{ [
                                                    'scheduled' => 'primary',
                                                    'completed' => 'success',
                                                    'cancelled' => 'danger'
                                                ][$meeting->status] }}">
                                                    {{ ucfirst($meeting->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $meeting->outcome ?? 'N/A' }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('profiles.meetings.edit', ['profile' => $profile, 'meeting' => $meeting]) }}" 
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('profiles.meetings.destroy', ['profile' => $profile, 'meeting' => $meeting]) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('Delete this meeting?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $meetings->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            No meetings found. Click "Schedule Meeting" to add one.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
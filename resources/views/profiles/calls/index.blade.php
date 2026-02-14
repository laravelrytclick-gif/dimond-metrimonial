@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Call History - {{ $profile->full_name }}</span>
                    <div>
                        <a href="{{ route('profiles.calls.create', $profile) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Log New Call
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

                    @if($calls->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date/Time</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Follow-up</th>
                                        <th>Performed By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($calls as $call)
                                        <tr class="{{ $call->followup_date && $call->followup_date->isPast() ? 'table-warning' : '' }}">
                                            <td>{{ $call->created_at->format('M d, Y h:i A') }}</td>
                                            <td>
                                                @switch($call->call_type)
                                                    @case('call')
                                                        <span class="badge bg-primary">Phone Call</span>
                                                        @break
                                                    @case('whatsapp')
                                                        <span class="badge bg-success">WhatsApp</span>
                                                        @break
                                                    @case('visit')
                                                        <span class="badge bg-info">In-Person Visit</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $call->call_status === 'completed' ? 'success' : ($call->call_status === 'missed' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($call->call_status) }}
                                                </span>
                                            </td>
                                            <td>{{ Str::limit($call->remarks, 50) }}</td>
                                            <td>
                                                @if($call->followup_date)
                                                    {{ $call->followup_date->format('M d, Y h:i A') }}
                                                    @if($call->followup_date->isPast())
                                                        <span class="badge bg-danger">Overdue</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">None</span>
                                                @endif
                                            </td>
                                            <td>{{ $call->performedBy->name }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('profiles.calls.edit', ['profile' => $profile, 'call' => $call]) }}" 
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('profiles.calls.destroy', ['profile' => $profile, 'call' => $call]) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('Delete this call log?')">
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
                            {{ $calls->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            No call history found. Click "Log New Call" to add one.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
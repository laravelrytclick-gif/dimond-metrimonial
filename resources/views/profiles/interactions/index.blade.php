@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Interactions - {{ $profile->full_name }}</h5>
                    <div>
                        @can('update', $profile)
                            <a href="{{ route('profiles.interactions.create', $profile) }}" class="btn btn-primary btn-sm me-2">
                                <i class="fas fa-plus"></i> Add Interaction
                            </a>
                        @endcan
                        <a href="{{ route('profiles.show', $profile) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Profile
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($interactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Notes</th>
                                        <th>Added By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($interactions as $interaction)
                                        <tr>
                                            <td>{{ $interaction->interaction_date->format('M d, Y H:i') }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $interaction->interaction_type }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ 
                                                    $interaction->priority === 'urgent' ? 'danger' : 
                                                    ($interaction->priority === 'high' ? 'warning' : 'secondary') 
                                                }}">
                                                    {{ $interaction->priority }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ 
                                                    $interaction->status === 'completed' ? 'success' : 
                                                    ($interaction->status === 'cancelled' ? 'danger' : 'warning') 
                                                }}">
                                                    {{ $interaction->status }}
                                                </span>
                                            </td>
                                            <td>{{ Str::limit($interaction->notes, 100) }}</td>
                                            <td>{{ $interaction->createdBy?->name ?? 'System' }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('profiles.interactions.show', [$profile, $interaction]) }}" 
                                                       class="btn btn-outline-primary" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @can('update', $profile)
                                                        <a href="{{ route('profiles.interactions.edit', [$profile, $interaction]) }}" 
                                                           class="btn btn-outline-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('profiles.interactions.destroy', [$profile, $interaction]) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger" 
                                                                    title="Delete" onclick="return confirm('Are you sure?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-3">
                            {{ $interactions->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-comments display-1 text-muted"></i>
                            <h4 class="mt-3">No Interactions Found</h4>
                            <p class="text-muted">No interactions have been recorded for this profile yet.</p>
                            @can('update', $profile)
                                <a href="{{ route('profiles.interactions.create', $profile) }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add First Interaction
                                </a>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Proposal Details</span>
                    <div>
                        <a href="{{ route('profiles.proposals.index', $profile) }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Proposals
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Sender</h5>
                            <p class="mb-1">
                                <strong>Name:</strong> 
                                <a href="{{ route('profiles.show', $proposal->senderProfile) }}">
                                    {{ $proposal->senderProfile->full_name }}
                                </a>
                            </p>
                            <p class="mb-1"><strong>ID:</strong> {{ $proposal->senderProfile->user_code }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Recipient</h5>
                            <p class="mb-1">
                                <strong>Name:</strong> 
                                <a href="{{ route('profiles.show', $proposal->receiverProfile) }}">
                                    {{ $proposal->receiverProfile->full_name }}
                                </a>
                            </p>
                            <p class="mb-1"><strong>ID:</strong> {{ $proposal->receiverProfile->user_code }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Medium:</strong> {{ ucfirst($proposal->medium) }}</p>
                            <p><strong>Side:</strong> {{ ucfirst($proposal->side) }}</p>
                        </div>
                        <div class="col-md-6">
                            @php
                                $statusClass = [
                                    'pending' => 'bg-warning',
                                    'sent' => 'bg-info',
                                    'viewed' => 'bg-primary',
                                    'accepted' => 'bg-success',
                                    'rejected' => 'bg-danger',
                                    'expired' => 'bg-secondary'
                                ][$proposal->proposal_status] ?? 'bg-secondary';
                            @endphp
                            <p>
                                <strong>Status:</strong> 
                                <span class="badge {{ $statusClass }}">
                                    {{ ucfirst($proposal->proposal_status) }}
                                </span>
                            </p>
                            <p><strong>Sent At:</strong> {{ $proposal->sent_at->format('M d, Y h:i A') }}</p>
                            <p><strong>Sent By:</strong> {{ $proposal->sentBy->name }}</p>
                        </div>
                    </div>

                    @if($proposal->notes)
                        <div class="mb-4">
                            <h5>Notes</h5>
                            <div class="card">
                                <div class="card-body">
                                    {!! nl2br(e($proposal->notes)) !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    @can('update', $profile)
                        <div class="mt-4 pt-3 border-top">
                            <h5>Update Status</h5>
                            <form action="{{ route('profiles.proposals.status', ['profile' => $profile, 'proposal' => $proposal]) }}" 
                                  method="POST" class="row g-3">
                                @csrf
                                <div class="col-md-8">
                                    <select name="status" class="form-select" required>
                                        @foreach(ProfileDispatchProposal::getStatuses() as $value => $label)
                                            <option value="{{ $value }}" {{ $proposal->proposal_status === $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary w-100">Update Status</button>
                                </div>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
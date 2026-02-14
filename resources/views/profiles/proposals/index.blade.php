@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Proposals - {{ $profile->full_name }}</span>
                    <div>
                        <a href="{{ route('profiles.proposals.create', $profile) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> New Proposal
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

                    <ul class="nav nav-tabs" id="proposalTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="sent-tab" data-bs-toggle="tab" 
                                    data-bs-target="#sent" type="button" role="tab">
                                Sent Proposals ({{ $proposals->total() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="received-tab" data-bs-toggle="tab" 
                                    data-bs-target="#received" type="button" role="tab">
                                Received Proposals ({{ $receivedProposals->total() }})
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="proposalTabsContent">
                        <div class="tab-pane fade show active" id="sent" role="tabpanel">
                            @include('profiles.proposals._proposal_table', [
                                'proposals' => $proposals,
                                'type' => 'sent'
                            ])
                        </div>
                        <div class="tab-pane fade" id="received" role="tabpanel">
                            @include('profiles.proposals._proposal_table', [
                                'proposals' => $receivedProposals,
                                'type' => 'received'
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@if($proposals->isNotEmpty())
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    @if($type === 'sent')
                        <th>To</th>
                    @else
                        <th>From</th>
                    @endif
                    <th>Medium</th>
                    <th>Side</th>
                    <th>Status</th>
                    <th>Sent On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proposals as $proposal)
                    @php
                        $profile = $type === 'sent' ? $proposal->receiverProfile : $proposal->senderProfile;
                        $statusClass = [
                            'pending' => 'bg-warning',
                            'sent' => 'bg-info',
                            'viewed' => 'bg-primary',
                            'accepted' => 'bg-success',
                            'rejected' => 'bg-danger',
                            'expired' => 'bg-secondary'
                        ][$proposal->proposal_status] ?? 'bg-secondary';
                    @endphp
                    <tr>
                        <td>
                            <a href="{{ route('profiles.show', $profile) }}">
                                {{ $profile->full_name }}
                            </a>
                        </td>
                        <td>{{ ucfirst($proposal->medium) }}</td>
                        <td>{{ ucfirst($proposal->side) }}</td>
                        <td>
                            <span class="badge {{ $statusClass }}">
                                {{ ucfirst($proposal->proposal_status) }}
                            </span>
                        </td>
                        <td>{{ $proposal->sent_at->format('M d, Y h:i A') }}</td>
                        <td>
                            <a href="{{ route('profiles.proposals.show', ['profile' => $profile, 'proposal' => $proposal]) }}" 
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $proposals->withQueryString()->links() }}
    </div>
@else
    <div class="alert alert-info">
        No {{ $type }} proposals found.
    </div>
@endif
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Shortlisted Matches for {{ $profile->full_name }}</span>
                    <a href="{{ route('profiles.show', $profile) }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Profile
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <form action="{{ route('profiles.shortlists.store', $profile) }}" method="POST" class="row g-3 align-items-end">
                            @csrf
                            <div class="col-md-8">
                                <label for="shortlisted_profile_id" class="form-label">Search and Add Profile to Shortlist</label>
                                <select class="form-select" id="shortlisted_profile_id" name="shortlisted_profile_id" required>
                                    <option value="">Select a profile...</option>
                                    <!-- Will be populated by JavaScript -->
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add to Shortlist
                                </button>
                            </div>
                        </form>
                    </div>

                    @if($shortlists->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Profile ID</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Location</th>
                                        <th>Shortlisted On</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($shortlists as $shortlist)
                                        <tr>
                                            <td>{{ $shortlist->shortlistedProfile->user_code }}</td>
                                            <td>
                                                <a href="{{ route('profiles.show', $shortlist->shortlistedProfile) }}">
                                                    {{ $shortlist->shortlistedProfile->full_name }}
                                                </a>
                                            </td>
                                            <td>{{ $shortlist->shortlistedProfile->age ?? 'N/A' }}</td>
                                            <td>
                                                {{ $shortlist->shortlistedProfile->city ?? '' }}
                                                {{ $shortlist->shortlistedProfile->state ? ', ' . $shortlist->shortlistedProfile->state : '' }}
                                            </td>
                                            <td>{{ $shortlist->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <form action="{{ route('profiles.shortlists.destroy', ['profile' => $profile, 'shortlist' => $shortlist]) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Remove from shortlist?')">
                                                        <i class="fas fa-times"></i> Remove
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $shortlists->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            No profiles have been shortlisted yet. Use the form above to add profiles to the shortlist.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#shortlisted_profile_id').select2({
            placeholder: 'Search for a profile...',
            ajax: {
                url: '{{ route("api.profiles.search") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: data.current_page < data.last_page
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 2,
            templateResult: formatProfile,
            templateSelection: formatProfileSelection
        });

        function formatProfile(profile) {
            if (profile.loading) {
                return profile.text;
            }

            var $container = $(
                '<div class="select2-result-profile">' +
                    '<div class="fw-bold">' + profile.full_name + ' (' + profile.user_code + ')' + '</div>' +
                    '<div class="text-muted">' + 
                        (profile.age ? profile.age + ' years, ' : '') +
                        (profile.city || profile.state ? profile.city + (profile.city && profile.state ? ', ' : '') + (profile.state || '') : '') +
                    '</div>' +
                '</div>'
            );

            return $container;
        }

        function formatProfileSelection(profile) {
            if (!profile.id) {
                return profile.text;
            }
            return profile.full_name || profile.text;
        }
    });
</script>
@endpush
@endsection
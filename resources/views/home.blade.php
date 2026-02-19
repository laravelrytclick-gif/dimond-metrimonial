@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <div class="d-flex">
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="bi bi-download text-white-50"></i> Generate Report
            </a>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Profiles Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Profiles</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Profile::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Active Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\User::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meetings Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Meetings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\ProfileMeeting::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Proposals Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Proposals</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\ProfileDispatchProposal::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-envelope-paper fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Activities -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Activities</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical text-gray-400"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#">View All</a></li>
                            <li><a class="dropdown-item" href="#">Export</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="activity-feed">
                    @php
                        $activities = collect([]);
                        if (class_exists('Spatie\\Activitylog\\Models\\Activity')) {
                            try {
                                $activities = \Spatie\Activitylog\Models\Activity::query()
                                    ->latest()
                                    ->take(5)
                                    ->with('causer')
                                    ->get();
                            } catch (\Exception $e) {
                                // Silently fail and use empty collection
                                $activities = collect([]);
                            }
                        }
                    @endphp
                        @if($activities->count() > 0)
                            @foreach($activities as $activity)
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2">
                                            <i class="bi bi-activity text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <div class="fw-bold">{{ $activity->description }}</div>
                                        <div class="small text-muted">
                                            {{ $activity->causer->name ?? 'System' }} • {{ $activity->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                                <p class="mt-2 text-muted">No recent activities found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Quick Actions -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @can('create', App\Models\Profile::class)
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('profiles.create') }}" class="btn btn-outline-primary w-100 h-100 p-3 d-flex flex-column align-items-center">
                                <i class="bi bi-person-plus-fill mb-2" style="font-size: 1.5rem;"></i>
                                <span>Add New Profile</span>
                            </a>
                        </div>
                        @endcan
                        
                        @can('create', App\Models\User::class)
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('users.create') }}" class="btn btn-outline-success w-100 h-100 p-3 d-flex flex-column align-items-center">
                                <i class="bi bi-person-plus mb-2" style="font-size: 1.5rem;"></i>
                                <span>Add New User</span>
                            </a>
                        </div>
                        @endcan
                        
                        @can('create', App\Models\Testimonial::class)
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('testimonials.create') }}" class="btn btn-outline-info w-100 h-100 p-3 d-flex flex-column align-items-center">
                                <i class="bi bi-chat-square-quote mb-2" style="font-size: 1.5rem;"></i>
                                <span>Add Testimonial</span>
                            </a>
                        </div>
                        @endcan
                        
                        <div class="col-md-6 mb-3">
                            <a href="#" class="btn btn-outline-secondary w-100 h-100 p-3 d-flex flex-column align-items-center">
                                <i class="bi bi-gear mb-2" style="font-size: 1.5rem;"></i>
                                <span>Settings</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Activate the tab from URL hash or default to dashboard
    document.addEventListener('DOMContentLoaded', function() {
        // Get the tab from URL hash or default to dashboard
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab') || 'dashboard';
        
        // Show the tab
        const tabElement = document.getElementById(`${tab}-tab`);
        if (tabElement) {
            const tab = new bootstrap.Tab(tabElement);
            tab.show();
            
            // Update URL without page reload
            const url = new URL(window.location);
            url.searchParams.set('tab', tabElement.id.replace('-tab', ''));
            window.history.pushState({}, '', url);
        }
        
        // Handle tab clicks to update URL
        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
            tab.addEventListener('click', function (e) {
                const tabId = e.target.id.replace('-tab', '');
                const url = new URL(window.location);
                url.searchParams.set('tab', tabId);
                window.history.pushState({}, '', url);
            });
        });
    });
</script>
@endpush
@endsection

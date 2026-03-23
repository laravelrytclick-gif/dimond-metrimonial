<nav class="navbar navbar-expand navbar-light bg-white shadow-sm mb-4">
    <div class="container-fluid px-4">
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#secondaryNavbar" aria-controls="secondaryNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="navbar-collapse" id="secondaryNavbar">
            <ul class="navbar-nav flex-wrap me-auto">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('home') || request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}" 
                       style="{{ request()->is('home') || request()->is('/') ? 'background-color: #8B0000 !important; color: white !important;  border:#8B0000 !important' : 'color: #6b7280 !important;' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                
                <!-- User Management Dropdown -->
                @canany(['create', 'viewAny'], App\Models\User::class)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('users*') ? 'active' : '' }}" href="#" id="usersDropdown" role="button" data-bs-toggle="dropdown"
                       style="{{ request()->is('users*') ? 'background-color: #8B0000 !important; color: white !important;  border:#8B0000 !important' : 'color: #6b7280 !important;' }}">
                        <i class="bi bi-people"></i> Users
                    </a>
                    <ul class="dropdown-menu">
                        @can('create', App\Models\User::class)
                        <li><a class="dropdown-item" href="{{ route('users.create') }}"><i class="bi bi-person-plus me-2"></i>Create User</a></li>
                        @endcan
                        @can('viewAny', App\Models\User::class)
                        <li><a class="dropdown-item" href="{{ route('users.index') }}"><i class="bi bi-people me-2"></i>All Users</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                
                <!-- Profile Management Dropdown -->
                @canany(['create', 'viewAny'], App\Models\Profile::class)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('profiles*') ? 'active' : '' }}" href="#" id="profilesDropdown" role="button" data-bs-toggle="dropdown"
                       style="{{ request()->is('profiles*') ? 'background-color: #8B0000 !important; color: white !important;  border:#8B0000 !important' : 'color: #6b7280 !important;' }}">
                        <i class="bi bi-person-badge"></i> Profiles
                    </a>
                    <ul class="dropdown-menu">
                        @can('create', App\Models\Profile::class)
                        <li><a class="dropdown-item" href="{{ route('profiles.create') }}"><i class="bi bi-person-plus me-2"></i>Create Profile</a></li>
                        @endcan
                        @can('viewAny', App\Models\Profile::class)
                        <li><a class="dropdown-item" href="{{ route('profiles.index') }}"><i class="bi bi-people me-2"></i>All Profiles</a></li>
                        <li><a class="dropdown-item" href="{{ route('profiles.index', ['status' => 'hidden']) }}"><i class="bi bi-eye-slash me-2"></i>Hidden Profiles</a></li>
                        @endcan
                        <li><a class="dropdown-item" href="{{ route('profiles.search') }}"><i class="bi bi-search me-2"></i>Profile Search</a></li>
                        @can('create', App\Models\Profile::class)
                        <li><a class="dropdown-item" href="{{ route('profiles.bulk-upload') }}"><i class="bi bi-upload me-2"></i>Bulk Upload</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                
                <!-- Reports Dropdown -->
                @can('viewAny', App\Models\Profile::class)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('reports*') ? 'active' : '' }}" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown"
                       style="{{ request()->is('reports*') ? 'background-color: #8B0000 !important; color: white !important; border:#8B0000 !important' : 'color: #6b7280 !important;' }}">
                        <i class="bi bi-graph-up"></i> Reports
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('reports.daily') }}"><i class="bi bi-calendar-day me-2"></i>Daily Report</a></li>
                        <li><a class="dropdown-item" href="{{ route('reports.today-work') }}"><i class="bi bi-clock-history me-2"></i>Today Work History</a></li>
                    </ul>
                </li>
                @endcan
                
                <!-- RBAC Management -->
                @canany(['view users', 'view roles', 'view permissions'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('roles*') || request()->is('permissions*') ? 'active' : '' }}" href="#" id="rbacDropdown" role="button" data-bs-toggle="dropdown"
                       style="{{ request()->is('roles*') || request()->is('permissions*') ? 'background-color: #8B0000 !important; color: white !important; border:#8B0000 !important' : 'color: #6b7280 !important;' }}">
                        <i class="bi bi-shield-lock"></i> RBAC
                    </a>
                    <ul class="dropdown-menu">
                        @can('view users')
                        <li><a class="dropdown-item" href="{{ route('users.index') }}"><i class="bi bi-people me-2"></i>Users</a></li>
                        @endcan
                        @can('view roles')
                        <li><a class="dropdown-item" href="{{ route('roles.index') }}"><i class="bi bi-person-gear me-2"></i>Roles</a></li>
                        @endcan
                        @can('view permissions')
                        <li><a class="dropdown-item" href="{{ route('permissions.index') }}"><i class="bi bi-key me-2"></i>Permissions</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                
                <!-- More Options -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="moreDropdown" role="button" data-bs-toggle="dropdown"
                       style="color: #6b7280 !important;">
                        <i class="bi bi-three-dots"></i> More
                    </a>
                    <ul class="dropdown-menu">
                        @can('manage settings')
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                        @endcan
                        <li><a class="dropdown-item" href="#"><i class="bi bi-question-circle me-2"></i>Help</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-info-circle me-2"></i>About</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container-fluid px-4">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#secondaryNavbar" aria-controls="secondaryNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="secondaryNavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('home') || request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                
                @can('create', App\Models\User::class)
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('users/create') ? 'active' : '' }}" href="{{ route('users.create') }}">
                        <i class="bi bi-person-plus"></i> Create User
                    </a>
                </li>
                @endcan
                
                @can('viewAny', App\Models\User::class)
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('users') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <i class="bi bi-people"></i> All Users
                    </a>
                </li>
                @endcan
                
                @can('create', App\Models\Profile::class)
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('profiles/create') ? 'active' : '' }}" href="{{ route('profiles.create') }}">
                        <i class="bi bi-person-plus"></i> Create Profile
                    </a>
                </li>
                @endcan
                
                @can('viewAny', App\Models\Profile::class)
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('profiles') && !request()->has('status') ? 'active' : '' }}" href="{{ route('profiles.index') }}">
                        <i class="bi bi-people"></i> All Profiles
                    </a>
                </li>
                @endcan
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('profile-search') ? 'active' : '' }}" href="{{ route('profiles.search') }}">
                        <i class="bi bi-search"></i> Profile Search
                    </a>
                </li>
                
                @can('viewAny', App\Models\Profile::class)
                <li class="nav-item">
                    <a class="nav-link {{ request()->input('status') == 'hidden' ? 'active' : '' }}" href="{{ route('profiles.index', ['status' => 'hidden']) }}">
                        <i class="bi bi-eye-slash"></i> Hidden Profiles
                    </a>
                </li>
                @endcan
                
                <!-- RBAC Management Dropdown -->
                @canany(['view users', 'view roles', 'view permissions'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="rbacDropdown" role="button" data-bs-toggle="dropdown">
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
                
                <!-- Reports Dropdown -->
                @can('viewAny', App\Models\Profile::class)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-graph-up"></i> Reports
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('reports.daily') }}"><i class="bi bi-calendar-day me-2"></i>Daily Report</a></li>
                    </ul>
                </li>
                @endcan
                
                <!-- More Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="moreDropdown" role="button" data-bs-toggle="dropdown">
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

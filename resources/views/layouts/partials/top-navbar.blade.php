<nav class="navbar navbar-expand-lg navbar-dark top-navbar">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="bi bi-heart-fill me-2"></i>Diamond Matrimonial
        </a>
        
        <div class="d-flex align-items-center ms-auto">
            <!-- Fullscreen Toggle -->
            <button class="btn btn-link text-white me-2">
                <i class="bi bi-arrows-fullscreen"></i>
            </button>
            
            <!-- Dark Mode Toggle -->
            <button class="btn btn-link text-white me-3">
                <i class="bi bi-moon"></i>
            </button>
            
            <!-- User Profile -->
            <div class="dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                    <span class="me-2">{{ Auth::user()->name ?? 'Guest' }}</span>
                    <i class="bi bi-person-circle"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-dark top-navbar">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="bi bi-heart-fill me-2"></i>Diamond Matrimonial
        </a>
        
        <div class="d-flex align-items-center ms-auto">
            <!-- Fullscreen Toggle -->
            <button class="btn btn-link text-white me-2" id="fullscreenToggle" onclick="toggleFullscreen()">
                <i class="bi bi-arrows-fullscreen" id="fullscreenIcon"></i>
            </button>
            
            <!-- Dark Mode Toggle -->
            <button class="btn btn-link text-white me-3" id="darkModeToggle" onclick="toggleDarkMode()">
                <i class="bi bi-moon" id="themeIcon"></i>
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

<script>
// Check for saved theme preference or default to light mode
const currentTheme = localStorage.getItem('theme') || 'light';
document.documentElement.setAttribute('data-theme', currentTheme);

// Update icon based on current theme
function updateThemeIcon() {
    const themeIcon = document.getElementById('themeIcon');
    const currentTheme = document.documentElement.getAttribute('data-theme');
    
    if (currentTheme === 'dark') {
        themeIcon.classList.remove('bi-moon');
        themeIcon.classList.add('bi-sun');
    } else {
        themeIcon.classList.remove('bi-sun');
        themeIcon.classList.add('bi-moon');
    }
}

// Toggle between dark and light mode
function toggleDarkMode() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    // Set the new theme
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    
    // Update the icon
    updateThemeIcon();
    
    // Apply theme changes to body
    if (newTheme === 'dark') {
        document.body.classList.add('dark-mode');
        document.body.classList.remove('light-mode');
    } else {
        document.body.classList.add('light-mode');
        document.body.classList.remove('dark-mode');
    }
}

// Initialize theme icon on page load
document.addEventListener('DOMContentLoaded', function() {
    updateThemeIcon();
    
    // Apply initial theme classes
    const currentTheme = document.documentElement.getAttribute('data-theme');
    if (currentTheme === 'dark') {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.add('light-mode');
    }
    
    // Initialize fullscreen icon
    updateFullscreenIcon();
});

// Fullscreen functionality
function toggleFullscreen() {
    if (!document.fullscreenElement) {
        // Enter fullscreen
        document.documentElement.requestFullscreen().then(() => {
            updateFullscreenIcon();
        }).catch(err => {
            console.log(`Error attempting to enable fullscreen: ${err.message}`);
        });
    } else {
        // Exit fullscreen
        document.exitFullscreen().then(() => {
            updateFullscreenIcon();
        }).catch(err => {
            console.log(`Error attempting to exit fullscreen: ${err.message}`);
        });
    }
}

// Update fullscreen icon based on current state
function updateFullscreenIcon() {
    const fullscreenIcon = document.getElementById('fullscreenIcon');
    
    if (document.fullscreenElement) {
        // In fullscreen mode, show exit fullscreen icon
        fullscreenIcon.classList.remove('bi-arrows-fullscreen');
        fullscreenIcon.classList.add('bi-arrows-angle-contract');
    } else {
        // Not in fullscreen mode, show enter fullscreen icon
        fullscreenIcon.classList.remove('bi-arrows-angle-contract');
        fullscreenIcon.classList.add('bi-arrows-fullscreen');
    }
}

// Listen for fullscreen changes
document.addEventListener('fullscreenchange', updateFullscreenIcon);
document.addEventListener('webkitfullscreenchange', updateFullscreenIcon);
document.addEventListener('mozfullscreenchange', updateFullscreenIcon);
document.addEventListener('MSFullscreenChange', updateFullscreenIcon);
</script>

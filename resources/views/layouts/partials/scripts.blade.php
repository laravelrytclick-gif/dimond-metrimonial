<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom Scripts -->
<script>
    // Initialize tooltips and active states when the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Add active class to current navigation item
        document.querySelectorAll('.nav-link').forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
                
                // If this is a dropdown item, also mark the parent dropdown as active
                const parent = link.closest('.dropdown-menu');
                if (parent) {
                    const dropdown = link.closest('.dropdown');
                    if (dropdown) {
                        const toggle = dropdown.querySelector('.dropdown-toggle');
                        if (toggle) toggle.classList.add('active');
                    }
                }
            }
        });
        
        // Initialize any other plugins or custom scripts here
    });
    
    // Function to confirm before performing destructive actions
    function confirmAction(event, message = 'Are you sure you want to perform this action?') {
        if (!confirm(message)) {
            event.preventDefault();
            return false;
        }
        return true;
    }
</script>

<!-- Stack for additional scripts -->
@stack('scripts')

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Dimond Matrimonial') }} @yield('title', '')</title>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=Nunito:300,400,600,700" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    :root {
        --primary-color: #8B0000;
        --secondary-color: #f8f9fc;
        --accent-color: #36b9cc;
        --text-color: #5a5c69;
    }
    
    body {
        font-family: 'Nunito', sans-serif;
        color: var(--text-color);
        background-color: #f8f9fc;
    }
    
    .top-navbar {
        background-color: #8B0000;
        padding: 0.5rem 1rem;
    }
    
    .navbar-brand {
        font-weight: 700;
        color: white !important;
        font-size: 1.5rem;
        padding: 0.5rem 1rem;
    }
    
    /* Top navbar links only */
    .top-navbar .nav-link {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    /* Secondary navbar links black */
    .navbar-light .nav-link {
        color: #000 !important;
    }

    /* Active link in secondary navbar */
    .navbar-light .nav-link.active {
        color: #8B0000 !important;
        font-weight: 600;
    }

    /* Hover effect */
    .navbar-light .nav-link:hover {
        color: #8B0000 !important;
    }
    
    .nav-link {
        font-weight: 500;
        padding: 0.8rem 1.2rem;
        transition: all 0.3s;
        font-size: 0.9rem;
    }
    
    .nav-link i {
        margin-right: 0.3rem;
    }
    
    .nav-link:hover, .nav-link.active {
        background-color: #8B0000 !important;
        color: white !important;
        border-radius: 4px;
    }
    
    /* Force active navlink styling */
    .navbar-light .nav-link.active {
        background-color: #8B0000 !important;
        color: white !important;
        font-weight: 600;
    }
    
    /* Secondary navbar specific hover and active */
    .navbar-light .navbar-nav .nav-link:hover {
        background-color: #8B0000 !important;
        color: white !important;
        border-radius: 4px;
    }
    
    .navbar-light .navbar-nav .nav-link.active {
        background-color: #8B0000 !important;
        color: white !important;
        border-radius: 4px;
    }
    
    .navbar-toggler {
        border: none;
        padding: 0.5rem;
    }
    
    .navbar-toggler:focus {
        box-shadow: none;
        outline: none;
    }
    
    .card {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        margin-bottom: 1.5rem;
    }
    
    .card-header {
        background-color: white;
        border-bottom: 1px solid #e3e6f0;
        font-weight: 600;
        padding: 1rem 1.25rem;
    }
    
    .nav-tabs {
        border-bottom: 1px solid #e3e6f0;
        margin-bottom: 1.5rem;
    }
    
    .nav-tabs .nav-link {
        color: #6e707e !important;
        border: 1px solid transparent;
        border-top-left-radius: 0.35rem;
        border-top-right-radius: 0.35rem;
        padding: 0.75rem 1.25rem;
        font-weight: 600;
    }
    
    .nav-tabs .nav-link.active {
        color: #8B0000 !important;
        background-color: #fff;
        border-color: #e3e6f0 #e3e6f0 #fff;
    }
    
    .nav-tabs .nav-link:hover {
        border-color: #e3e6f0 #e3e6f0 #e3e6f0;
        color: #8B0000 !important;
    }
    
    .btn-primary {
        background-color: #8B0000;
        border-color: #8B0000;
    }
    
    .btn-primary:hover {
        background-color: #6B0000;
        border-color: #5B0000;
    }
    
    .welcome-card {
        border-left: 0.25rem solid #8B0000;
    }
</style>

@stack('styles')

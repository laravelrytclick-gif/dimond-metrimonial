<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.partials.head')
</head>
<body>
    <div id="app">
        <!-- Top Navigation Bar -->
        @include('layouts.partials.top-navbar')
        
        <!-- Secondary Navigation -->
        @include('layouts.partials.secondary-navbar')

        <!-- Main Content -->
        <main class="py-4 px-4">
            <div class="container-fluid">
                <!-- Alerts -->
                @include('layouts.partials.alerts')
                
                <!-- Page Content -->
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- Scripts -->
    @include('layouts.partials.scripts')
</body>
</html>

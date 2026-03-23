<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Testing bulk upload route...\n";
    
    // Test if the route exists
    $route = $app['router']->getRoutes()->getByName('profiles.bulk-upload');
    if ($route) {
        echo "Route found: " . $route->uri() . "\n";
        echo "Method: " . implode(', ', $route->methods()) . "\n";
        echo "Controller: " . $route->getAction('uses') . "\n";
    } else {
        echo "Route NOT found!\n";
    }
    
    // Test template route
    $templateRoute = $app['router']->getRoutes()->getByName('profiles.bulk-upload.template');
    if ($templateRoute) {
        echo "Template route found: " . $templateRoute->uri() . "\n";
    } else {
        echo "Template route NOT found!\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

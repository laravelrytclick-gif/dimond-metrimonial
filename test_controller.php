<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Testing prepareProfileData method...\n";
    
    $controller = new \App\Http\Controllers\Admin\ProfileController();
    
    // Test row data
    $testRow = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'gender' => 'Male',
        'email' => 'john@test.com',
        'phone' => '+1234567890',
        'dob' => '1990-01-15',
        'religion' => 'Hindu',
        'caste' => 'Brahmin'
    ];
    
    // Use reflection to access private method
    $reflection = new ReflectionClass($controller);
    $method = $reflection->getMethod('prepareProfileData');
    $method->setAccessible(true);
    
    $result = $method->invoke($controller, $testRow);
    
    echo "prepareProfileData test passed!\n";
    echo "Result keys: " . implode(', ', array_keys($result)) . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

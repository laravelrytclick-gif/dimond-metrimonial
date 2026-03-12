<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Testing Profile model...\n";
    $profile = new \App\Models\Profile();
    echo "Profile model loaded successfully\n";
    
    echo "Testing generateUserCode...\n";
    $userCode = \App\Models\Profile::generateUserCode();
    echo "User code generated: $userCode\n";
    
    echo "All tests passed!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

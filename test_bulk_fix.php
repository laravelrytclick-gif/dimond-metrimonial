<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Testing bulk upload with problematic CSV...\n";
    
    // Find or create a user
    $user = \App\Models\User::first();
    if (!$user) {
        echo "❌ No user found in database!\n";
        exit;
    }
    
    echo "✅ User found: " . $user->email . "\n";
    
    // Authenticate the user
    \Auth::login($user);
    echo "✅ User authenticated\n";
    
    // Create a problematic CSV content (with empty rows and mismatched columns)
    $csvContent = "first_name,last_name,gender,email,phone\n";
    $csvContent .= "John,Doe,Male,john.doe.test1@example.com,+1234567890\n";
    $csvContent .= "\n"; // Empty row
    $csvContent .= "Jane,Smith,Female,jane.smith.test2@example.com\n"; // Missing phone column
    $csvContent .= "Bob,Johnson,Male,bob.johnson.test@example.com,+9876543210,extra_column\n"; // Extra column
    $csvContent .= "Alice,Brown,Female,alice.brown.test@example.com,+5555555555\n";
    
    // Create temporary file
    $tempFile = tempnam(sys_get_temp_dir(), 'bulk_test_problematic_');
    file_put_contents($tempFile, $csvContent);
    
    echo "✅ Created problematic CSV file\n";
    
    // Create uploaded file object
    $uploadedFile = new \Illuminate\Http\UploadedFile(
        $tempFile,
        'test_problematic.csv',
        'text/csv',
        null,
        true
    );
    
    // Create POST request with file
    $request = \Illuminate\Http\Request::create('/profiles/bulk-upload', 'POST', [
        'skip_duplicates' => '1',
        'update_existing' => '0',
    ], [], [
        'file' => $uploadedFile
    ]);
    
    // Add CSRF token
    $request->headers->set('X-CSRF-TOKEN', csrf_token());
    
    // Add user to request
    $request->setUserResolver(function() use ($user) {
        return $user;
    });
    
    echo "✅ Created POST request with problematic file\n";
    
    // Dispatch the request
    $response = $app['router']->dispatch($request);
    
    echo "Status Code: " . $response->getStatusCode() . "\n";
    
    if ($response->getStatusCode() === 302) {
        echo "✅ Request handled gracefully with redirect\n";
        
        // Check for error messages in session
        $session = $request->getSession();
        if ($session->has('error')) {
            echo "✅ Error message found: " . $session->get('error') . "\n";
        }
        if ($session->has('success')) {
            echo "✅ Success message found: " . $session->get('success') . "\n";
        }
        if ($session->has('import_errors')) {
            echo "✅ Import errors found:\n";
            $errors = $session->get('import_errors');
            foreach ($errors as $error) {
                echo "  - " . $error . "\n";
            }
        }
    } else {
        echo "⚠️ Unexpected status code: " . $response->getStatusCode() . "\n";
    }
    
    // Clean up
    unlink($tempFile);
    echo "✅ Cleaned up temp file\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📁 File: " . $e->getFile() . "\n";
    echo "📍 Line: " . $e->getLine() . "\n";
}

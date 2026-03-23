<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Testing user permissions for bulk upload...\n";
    
    // Find or create a user
    $user = \App\Models\User::first();
    if (!$user) {
        echo "❌ No user found in database!\n";
        exit;
    }
    
    echo "✅ User found: " . $user->email . "\n";
    echo "User ID: " . $user->id . "\n";
    
    // Check user roles
    echo "User roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
    
    // Check user permissions
    echo "User permissions: " . $user->getAllPermissions()->pluck('name')->implode(', ') . "\n";
    
    // Test Profile::class creation permission
    $canCreateProfile = $user->can('create', \App\Models\Profile::class);
    echo "Can create profile: " . ($canCreateProfile ? '✅ YES' : '❌ NO') . "\n";
    
    // Test manage profiles permission
    $canManageProfiles = $user->can('manage profiles');
    echo "Can manage profiles: " . ($canManageProfiles ? '✅ YES' : '❌ NO') . "\n";
    
    // Test if user has RM role
    $hasRMRole = $user->hasRole('rm');
    echo "Has RM role: " . ($hasRMRole ? '✅ YES' : '❌ NO') . "\n";
    
    // Test the actual policy
    $policy = new \App\Policies\ProfilePolicy();
    $canCreate = $policy->create($user);
    echo "Policy allows create: " . ($canCreate ? '✅ YES' : '❌ NO') . "\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📁 File: " . $e->getFile() . "\n";
    echo "📍 Line: " . $e->getLine() . "\n";
}

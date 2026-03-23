<?php

use Illuminate\Http\Request;
use App\Services\ProfileNumberService;
use App\Models\Profile;
use Illuminate\Support\Facades\Route;

// Test profile number generation
Route::post('/api/test-profile-number', function (Request $request) {
    $isPaid = $request->get('is_paid', false);
    $profileNumber = ProfileNumberService::generateProfileNumber($isPaid);
    
    return response()->json([
        'profile_number' => $profileNumber,
        'type' => ProfileNumberService::getProfileNumberType($profileNumber),
        'is_valid' => ProfileNumberService::isValidProfileNumber($profileNumber)
    ]);
});

// Test convert to paid
Route::post('/api/test-convert-to-paid', function (Request $request) {
    // Find a free profile to test with
    $freeProfile = Profile::where('profile_number', 'like', '22%')->first();
    
    if (!$freeProfile) {
        return response()->json([
            'success' => false,
            'message' => 'No free profiles found to test with'
        ]);
    }
    
    $oldNumber = $freeProfile->profile_number;
    $success = ProfileNumberService::updateProfileNumber($freeProfile, 'paid');
    
    return response()->json([
        'success' => $success,
        'message' => $success ? 'Successfully converted to paid' : 'Failed to convert',
        'old_number' => $oldNumber,
        'new_number' => $success ? $freeProfile->fresh()->profile_number : null
    ]);
});

// Get profiles with numbers
Route::get('/api/profiles-with-numbers', function () {
    $profiles = Profile::select('id', 'first_name', 'last_name', 'profile_number')
        ->whereNotNull('profile_number')
        ->limit(10)
        ->get();
    
    return response()->json(['profiles' => $profiles]);
});

// Convert specific profile to paid
Route::post('/api/convert-profile/{profileId}', function ($profileId) {
    $profile = Profile::findOrFail($profileId);
    $success = ProfileNumberService::updateProfileNumber($profile, 'paid');
    
    return response()->json([
        'success' => $success,
        'message' => $success ? 'Profile converted to paid successfully' : 'Failed to convert profile'
    ]);
});

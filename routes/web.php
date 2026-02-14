<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfileStatusHistoryController;

// Authentication Routes
Auth::routes(['register' => false]);

// Home Route
Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Profile Routes
    Route::resource('profiles', ProfileController::class);
    
    // Nested Profile Resources
    Route::prefix('profiles/{profile}')->group(function () {
        // Family
        Route::resource('family', 'App\Http\Controllers\Admin\ProfileFamilyController')
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
            
        // Backgrounds
        Route::resource('backgrounds', 'App\Http\Controllers\Admin\ProfileBackgroundController')
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
            
        // Match Preferences
        Route::resource('match-preferences', 'App\Http\Controllers\Admin\ProfileMatchPreferenceController')
            ->only(['edit', 'update']);
            
        // Shortlists
        Route::resource('shortlists', 'App\Http\Controllers\Admin\ProfileShortlistController')
            ->only(['index', 'store', 'destroy']);
            
        // Call Logs
        Route::resource('calls', 'App\Http\Controllers\Admin\ProfileCallFollowupController')
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
            
        // Meetings
        Route::resource('meetings', 'App\Http\Controllers\Admin\ProfileMeetingController')
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
            
        // Proposals
        Route::resource('proposals', 'App\Http\Controllers\Admin\ProfileDispatchProposalController')
            ->only(['index', 'create', 'store', 'show']);
        Route::post('proposals/{proposal}/status', 'App\Http\Controllers\Admin\ProfileDispatchProposalController@updateStatus')
            ->name('profiles.proposals.status');
            
        // Status History
        Route::get('status-history', [ProfileStatusHistoryController::class, 'index'])
            ->name('profiles.status-history.index');
        Route::post('status-history', [ProfileStatusHistoryController::class, 'updateStatus'])
            ->name('profiles.status-history.update');
            
        // Finance
        Route::resource('finance', 'App\Http\Controllers\Admin\ProfileFinanceController')
            ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
            
        // Attachments
        Route::resource('attachments', 'App\Http\Controllers\Admin\ProfileAttachmentController')
            ->only(['index', 'store', 'show', 'destroy']);
    });
    
    // Role Management
    Route::middleware(['can:manage roles'])->group(function () {
        Route::resource('roles', RoleController::class);
    });
    
    // Permission Management
    Route::middleware(['can:manage permissions'])->group(function () {
        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    });
    
    // Testimonials
    Route::resource('testimonials', TestimonialController::class);
    
    // API Search
    Route::get('/profiles/search', function (\Illuminate\Http\Request $request) {
        return \App\Models\Profile::where('full_name', 'like', "%{$request->q}%")
            ->limit(10)
            ->get()
            ->map(function ($profile) {
                return [
                    'id' => $profile->id,
                    'text' => $profile->full_name,
                ];
            });
    })->name('api.profiles.search');
});
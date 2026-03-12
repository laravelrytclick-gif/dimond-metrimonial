
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\{
    UserController,
    RoleController,
    PermissionController,
    ProfileController,
    ProfileActionController,
    ProfileInteractionController,
    ProfileStatusHistoryController,
    ProfileFamilyController,
    ProfileBackgroundController,
    ProfileMatchPreferenceController,
    ProfileShortlistController,
    ProfileMeetingController,
    ProfileCallFollowupController,
    ProfileAttachmentController,
    ProfileFinanceController,
    ProfileDispatchProposalController,
    ReportController
};
use App\Http\Controllers\SearchProfileController;
use App\Http\Controllers\TestimonialController;
use App\Models\Profile;
use Illuminate\Http\Request;

// Authentication Routes
Auth::routes(['register' => false]);

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Profile Actions Routes
    Route::prefix('profiles/actions')->name('profiles.actions.')->group(function () {
        Route::post('toggle-visibility', [ProfileActionController::class, 'toggleVisibility'])->name('toggle-visibility');
        Route::post('convert-to-paid', [ProfileActionController::class, 'convertToPaid'])->name('convert-to-paid');
        Route::post('change-team-member', [ProfileActionController::class, 'changeTeamMember'])->name('change-team-member');
        Route::post('mark-visited', [ProfileActionController::class, 'markVisited'])->name('mark-visited');
        Route::post('find-match', [ProfileActionController::class, 'findMatch'])->name('find-match');
        Route::post('save-shortlist', [ProfileActionController::class, 'saveShortlist'])->name('save-shortlist');
        Route::post('toggle-hold', [ProfileActionController::class, 'toggleHold'])->name('toggle-hold');
        Route::post('add-interaction', [ProfileActionController::class, 'addInteraction'])->name('add-interaction');
        Route::get('get-interactions', [ProfileActionController::class, 'getInteractions'])->name('get-interactions');
        Route::post('add-followup', [ProfileActionController::class, 'addFollowup'])->name('add-followup');
        Route::post('add-feedback', [ProfileActionController::class, 'addFeedback'])->name('add-feedback');
        Route::post('toggle-done-active', [ProfileActionController::class, 'toggleDoneActive'])->name('toggle-done-active');
        Route::post('save-single-shortlist', [ProfileActionController::class, 'saveSingleShortlist'])->name('save-single-shortlist');
        Route::post('add-meeting', [ProfileActionController::class, 'addMeeting'])->name('add-meeting');
        Route::post('update-more-info', [ProfileActionController::class, 'updateMoreInfo'])->name('update-more-info');
        Route::post('update-match-making', [ProfileActionController::class, 'updateMatchMaking'])->name('update-match-making');
        Route::post('add-photo', [ProfileActionController::class, 'addPhoto'])->name('add-photo');
        Route::post('update-finance', [ProfileActionController::class, 'updateFinance'])->name('update-finance');
    });
    
    // Profile Management (accessible to all authenticated users with appropriate permissions)
    Route::get('profiles', [ProfileController::class, 'index'])
        ->name('profiles.index');
    
    // Bulk Upload Routes (must come before resource routes)
    Route::get('profiles/bulk-upload', [ProfileController::class, 'bulkUploadForm'])->name('profiles.bulk-upload');
    Route::post('profiles/bulk-upload', [ProfileController::class, 'bulkUpload'])->name('profiles.bulk-upload.store');
    Route::get('profiles/bulk-upload/template', [ProfileController::class, 'downloadTemplate'])->name('profiles.bulk-upload.template');
    
    // Profile Resource Routes
    Route::resource('profiles', ProfileController::class)
        ->except(['index', 'show'])
        ->middleware('can:create,App\Models\Profile');
    
    // Profile Show Route
    Route::get('profiles/{profile}', [ProfileController::class, 'show'])->name('profiles.show');
    
    // Profile Sub-Routes (Existing Controllers)
    Route::prefix('profiles/{profile}')->name('profiles.')->group(function () {
        // Interactions
        Route::get('interactions', [ProfileInteractionController::class, 'index'])->name('interactions.index');
        Route::get('interactions/create', [ProfileInteractionController::class, 'create'])->name('interactions.create');
        Route::post('interactions', [ProfileInteractionController::class, 'store'])->name('interactions.store');
        Route::get('interactions/{interaction}', [ProfileInteractionController::class, 'show'])->name('interactions.show');
        Route::get('interactions/{interaction}/edit', [ProfileInteractionController::class, 'edit'])->name('interactions.edit');
        Route::put('interactions/{interaction}', [ProfileInteractionController::class, 'update'])->name('interactions.update');
        Route::delete('interactions/{interaction}', [ProfileInteractionController::class, 'destroy'])->name('interactions.destroy');
        
        // Status History
        Route::get('status-history', [ProfileStatusHistoryController::class, 'index'])->name('status-history.index');
        Route::post('status-history', [ProfileStatusHistoryController::class, 'updateStatus'])->name('status-history.update');
        
        // Family
        Route::get('family', [ProfileFamilyController::class, 'index'])->name('family.index');
        Route::post('family', [ProfileFamilyController::class, 'store'])->name('family.store');
        
        // Background
        Route::get('background', [ProfileBackgroundController::class, 'index'])->name('background.index');
        Route::post('background', [ProfileBackgroundController::class, 'store'])->name('background.store');
        
        // Match Preferences
        Route::get('match-preferences/edit', [ProfileMatchPreferenceController::class, 'edit'])->name('match-preferences.edit');
        Route::put('match-preferences', [ProfileMatchPreferenceController::class, 'update'])->name('match-preferences.update');
        
        // Shortlists
        Route::get('shortlists', [ProfileShortlistController::class, 'index'])->name('shortlists.index');
        Route::get('shortlists/create', [ProfileShortlistController::class, 'create'])->name('shortlists.create');
        Route::post('shortlists', [ProfileShortlistController::class, 'store'])->name('shortlists.store');
        
        // Meetings
        Route::get('meetings', [ProfileMeetingController::class, 'index'])->name('meetings.index');
        Route::get('meetings/create', [ProfileMeetingController::class, 'create'])->name('meetings.create');
        Route::post('meetings', [ProfileMeetingController::class, 'store'])->name('meetings.store');
        
        // Call Followups
        Route::get('calls', [ProfileCallFollowupController::class, 'index'])->name('calls.index');
        Route::get('calls/create', [ProfileCallFollowupController::class, 'create'])->name('calls.create');
        Route::post('calls', [ProfileCallFollowupController::class, 'store'])->name('calls.store');
        
        // Attachments (Photos)
        Route::get('attachments', [ProfileAttachmentController::class, 'index'])->name('attachments.index');
        Route::post('attachments', [ProfileAttachmentController::class, 'store'])->name('attachments.store');
        Route::delete('attachments/{attachment}', [ProfileAttachmentController::class, 'destroy'])->name('attachments.destroy');
        
        // Finance
        Route::get('finance', [ProfileFinanceController::class, 'index'])->name('finance.index');
        Route::post('finance', [ProfileFinanceController::class, 'store'])->name('finance.store');
        Route::put('finance', [ProfileFinanceController::class, 'update'])->name('finance.update');
        
        // Dispatch Proposals
        Route::get('dispatch-proposals', [ProfileDispatchProposalController::class, 'index'])->name('dispatch-proposals.index');
        Route::get('dispatch-proposals/create', [ProfileDispatchProposalController::class, 'create'])->name('dispatch-proposals.create');
        Route::post('dispatch-proposals', [ProfileDispatchProposalController::class, 'store'])->name('dispatch-proposals.store');
    });
    
    // Profile Search Routes
    Route::get('profile-search', [SearchProfileController::class, 'index'])->name('profiles.search');
    Route::get('profiles/search/results', [SearchProfileController::class, 'search'])->name('profiles.search.results');
    
    // Reports Routes
    Route::get('reports/daily', [ReportController::class, 'dailyReport'])->name('reports.daily');
    Route::get('reports/daily/export', [ReportController::class, 'exportDailyReport'])->name('reports.daily.export');
    Route::get('reports/today-work', [ReportController::class, 'todayWorkHistory'])->name('reports.today-work');
    
    // Make profile show route accessible without admin role
    Route::get('profiles/{profile}', [ProfileController::class, 'show'])
        ->name('profiles.show')
        ->middleware('can:view,profile');
      // User Management
    Route::resource('users', UserController::class);
    
    // Permission Management
    Route::resource('permissions', PermissionController::class)->names('admin.permissions');
    
    // Role Management
    Route::resource('roles', RoleController::class);
    
    // Permission Management
    Route::get('permissions', [PermissionController::class, 'index'])
        ->name('permissions.index');
    
    // Profile Management
    Route::resource('admin/profiles', ProfileController::class)
        ->except(['index', 'show']);
    
    // Profile Relations
    Route::prefix('profiles/{profile}')->name('profiles.')->group(function () {
        // Status History
      Route::get('status-history', [ProfileStatusHistoryController::class, 'index'])
        ->name('status-history.index');

    Route::post('status-history', [ProfileStatusHistoryController::class, 'updateStatus'])
        ->name('status-history.update');

    Route::resource('family', ProfileFamilyController::class)->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy'
    ]);
        
    Route::resource('backgrounds', ProfileBackgroundController::class)->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy'
    ]);
        
    Route::resource('shortlists', ProfileShortlistController::class)->only([
        'index', 'store', 'destroy'
    ]);
        
        Route::resource('meetings', ProfileMeetingController::class)->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]);
        
        Route::resource('calls', ProfileCallFollowupController::class)->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]);
        
        Route::resource('attachments', ProfileAttachmentController::class)->only([
            'index', 'store', 'show', 'destroy'
        ]);
        
        Route::resource('finance', ProfileFinanceController::class)->only([
            'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
        ]);
        
        Route::resource('proposals', ProfileDispatchProposalController::class)->only([
            'index', 'create', 'store', 'show'
        ]);
        
        Route::post('proposals/{proposal}/status', [ProfileDispatchProposalController::class, 'updateStatus'])
            ->name('proposals.status');
    });

    // Admin Routes Group
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        // User Management
        Route::resource('users', UserController::class);
        
        // Role Management
        Route::resource('roles', RoleController::class);
        
        // Permission Management
        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
            Route::resource('profiles', ProfileController::class)->except(['index', 'show']);
    });

    // Profile Search API
    Route::get('/profiles/search', function (Request $request) {
        return Profile::where('full_name', 'like', "%{$request->q}%")
            ->limit(10)
            ->get()
            ->map(function ($profile) {
                return [
                    'id' => $profile->id,
                    'text' => $profile->full_name,
                ];
            });
    })->name('api.profiles.search');

    // Testimonials
    Route::resource('testimonials', TestimonialController::class);
    
    Route::post('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])
        ->name('testimonials.approve')
        ->middleware('can:approve testimonials');
        
    Route::post('testimonials/{testimonial}/feature', [TestimonialController::class, 'feature'])
        ->name('testimonials.feature')
        ->middleware('can:feature testimonials');
});

// Fallback home route
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Include test routes (remove in production)
if (app()->environment('local')) {
    require base_path('routes/test_api.php');
}

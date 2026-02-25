
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\{
    UserController,
    RoleController,
    PermissionController,
    ProfileController,
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
    // Profile Management (accessible to all authenticated users with appropriate permissions)
    Route::get('profiles', [ProfileController::class, 'index'])
        ->name('profiles.index')
        ->middleware('can:viewAny,App\Models\Profile');
        
        
    Route::resource('profiles', ProfileController::class)
        ->except(['index', 'show'])
        ->middleware('can:create,App\Models\Profile');
    
    // Profile Search Routes
    Route::get('profile-search', [SearchProfileController::class, 'index'])->name('profiles.search');
    Route::get('profiles/search/results', [SearchProfileController::class, 'search'])->name('profiles.search.results');
    
    // Bulk Upload Routes
    Route::get('profiles/bulk-upload', [ProfileController::class, 'bulkUploadForm'])->name('profiles.bulk-upload.form');
    Route::post('profiles/bulk-upload', [ProfileController::class, 'bulkUpload'])->name('profiles.bulk-upload.store');
    Route::get('profiles/bulk-upload/template', [ProfileController::class, 'downloadTemplate'])->name('profiles.bulk-upload.template');
    
    // Reports Routes
    Route::get('reports/daily', [ReportController::class, 'dailyReport'])->name('reports.daily');
    Route::get('reports/daily/export', [ReportController::class, 'exportDailyReport'])->name('reports.daily.export');
    
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
        
        Route::resource('match-preferences', ProfileMatchPreferenceController::class)->only([
            'edit', 'update'
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

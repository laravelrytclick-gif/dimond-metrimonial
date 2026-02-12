<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;   
use App\Http\Controllers\Admin\ProfileController;    

use App\Http\Controllers\TestimonialController;

// Authentication Routes
Auth::routes(['register' => true]);

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Admin Routes
Route::middleware(['auth'])->group(function () {
    // User Management
    Route::middleware(['can:manage users'])->group(function () {
        Route::resource('users', UserController::class);
    });
    // In routes/web.php
Route::resource('profiles', ProfileController::class)->middleware('auth');

// Inside the auth middleware group
Route::resource('profiles.family', 'App\Http\Controllers\Admin\ProfileFamilyController')
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    // Role Management
    Route::middleware(['can:manage roles'])->group(function () {
        Route::resource('roles', RoleController::class);
    });
    
// Inside the auth middleware group
Route::resource('profiles.backgrounds', 'App\Http\Controllers\Admin\ProfileBackgroundController')
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    // Permission Management
    Route::middleware(['can:manage permissions'])->group(function () {
        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    });
// Inside the auth middleware group
Route::resource('profiles.match-preferences', 'App\Http\Controllers\Admin\ProfileMatchPreferenceController')
    ->only(['edit', 'update']);

    // Inside the auth middleware group
Route::resource('profiles.shortlists', 'App\Http\Controllers\Admin\ProfileShortlistController')
    ->only(['index', 'store', 'destroy']);
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

    // Testimonials
    Route::resource('testimonials', TestimonialController::class);
    
    Route::middleware(['can:approve testimonials'])->group(function () {
        Route::post('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('testimonials.approve');
    });
    
    Route::middleware(['can:feature testimonials'])->group(function () {
        Route::post('testimonials/{testimonial}/feature', [TestimonialController::class, 'feature'])->name('testimonials.feature');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
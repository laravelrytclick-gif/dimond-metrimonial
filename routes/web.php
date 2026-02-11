<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;    
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
    
    Route::middleware(['can:approve testimonials'])->group(function () {
        Route::post('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('testimonials.approve');
    });
    
    Route::middleware(['can:feature testimonials'])->group(function () {
        Route::post('testimonials/{testimonial}/feature', [TestimonialController::class, 'feature'])->name('testimonials.feature');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
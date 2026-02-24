<?php

use App\Http\Controllers\Api\ProfileSearchController;
use App\Http\Controllers\SearchProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Add this route inside the auth middleware
    Route::get('/profiles/search', [ProfileSearchController::class, 'search'])
        ->name('api.profiles.search');
        
    // Profile search API
    Route::get('/search/profiles', [SearchProfileController::class, 'apiSearch']);
});
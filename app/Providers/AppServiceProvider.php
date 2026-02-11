<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // This ensures that the permissions are properly registered with Laravel's Gate
        try {
            // Only register the Gate if the permissions table exists
            if (app()->runningInConsole()) {
                return;
            }

            // Register a super-admin role that bypasses all permissions
            Gate::before(function (User $user, $ability) {
                return $user->hasRole('super-admin') ? true : null;
            });
        } catch (\Exception $e) {
            // Ignore any database-related exceptions during boot
        }
    }
}

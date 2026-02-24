<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Profile;
use App\Policies\RolePolicy;
use App\Policies\PermissionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define gates for specific permissions
        $permissions = [
            'view users', 'create users', 'edit users', 'delete users',
            'view roles', 'create roles', 'edit roles', 'delete roles',
            'view permissions', 'create permissions', 'edit permissions', 'delete permissions',
        ];

        foreach ($permissions as $permission) {
            Gate::define($permission, function (User $user) use ($permission) {
                return $user->hasPermissionTo($permission);
            });
        }

        // Profile policy
        Gate::define('viewAny', function (User $user) {
            return $user->can('view profiles');
        });

        Gate::define('view', function (User $user, Profile $profile) {
            return $user->can('view profiles') || $user->id === $profile->user_id;
        });

        Gate::define('create', function (User $user) {
            return $user->can('create profiles');
        });

        Gate::define('update', function (User $user, Profile $profile) {
            return $user->can('edit profiles') || $user->id === $profile->user_id;
        });

        Gate::define('delete', function (User $user, Profile $profile) {
            return $user->can('delete profiles');
        });
    }
}

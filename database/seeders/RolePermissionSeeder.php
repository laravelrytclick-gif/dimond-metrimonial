<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage profiles',
            'view profiles',
            'create profiles',
            'edit profiles',
            'delete profiles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign created permissions
        $role = Role::firstOrCreate(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::firstOrCreate(['name' => 'rm']);
        $role->givePermissionTo([
            'view profiles',
            'create profiles',
            'edit profiles',
        ]);

        // Assign admin role to first user
        $user = \App\Models\User::first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
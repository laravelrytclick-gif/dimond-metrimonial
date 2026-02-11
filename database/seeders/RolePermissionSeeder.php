<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view testimonials',
            'create testimonials',
            'edit testimonials',
            'delete testimonials',
            'approve testimonials',
            'feature testimonials',
            'manage users',
            'manage roles',
            'manage permissions'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $rmRole = Role::firstOrCreate(['name' => 'rm']);

        // Assign permissions to roles
        $adminRole->syncPermissions(Permission::all());

        $rmRole->syncPermissions([
            'view testimonials',
            'create testimonials',
            'edit testimonials',
            'delete testimonials'
        ]);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_active' => true
            ]
        );

        $admin->assignRole('admin');

        // Create RM user
        $rm = User::firstOrCreate(
            ['email' => 'rm@example.com'],
            [
                'name' => 'Relationship Manager',
                'password' => Hash::make('password'),
                'is_active' => true
            ]
        );

        $rm->assignRole('rm');
    }
}

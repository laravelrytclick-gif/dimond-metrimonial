<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles and permissions
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // Create admin user if not exists
        if (!User::where('email', 'admin@example.com')->exists()) {
            $admin = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]);
            $admin->assignRole('admin');
        }

        // Create RM user if not exists
        if (!User::where('email', 'rm@example.com')->exists()) {
            $rm = User::create([
                'name' => 'Relationship Manager',
                'email' => 'rm@example.com',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]);
            $rm->assignRole('rm');
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;

class ProfileNumberSeeder extends Seeder
{
    public function run()
    {
        // Generate profile numbers for existing profiles that don't have them
        $profiles = Profile::whereNull('profile_number')->get();
        
        foreach ($profiles as $index => $profile) {
            $profileNumber = '22' . str_pad($index + 1, 6, '0', STR_PAD_LEFT);
            $profile->update(['profile_number' => $profileNumber]);
        }
        
        $this->command->info('Generated profile numbers for ' . $profiles->count() . ' profiles.');
    }
}

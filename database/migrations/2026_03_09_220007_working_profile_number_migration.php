<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // First check if columns exist and add them if they don't
        if (!Schema::hasColumn('profiles', 'membership_type')) {
            Schema::table('profiles', function (Blueprint $table) {
                $table->string('membership_type', 20)->default('free')->after('status');
            });
        }
        
        if (!Schema::hasColumn('profiles', 'payment_date')) {
            Schema::table('profiles', function (Blueprint $table) {
                $table->timestamp('payment_date')->nullable()->after('registration_date');
            });
        }
        
        // Generate profile numbers for existing records
        $profiles = DB::table('profiles')->get();
        foreach ($profiles as $index => $profile) {
            $profileNumber = '22' . str_pad($index + 1, 6, '0', STR_PAD_LEFT);
            DB::table('profiles')
                ->where('id', $profile->id)
                ->update(['profile_number' => $profileNumber]);
        }
        
        // Make profile_number required and add unique constraint
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('profile_number', 8)->nullable(false)->change();
            $table->unique('profile_number');
        });
    }

    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropUnique('profiles_profile_number_unique');
            $table->dropColumn(['profile_number', 'membership_type', 'payment_date']);
        });
    }
};

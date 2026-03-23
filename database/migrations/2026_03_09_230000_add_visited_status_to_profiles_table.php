<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->boolean('has_been_visited')->default(false)->after('payment_date');
            $table->timestamp('last_visited_date')->nullable()->after('has_been_visited');
        });
    }

    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['has_been_visited', 'last_visited_date']);
        });
    }
};

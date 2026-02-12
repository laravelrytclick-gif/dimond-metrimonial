<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profile_match_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->json('preferences')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
            
            // Ensure one-to-one relationship with profile
            $table->unique('profile_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('profile_match_preferences');
    }
};
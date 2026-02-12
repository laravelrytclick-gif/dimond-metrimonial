<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profile_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['education', 'profession']);
            $table->string('title', 120);
            $table->string('organization', 120);
            $table->string('specialization', 120)->nullable();
            $table->string('location', 120)->nullable();
            $table->year('year_from');
            $table->year('year_to')->nullable();
            $table->string('income', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profile_backgrounds');
    }
};
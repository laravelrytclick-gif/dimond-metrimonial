<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profile_families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->enum('member_type', ['father', 'mother', 'brother', 'sister', 'other']);
            $table->string('name', 120);
            $table->integer('age')->nullable();
            $table->string('occupation', 120)->nullable();
            $table->string('marital_status', 50)->nullable();
            $table->boolean('living_with_candidate')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profile_families');
    }
};
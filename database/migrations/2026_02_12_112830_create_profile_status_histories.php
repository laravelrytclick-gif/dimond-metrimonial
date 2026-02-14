<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profile_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('old_status', 30);
            $table->string('new_status', 30);
            $table->foreignId('changed_by')->constrained('users')->onDelete('cascade');
            $table->text('reason')->nullable();
            $table->timestamp('changed_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profile_status_histories');
    }
};
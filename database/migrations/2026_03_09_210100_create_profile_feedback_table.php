<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profile_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->between(1, 5);
            $table->text('feedback');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index(['profile_id', 'rating']);
            $table->index(['created_by']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('profile_feedback');
    }
};

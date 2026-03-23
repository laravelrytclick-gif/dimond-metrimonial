<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profile_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('interaction_type');
            $table->text('notes');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('interaction_date')->nullable();
            $table->string('status')->default('pending');
            $table->string('priority')->default('medium');
            $table->timestamps();
            
            $table->index(['profile_id', 'interaction_date']);
            $table->index(['created_by', 'interaction_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('profile_interactions');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profile_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('matched_profile_id')->nullable()->constrained('profiles')->onDelete('set null');
            $table->foreignId('scheduled_by')->constrained('users')->onDelete('cascade');
            $table->enum('meeting_type', ['family', 'individual']);
            $table->date('meeting_date');
            $table->time('meeting_time');
            $table->string('venue', 120);
            $table->json('attendees')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            $table->string('outcome', 100)->nullable();
            $table->date('next_action_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profile_meetings');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profile_dispatch_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_profile_id')->constrained('profiles')->onDelete('cascade');
            $table->foreignId('receiver_profile_id')->constrained('profiles')->onDelete('cascade');
            $table->foreignId('sent_by')->constrained('users')->onDelete('cascade');
            $table->enum('medium', ['email', 'whatsapp', 'manual']);
            $table->enum('side', ['single', 'both']);
            $table->string('proposal_status', 50);
            $table->text('notes')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profile_dispatch_proposals');
    }
};
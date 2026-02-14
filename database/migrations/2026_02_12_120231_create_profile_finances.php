<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profile_finances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('package_name', 120);
            $table->decimal('amount_paid', 10, 2);
            $table->date('payment_date');
            $table->enum('payment_mode', ['Cash', 'UPI', 'Bank']);
            $table->date('expiry_date');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profile_finances');
    }
};
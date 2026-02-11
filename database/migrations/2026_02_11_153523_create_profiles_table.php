<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('user_code')->unique();
            $table->string('full_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->date('dob')->nullable();
            $table->time('birth_time')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('religion')->nullable();
            $table->string('caste')->nullable();
            $table->string('sub_caste')->nullable();
            $table->string('gotra')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('complexion')->nullable();
            $table->string('blood_group')->nullable();
            $table->enum('eating_habit', ['Vegetarian', 'Non-Vegetarian', 'Eggetarian'])->nullable();
            $table->enum('smoking_habit', ['No', 'Occasionally', 'Regularly'])->nullable();
            $table->enum('drinking_habit', ['No', 'Occasionally', 'Regularly'])->nullable();
            $table->string('phone')->nullable();
            $table->string('alternate_phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('highest_education')->nullable();
            $table->string('occupation')->nullable();
            $table->decimal('income', 12, 2)->nullable();
            $table->string('work_location')->nullable();
            $table->foreignId('rm_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('marital_status', ['Unmarried', 'Divorced', 'Widowed', 'Separated'])->nullable();
            $table->string('profile_photo_path')->nullable();
            $table->date('registration_date');
            $table->enum('status', ['Active', 'Inactive', 'On Hold'])->default('Active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('country')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('apple_id')->nullable();
            $table->integer('otp')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->enum('role_id', ['administrator',"user","guest_artist","studio"])->nullable()->default("user");
            $table->enum('user_type', ['administrator',"user","guest_artist","studio"])->nullable()->default("user");
            $table->string('job')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('company')->nullable();
            $table->string('college')->nullable();
            $table->string('bio')->nullable();
            $table->decimal('longitude', 10, 6)->nullable()->default(67.001137); // Adjust precision and scale as needed
            $table->decimal('latitude', 10, 6)->nullable()->default(24.860735);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};

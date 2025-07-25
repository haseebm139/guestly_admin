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
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('studio_name')->nullable();
            $table->string('email')->unique();
            $table->string('business_email')->nullable();
            $table->string('password')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->longText('bio')->nullable();
            $table->string('language')->nullable()->default('en');
            $table->string('website_url')->nullable();
            $table->string('phone')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('front_doc')->nullable();
            $table->string('back_doc')->nullable();
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('apple_id')->nullable();
            $table->string('verification_type')->nullable();

            $table->string('avatar')->nullable();
            $table->string('document_front')->nullable();
            $table->string('document_back')->nullable();
            $table->string('studio_logo')->nullable();
            $table->string('studio_cover')->nullable();

            $table->integer('guest_spots')->nullable();
            $table->integer('studio_type')->nullable();
            $table->integer('otp')->nullable();

            $table->enum('email_verified', ['0', '1'])->nullable()->default('0');   // 1 = active, 0 = inactive
            $table->enum('role_id', ['administrator',"user","artist","studio"])->nullable()->default("user");
            $table->enum('user_type', ['administrator',"user","artist","studio"])->nullable()->default("user");
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->enum('verification_status', ['0', '1', '2'])->default('0');
            $table->enum('require_portfolio', ['0', '1'])->default('0');
            $table->enum('accept_bookings', ['0', '1'])->default('0');
            $table->enum('preferred_duration', ['0', '1'])->default('0');

            $table->decimal('longitude', 10, 6)->nullable()->default(67.001137); // Adjust precision and scale as needed
            $table->decimal('latitude', 10, 6)->nullable()->default(24.860735);
            $table->date('date_of_birth')->nullable();
            $table->timestamp('email_verified_at')->nullable();
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

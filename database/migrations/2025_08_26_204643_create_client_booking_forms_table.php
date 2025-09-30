<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_booking_forms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('artist_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('studio_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('client_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('custom_form_id')->nullable()->constrained('custom_forms')->onDelete('cascade');
            $table->date('booking_date')->nullable();
            $table->time('booking_time')->nullable();
            $table->string('booking_url')->nullable();

            $table->string('shared_code')->unique(); // instead of full link

            $table->enum('status', ['creating', 'pending','approved_pending_payment' ,'submitted', 'approve', 'decline'])
                ->default('creating');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_booking_forms');
    }
};

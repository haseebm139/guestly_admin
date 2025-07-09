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
        Schema::create('spot_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('studio_id')->constrained('users')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_tour_requested')->default(false);
            $table->json('group_artists')->nullable();
            $table->text('message')->nullable();
            $table->json('portfolio_files')->nullable(); // or separate table
            $table->enum('booking_type', ['solo', 'group'])->default('solo');
            $table->enum('status', ['pending', 'approved', 'rejected', 'rescheduled'])->default('pending');
            $table->enum('rescheduled_by', ['artist', 'studio'])->nullable();
            $table->text('reschedule_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spot_bookings');
    }
};

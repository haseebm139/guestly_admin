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
        Schema::table('client_booking_forms', function (Blueprint $table) {
            $table->foreignId('spot_booking_id')
                  ->nullable()
                  ->constrained('spot_bookings')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_booking_forms', function (Blueprint $table) {
            $table->dropForeign(['spot_booking_id']);
            $table->dropColumn('spot_booking_id');
        });
    }
};

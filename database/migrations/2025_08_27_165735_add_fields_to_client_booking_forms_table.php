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
            $table->integer('duration')->nullable()->default(0);
            $table->double('hourly_rate')->nullable()->default(0.00);
            $table->double('deposit')->nullable()->default(0.00);
            $table->double('estimate_start')->nullable()->default(0.00);
            $table->double('estimate_end')->nullable()->default(0.00);
            $table->longText('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_booking_forms', function (Blueprint $table) {
            $table->dropColumn(['duration', 'hourly_rate', 'deposit', 'estimate_start', 'estimate_end', 'notes']);
        });
    }
};

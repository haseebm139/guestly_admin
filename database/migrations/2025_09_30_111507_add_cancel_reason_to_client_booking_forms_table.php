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
            $table->longText('cancel_reason')->nullable()->after('notes');
            // $table->decimal('price', 10, 2)->nullable()->after('cancel_reason');
            DB::statement("ALTER TABLE client_booking_forms MODIFY COLUMN status 
                ENUM('creating', 'pending', 'submitted', 'approve', 'decline', 'approved_pending_payment')
                NOT NULL DEFAULT 'creating'");
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_booking_forms', function (Blueprint $table) {
            $table->dropColumn(['cancel_reason']); 
            DB::statement("ALTER TABLE client_booking_forms MODIFY COLUMN status 
                ENUM('creating', 'pending', 'submitted', 'approve', 'decline')
                NOT NULL DEFAULT 'creating'");
            });
    }
};

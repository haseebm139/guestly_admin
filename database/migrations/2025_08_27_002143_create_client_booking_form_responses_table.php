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
        Schema::create('client_booking_form_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_booking_form_id')
                  ->constrained('client_booking_forms')
                  ->onDelete('cascade');
            $table->foreignId('custom_form_field_id')
                  ->constrained('custom_form_fields')
                  ->onDelete('cascade');
            $table->text('value')->nullable(); // store the client’s input
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_booking_form_responses');
    }
};

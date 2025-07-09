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
        Schema::create('studio_station_amenity', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('station_amenity_id')->references('id')->on('station_amenities')->onDelete('cascade'); // Reference the specific table name

            $table->primary(['user_id', 'station_amenity_id']);
            // $table->timestamps(); // Optional for pivot tables
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studio_station_amenity');
    }
};

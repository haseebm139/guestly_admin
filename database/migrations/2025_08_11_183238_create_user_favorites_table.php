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
        Schema::create('user_favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artist_id'); // artisan user
            $table->unsignedBigInteger('studio_id'); // studio user
            $table->timestamps();

            $table->unique(['artist_id', 'studio_id']);

            $table->foreign('artist_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('studio_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_favorites');
    }
};

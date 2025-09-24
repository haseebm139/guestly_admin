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
        Schema::create('flash_tattoos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artist_id'); // tattoo belongs to an artist (user_id)
            $table->string('title')->nullable();
            // $table->string('size')->nullable(); // Small (2x2), Medium (4x4), etc
            $table->boolean('repeatable')->default(true);
            // $table->decimal('price', 10, 2);
            $table->string('image')->nullable(); // tattoo image path
            $table->longText('description')->nullable();
            $table->timestamps();

            $table->foreign('artist_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flash_tattoos');
    }
};

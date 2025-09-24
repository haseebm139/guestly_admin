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
        Schema::create('flash_tattoo_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flash_tattoo_id');
            $table->string('size'); // e.g., "Small 2x2", "Medium 4x4"
            $table->integer('duration')->nullable(); // in minutes or hours
            $table->decimal('price', 10, 2);
            $table->timestamps();

            $table->foreign('flash_tattoo_id')
                ->references('id')
                ->on('flash_tattoos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flash_tattoo_options');
    }
};

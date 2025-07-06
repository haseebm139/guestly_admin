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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->decimal('m_price', 8, 2)->nullable();
            $table->decimal('y_price', 8, 2)->nullable();
            $table->integer('validity_value')->nullable();
            $table->enum('validity_unit', ['days', 'weeks', 'months', 'years'])->nullable();
            $table->integer('duration_days_m')->default(30);
            $table->integer('duration_days_y')->default(365);
            $table->enum('status', ['0', '1'])->nullable()->default('1');   // 1 = active, 0 = inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

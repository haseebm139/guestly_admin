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
        Schema::create('custom_form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_form_id')->constrained('custom_forms')->onDelete('cascade');
            $table->string('label'); // e.g. "Full Name"
            $table->enum('type', ['text', 'textarea', 'dropdown', 'multi_select']);
            $table->json('options')->nullable(); // for dropdown/multiselect
            $table->tinyInteger('is_required')->default(1);
            $table->integer('order')->default(0); // for sorting
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_form_fields');
    }
};

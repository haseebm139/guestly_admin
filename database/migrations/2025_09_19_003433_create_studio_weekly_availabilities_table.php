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
        Schema::create('studio_weekly_availabilities', function (Blueprint $table) {
             
                $table->id();
                $table->unsignedBigInteger('studio_id'); 
                $table->enum('day_of_week', [
                    'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday',
                ]);
                $table->boolean('is_available')->default(true);
                $table->longText('reason')->nullable(); 
                
                $table->time('open_time')->nullable();
                $table->time('close_time')->nullable();
                $table->timestamps();

                $table->foreign('studio_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
             
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studio_weekly_availabilities');
    }
};

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
        Schema::create('block_stations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('studio_id')->nullable();     
            $table->unsignedBigInteger('station_number')->nullable();    
            $table->date('start_date')->nullable();                  
            $table->date('end_date')->nullable();                   
            $table->longText('reason')->nullable(); 
            $table->enum('status', ['active', 'inactive'])->default('active'); // 🆕      
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('block_stations');
    }
};

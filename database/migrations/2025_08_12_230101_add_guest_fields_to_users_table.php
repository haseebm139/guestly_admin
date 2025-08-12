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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('guest_to_choose', ['0', '1'])->nullable()->default('0');
            $table->string('guest_policy')->nullable();
            $table->enum('commission_type', ['0','1','2'])->nullable()->default('0')->comment('0 = fixed, 1 = percentage, 2 = custom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};

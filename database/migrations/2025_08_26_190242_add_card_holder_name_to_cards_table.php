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
        Schema::table('cards', function (Blueprint $table) {
            $table->string('card_holder_name')->nullable()->after('user_id');
            $table->enum('payment_type', ['visa', 'master','paypal','stripe'])->nullable();
            $table->boolean('is_selected')->nullable()->default(false);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn('card_holder_name');
            $table->dropColumn('payment_type');
            $table->dropColumn('is_selected');
        });
    }
};

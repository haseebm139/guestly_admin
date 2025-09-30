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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_booking_form_id')->constrained()->cascadeOnDelete();
			$table->foreignId('client_id')->nullable()->constrained('users')->nullOnDelete();
			$table->foreignId('artist_id')->nullable()->constrained('users')->nullOnDelete();
			$table->bigInteger('amount'); // cents
			$table->string('currency', 10)->default('usd');
			$table->string('type', 32); // 'deposit'
			$table->string('status', 32); // 'succeeded', 'requires_action', etc.
			$table->string('stripe_payment_intent_id')->index();
			$table->string('stripe_charge_id')->nullable()->index();
			$table->string('stripe_transfer_id')->nullable()->index();
			$table->timestamp('transferred_at')->nullable();
			$table->json('billing_details')->nullable();
			$table->json('shipping')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

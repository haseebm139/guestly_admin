<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            if (!Schema::hasColumn('cards', 'stripe_external_account_id')) {
                $table->string('stripe_external_account_id')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('cards', 'brand')) {
                $table->string('brand')->nullable()->after('stripe_external_account_id');
            }
            if (!Schema::hasColumn('cards', 'last4')) {
                $table->string('last4', 4)->nullable()->after('brand');
            }
            if (!Schema::hasColumn('cards', 'exp_month')) {
                $table->unsignedTinyInteger('exp_month')->nullable()->after('last4');
            }
            if (!Schema::hasColumn('cards', 'exp_year')) {
                $table->unsignedSmallInteger('exp_year')->nullable()->after('exp_month');
            }
            // Make old sensitive fields nullable, if they exist
            if (Schema::hasColumn('cards', 'card_number')) {
                $table->string('card_number')->nullable()->change();
            }
            if (Schema::hasColumn('cards', 'cvc')) {
                $table->string('cvc')->nullable()->change();
            }
            if (Schema::hasColumn('cards', 'expiry_date')) {
                $table->string('expiry_date')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            if (Schema::hasColumn('cards', 'stripe_external_account_id')) {
                $table->dropColumn('stripe_external_account_id');
            }
            if (Schema::hasColumn('cards', 'brand')) {
                $table->dropColumn('brand');
            }
            if (Schema::hasColumn('cards', 'last4')) {
                $table->dropColumn('last4');
            }
            if (Schema::hasColumn('cards', 'exp_month')) {
                $table->dropColumn('exp_month');
            }
            if (Schema::hasColumn('cards', 'exp_year')) {
                $table->dropColumn('exp_year');
            }
        });
    }
};



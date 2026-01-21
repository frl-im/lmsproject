<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_premium')) {
                $table->boolean('is_premium')->default(false)->after('is_admin');
            }
            if (!Schema::hasColumn('users', 'premium_expires_at')) {
                $table->timestamp('premium_expires_at')->nullable()->after('is_premium');
            }
            if (!Schema::hasColumn('users', 'subscription_status')) {
                $table->enum('subscription_status', ['free', 'premium', 'expired'])->default('free')->after('premium_expires_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_premium')) {
                $table->dropColumn('is_premium');
            }
            if (Schema::hasColumn('users', 'premium_expires_at')) {
                $table->dropColumn('premium_expires_at');
            }
            if (Schema::hasColumn('users', 'subscription_status')) {
                $table->dropColumn('subscription_status');
            }
        });
    }
};

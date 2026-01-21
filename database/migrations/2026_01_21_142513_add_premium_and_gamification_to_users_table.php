<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'is_premium')) {
                $table->boolean('is_premium')->default(false)->after('is_admin');
            }

            if (!Schema::hasColumn('users', 'experience')) {
                $table->integer('experience')->default(0)->after('is_premium');
            }

            if (!Schema::hasColumn('users', 'points')) {
                $table->integer('points')->default(0)->after('experience');
            }

            if (!Schema::hasColumn('users', 'premium_until')) {
                $table->date('premium_until')->nullable()->after('points');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'premium_until')) {
                $table->dropColumn('premium_until');
            }

            if (Schema::hasColumn('users', 'points')) {
                $table->dropColumn('points');
            }

            if (Schema::hasColumn('users', 'experience')) {
                $table->dropColumn('experience');
            }

            if (Schema::hasColumn('users', 'is_premium')) {
                $table->dropColumn('is_premium');
            }
        });
    }
};

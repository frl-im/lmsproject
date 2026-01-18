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
        // Add fields to users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'experience')) {
                $table->integer('experience')->default(0);
            }
            if (!Schema::hasColumn('users', 'points')) {
                $table->integer('points')->default(0);
            }
            if (!Schema::hasColumn('users', 'is_premium')) {
                $table->boolean('is_premium')->default(false);
            }
        });

        // Add fields to user_progress table
        Schema::table('user_progress', function (Blueprint $table) {
            if (!Schema::hasColumn('user_progress', 'is_completed')) {
                $table->boolean('is_completed')->default(false)->after('completed_at');
            }
            if (!Schema::hasColumn('user_progress', 'quiz_score')) {
                $table->decimal('quiz_score', 5, 2)->nullable()->after('is_completed');
            }
            if (!Schema::hasColumn('user_progress', 'quiz_attempts')) {
                $table->integer('quiz_attempts')->default(0)->after('quiz_score');
            }
            if (!Schema::hasColumn('user_progress', 'xp_awarded')) {
                $table->boolean('xp_awarded')->default(false)->after('quiz_attempts');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['experience', 'points', 'is_premium']);
        });

        Schema::table('user_progress', function (Blueprint $table) {
            $table->dropColumn(['is_completed', 'quiz_score', 'quiz_attempts', 'xp_awarded']);
        });
    }
};

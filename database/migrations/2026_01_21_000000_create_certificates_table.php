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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('type', ['global_rank_1', 'global_rank_2', 'global_rank_3', 'monthly_rank_1', 'monthly_rank_2', 'monthly_rank_3', 'course_complete'])->default('course_complete');
            $table->integer('rank')->nullable(); // 1, 2, 3 for leaderboard rankings
            $table->timestamp('earned_at');
            $table->foreignId('issued_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('course_id');
            $table->index('type');
            $table->index('earned_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};

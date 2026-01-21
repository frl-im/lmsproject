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
        Schema::create('daily_missions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('mission_type', ['lesson_complete', 'quiz_complete', 'streak_maintain'])->index();
            $table->boolean('is_completed')->default(false)->index();
            $table->integer('progress')->default(0);
            $table->integer('target')->default(1);
            $table->integer('reward_xp')->default(100);
            $table->integer('reward_points')->default(50);
            $table->date('mission_date')->index();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            // Ensure one mission per user per day per type
            $table->unique(['user_id', 'mission_date', 'mission_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_missions');
    }
};

<?php

namespace App\Traits;

use App\Models\DailyMission;
use Carbon\Carbon;

trait TracksDailyMissions
{
    /**
     * Track lesson completion for daily missions
     */
    public function trackLessonCompletion(): void
    {
        $mission = DailyMission::where('user_id', $this->id)
            ->where('mission_type', 'lesson_complete')
            ->where('mission_date', Carbon::today())
            ->first();

        if ($mission && !$mission->is_completed) {
            $mission->completeProgress(1);
        }
    }

    /**
     * Track quiz completion for daily missions
     */
    public function trackQuizCompletion(): void
    {
        $mission = DailyMission::where('user_id', $this->id)
            ->where('mission_type', 'quiz_complete')
            ->where('mission_date', Carbon::today())
            ->first();

        if ($mission && !$mission->is_completed) {
            $mission->completeProgress(1);
        }
    }

    /**
     * Track daily streak
     */
    public function trackStreakMaintenance(): void
    {
        $mission = DailyMission::where('user_id', $this->id)
            ->where('mission_type', 'streak_maintain')
            ->where('mission_date', Carbon::today())
            ->first();

        if ($mission && !$mission->is_completed) {
            $mission->completeProgress(1);
        }
    }

    /**
     * Complete daily mission and award rewards
     */
    public function completeDailyMission(DailyMission $mission): void
    {
        if (!$mission->is_completed) {
            $mission->update([
                'is_completed' => true,
                'completed_at' => now()
            ]);

            // Award rewards
            $this->addXP($mission->reward_xp);
            $this->addPoints($mission->reward_points);

            // Save updates
            $this->save();
        }
    }
}

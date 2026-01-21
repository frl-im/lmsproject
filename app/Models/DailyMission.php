<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class DailyMission extends Model
{
    protected $fillable = [
        'user_id',
        'mission_type',
        'is_completed',
        'progress',
        'target',
        'reward_xp',
        'reward_points',
        'mission_date',
        'completed_at'
    ];

    protected $casts = [
        'mission_date' => 'date',
        'completed_at' => 'datetime',
        'is_completed' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getTodaysMissions($userId)
    {
        $today = Carbon::today();
        $missions = self::where('user_id', $userId)
            ->where('mission_date', $today)
            ->get();

        // Jika belum ada misi untuk hari ini, buatkan
        if ($missions->isEmpty()) {
            $missions = self::createTodaysMissions($userId);
        }

        return $missions;
    }

    public static function createTodaysMissions($userId)
    {
        $today = Carbon::today();
        $missions = [];

        $missionTypes = [
            [
                'type' => 'lesson_complete',
                'icon' => '✓',
                'name' => 'Selesaikan 1 Materi',
                'xp' => 100,
                'points' => 50,
                'target' => 1
            ],
            [
                'type' => 'quiz_complete',
                'icon' => '📝',
                'name' => 'Ikuti 1 Quiz',
                'xp' => 150,
                'points' => 75,
                'target' => 1
            ],
            [
                'type' => 'streak_maintain',
                'icon' => '🔥',
                'name' => 'Pertahankan Streak',
                'xp' => 200,
                'points' => 100,
                'target' => 1
            ]
        ];

        foreach ($missionTypes as $mission) {
            $missions[] = self::updateOrCreate(
                [
                    'user_id' => $userId,
                    'mission_date' => $today,
                    'mission_type' => $mission['type']
                ],
                [
                    'progress' => 0,
                    'target' => $mission['target'],
                    'reward_xp' => $mission['xp'],
                    'reward_points' => $mission['points'],
                    'is_completed' => false
                ]
            );
        }

        return collect($missions);
    }

    public function completeProgress($increment = 1)
    {
        $this->progress += $increment;
        if ($this->progress >= $this->target && !$this->is_completed) {
            $this->is_completed = true;
            $this->completed_at = now();
        }
        $this->save();
        return $this;
    }

    public function isCompleted(): bool
    {
        return $this->is_completed;
    }

    public function getProgress(): int
    {
        return min($this->progress, $this->target);
    }

    public function getProgressPercentage(): int
    {
        return $this->target > 0 ? (int) (($this->progress / $this->target) * 100) : 0;
    }
}

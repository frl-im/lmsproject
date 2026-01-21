<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyMission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DailyMissionController extends Controller
{
    /**
     * Get today's daily missions for the authenticated user
     */
    public function getTodaysMissions(): JsonResponse
    {
        try {
            $user = Auth::user();
            $missions = DailyMission::getTodaysMissions($user->id);

            return response()->json([
                'success' => true,
                'missions' => $missions->map(function ($mission) {
                    return [
                        'id' => $mission->id,
                        'type' => $mission->mission_type,
                        'progress' => $mission->progress,
                        'target' => $mission->target,
                        'is_completed' => $mission->is_completed,
                        'progress_percentage' => $mission->getProgressPercentage(),
                        'reward_xp' => $mission->reward_xp,
                        'reward_points' => $mission->reward_points,
                    ];
                }),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching missions: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Complete a specific daily mission
     */
    public function completeMission(DailyMission $mission): JsonResponse
    {
        try {
            $user = Auth::user();

            // Verify mission belongs to user
            if ($mission->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }

            if ($mission->is_completed) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mission already completed',
                ], 422);
            }

            // Complete the mission and award rewards
            $user->completeDailyMission($mission);

            // Refresh user data
            $user = $user->fresh();

            return response()->json([
                'success' => true,
                'message' => 'Mission completed! You earned ' . $mission->reward_xp . ' XP and ' . $mission->reward_points . ' points.',
                'reward_xp' => $mission->reward_xp,
                'reward_points' => $mission->reward_points,
                'user_xp' => $user->experience,
                'user_points' => $user->points,
                'mission' => [
                    'id' => $mission->id,
                    'type' => $mission->mission_type,
                    'is_completed' => $mission->is_completed,
                    'completed_at' => $mission->completed_at,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error completing mission: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get mission completion statistics
     */
    public function getStatistics(): JsonResponse
    {
        try {
            $user = Auth::user();
            $missions = DailyMission::getTodaysMissions($user->id);

            $completedCount = $missions->where('is_completed', true)->count();
            $totalRewardXp = $missions->where('is_completed', true)->sum('reward_xp');
            $totalRewardPoints = $missions->where('is_completed', true)->sum('reward_points');

            return response()->json([
                'success' => true,
                'completed_missions' => $completedCount,
                'total_missions' => $missions->count(),
                'total_reward_xp' => $totalRewardXp,
                'total_reward_points' => $totalRewardPoints,
                'completion_percentage' => $missions->count() > 0 ? ($completedCount / $missions->count()) * 100 : 0,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching statistics: ' . $e->getMessage(),
            ], 500);
        }
    }
}

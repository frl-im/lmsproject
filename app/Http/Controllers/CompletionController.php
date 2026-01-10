<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompletionController extends Controller
{
    /**
     * Mark a lesson as complete and award XP.
     */
    public function completeLesson(Request $request, Lesson $lesson)
    {
        $user = Auth::user();

        // Check if lesson already completed
        $existingProgress = UserProgress::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        if ($existingProgress && $existingProgress->completed_at) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah menyelesaikan lesson ini sebelumnya!',
            ], 422);
        }

        // Get course via module
        $course = $lesson->module->course;

        try {
            DB::beginTransaction();

            // Create or update progress
            $progress = UserProgress::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'lesson_id' => $lesson->id,
                ],
                [
                    'course_id' => $course->id,
                    'completed_at' => now(),
                ]
            );

            // Award XP to user
            $xpReward = $lesson->xp_reward ?? 10;
            $user->increment('experience', $xpReward);

            DB::commit();

            // Check if module is completed
            $moduleCompleted = $this->checkModuleCompletion($lesson->module, $user->id);

            // Check if course is completed
            $courseCompleted = $this->checkCourseCompletion($course, $user->id);

            return response()->json([
                'success' => true,
                'message' => 'Kerja Bagus! Kamu mendapatkan ' . $xpReward . ' XP!',
                'xp_reward' => $xpReward,
                'user_experience' => $user->experience,
                'module_completed' => $moduleCompleted,
                'course_completed' => $courseCompleted,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Submit module completion.
     */
    public function completeModule(Request $request, Module $module)
    {
        $user = Auth::user();

        // Check if module is already submitted
        $moduleCompleted = $module->isCompletedByUser($user->id);

        if (!$moduleCompleted) {
            return response()->json([
                'success' => false,
                'message' => 'Selesaikan semua lesson di modul ini terlebih dahulu!',
                'progress_percentage' => $module->getProgressPercentage($user->id),
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Award bonus XP for module completion
            $moduleBonus = 50;
            $user->increment('experience', $moduleBonus);

            DB::commit();

            // Check if course is completed
            $course = $module->course;
            $courseCompleted = $this->checkCourseCompletion($course, $user->id);

            return response()->json([
                'success' => true,
                'message' => 'Selamat! Modul berhasil diselesaikan. Bonus XP: ' . $moduleBonus,
                'bonus_xp' => $moduleBonus,
                'user_experience' => $user->experience,
                'course_completed' => $courseCompleted,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Submit course completion.
     */
    public function completeCourse(Request $request, Course $course)
    {
        $user = Auth::user();

        // Check if course is already submitted
        $courseCompleted = $course->isCompletedByUser($user->id);

        if (!$courseCompleted) {
            return response()->json([
                'success' => false,
                'message' => 'Selesaikan semua lesson di course ini terlebih dahulu!',
                'progress_percentage' => $course->getProgressPercentage($user->id),
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Award bonus XP for course completion
            $courseBonus = 200;
            $user->increment('experience', $courseBonus);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Selamat! Course berhasil diselesaikan. Bonus XP: ' . $courseBonus,
                'bonus_xp' => $courseBonus,
                'user_experience' => $user->experience,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get completion status and progress for a course.
     */
    public function getCourseProgress(Course $course)
    {
        $user = Auth::user();

        $totalLessons = $course->lessons()->count();
        $completedLessons = UserProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $course->lessons()->pluck('id'))
            ->completed()
            ->count();

        $progressPercentage = $totalLessons > 0 ? ($completedLessons / $totalLessons * 100) : 0;

        return response()->json([
            'total_lessons' => $totalLessons,
            'completed_lessons' => $completedLessons,
            'progress_percentage' => (int)$progressPercentage,
            'is_completed' => $course->isCompletedByUser($user->id),
        ]);
    }

    /**
     * Get completion status and progress for a module.
     */
    public function getModuleProgress(Module $module)
    {
        $user = Auth::user();

        $totalLessons = $module->lessons()->count();
        $completedLessons = UserProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $module->lessons()->pluck('id'))
            ->completed()
            ->count();

        $progressPercentage = $totalLessons > 0 ? ($completedLessons / $totalLessons * 100) : 0;

        return response()->json([
            'total_lessons' => $totalLessons,
            'completed_lessons' => $completedLessons,
            'progress_percentage' => (int)$progressPercentage,
            'is_completed' => $module->isCompletedByUser($user->id),
        ]);
    }

    /**
     * Check and update course completion status.
     */
    private function checkCourseCompletion(Course $course, $userId): bool
    {
        return $course->isCompletedByUser($userId);
    }

    /**
     * Check and update module completion status.
     */
    private function checkModuleCompletion(Module $module, $userId): bool
    {
        return $module->isCompletedByUser($userId);
    }
}

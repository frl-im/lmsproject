<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\UserProgress; 
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $courses = Course::with(['modules.lessons'])
            ->latest()
            ->get();

        $courses->transform(function ($course) use ($user) {

            $totalLessons = 0;
            $lessonIds = [];

            foreach ($course->modules ?? [] as $module) {
                foreach ($module->lessons ?? [] as $lesson) {
                    $totalLessons++;
                    $lessonIds[] = $lesson->id;
                }
            }

            $completedCount = 0;
            if ($user && !empty($lessonIds)) {
                $completedCount = UserProgress::where('user_id', $user->id)
                    ->whereIn('lesson_id', $lessonIds)
                    ->where('is_completed', true)
                    ->count();
            }

            $course->progress = $totalLessons > 0
                ? round(($completedCount / $totalLessons) * 100)
                : 0;

            $course->modules_count = count($course->modules ?? []);
            $course->lessons_count = $totalLessons;
            $course->questions_count = 0;
            $course->xp_reward = $totalLessons * 100;

            return $course;
        });

        return view('dashboard', compact('user', 'courses'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UserProgress; // WAJIB ADA
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // 1. Ambil data Course dengan relasi
        $courses = Course::with(['modules.lessons'])
            ->latest()
            ->get();

        // 2. Hitung Progress secara manual agar aman
        $courses->transform(function ($course) use ($user) {
            // Hitung total materi
            $totalLessons = 0;
            $lessonIds = [];

            if ($course->modules) {
                foreach ($course->modules as $module) {
                    if ($module->lessons) {
                        $totalLessons += $module->lessons->count();
                        foreach ($module->lessons as $lesson) {
                            $lessonIds[] = $lesson->id;
                        }
                    }
                }
            }

            // Hitung materi selesai
            $completedCount = 0;
            if (!empty($lessonIds)) {
                $completedCount = UserProgress::where('user_id', $user->id)
                    ->whereIn('lesson_id', $lessonIds)
                    ->where('is_completed', true)
                    ->count();
            }

            // Kalkulasi Persen
            $course->progress = ($totalLessons > 0) 
                ? round(($completedCount / $totalLessons) * 100) 
                : 0;

            // Data Pelengkap (Agar tidak error undefined)
            $course->modules_count = $course->modules->count();
            $course->lessons_count = $totalLessons;
            $course->questions_count = 0; 
            $course->xp_reward = $totalLessons * 100;

            return $course;
        });

        // 3. Load Badge User (Gunakan try catch agar aman)
        $badges = [];
        try {
            if (method_exists($user, 'badges')) {
                $badges = $user->badges;
            }
        } catch (\Exception $e) {
            // Abaikan jika error relasi, biarkan array kosong
        }

        return view('dashboard', [
            'user' => $user,
            'courses' => $courses,
            'badges' => $badges,
        ]);
    }
}
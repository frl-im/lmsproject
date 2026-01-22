<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserProgress; // Tambahkan ini agar complete() tidak error
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini agar Auth::user() tidak error
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    /**
     * Menampilkan halaman lesson/materi.
     * Kita tambahkan parameter $course_id di depan karena route-nya nested resource.
     */
    public function show($course_id, Lesson $lesson)
    {
        // $course_id menangkap parameter pertama dari URL (/courses/{1}/...)
        // $lesson menangkap parameter kedua dan otomatis di-convert jadi Model Lesson

        $lesson->load(['module.course']);
        $user = Auth::user();
        $badges = $user ? $user->badges : collect([]);

        // --- LOGIKA NEXT LESSON LINTAS MODUL ---
        $next_lesson = null;
        $allLessonsInModule = $lesson->module->lessons()->orderBy('id')->get();
        $next = $allLessonsInModule->where('id', '>', $lesson->id)->first();
        if ($next) {
            $next_lesson = $next;
        } else {
            // Cari modul berikutnya dalam course yang sama
            $currentModule = $lesson->module;
            $course = $currentModule->course;
            $modules = $course->modules()->orderBy('id')->get();
            $nextModule = $modules->where('id', '>', $currentModule->id)->first();
            if ($nextModule) {
                $firstLessonNextModule = $nextModule->lessons()->orderBy('id')->first();
                if ($firstLessonNextModule) {
                    $next_lesson = $firstLessonNextModule;
                }
            }
        }

        return view('lessons.show', compact('lesson', 'badges', 'next_lesson'));
    }

    /**
     * Menandai materi selesai & memberi XP
     */
    public function complete(Request $request, Lesson $lesson)
    {
        try {
            $user = Auth::user();
            $exists = $user->lessons()->where('lesson_id', $lesson->id)->exists();
            if ($exists) {
                return response()->json(['success' => false, 'message' => 'Sudah selesai sebelumnya', 'xp_reward' => 0], 200);
            }
            $xp = $lesson->xp_reward ?? 10;
            $user->lessons()->syncWithoutDetaching([
                $lesson->id => [
                    'is_completed' => true,
                    'completed_at' => now(),
                    'xp_awarded' => $xp,
                    'course_id' => $lesson->module->course_id,
                ]
            ]);
            $user->addXP($xp);
            return response()->json(['success' => true, 'message' => 'Selesai!', 'xp_reward' => $xp], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
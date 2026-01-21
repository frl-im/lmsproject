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

        return view('lessons.show', compact('lesson', 'badges'));
    }

    /**
     * Menandai materi selesai & memberi XP
     */
    public function complete(Request $request, Lesson $lesson)
    {
        $user = Auth::user();

        // Cek sudah selesai belum
        $exists = UserProgress::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Sudah selesai sebelumnya', 'xp_reward' => 0]);
        }

        // Simpan Progress
        UserProgress::create([
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
            'course_id' => $lesson->module->course_id,
            'is_completed' => true,
            'completed_at' => now(),
            'xp_awarded' => true
        ]);

        // Tambah XP
        $xp = $lesson->xp_reward ?? 10;
        
        // Cek apakah method addXP tersedia di model User
        if (method_exists($user, 'addXP')) {
            $user->addXP($xp);
        } else {
            // Fallback manual jika method addXP belum ada
            $user->experience = ($user->experience ?? 0) + $xp;
            $user->save();
        }

        return response()->json(['message' => 'Selesai!', 'xp_reward' => $xp]);
    }
}
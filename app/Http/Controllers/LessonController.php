<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function show(Lesson $lesson)
    {
        $lesson->load(['module.course']);
        
        $user = Auth::user();
        $badges = $user ? $user->badges : collect([]);

        return view('lessons.show', compact('lesson', 'badges'));
    }

    public function complete(Request $request, Lesson $lesson)
    {
        $user = Auth::user();

        // Cek sudah selesai belum
        $exists = UserProgress::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->where('is_completed', true)
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
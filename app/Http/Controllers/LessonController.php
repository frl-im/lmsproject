<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    /**
     * Menampilkan halaman materi belajar
     */
    public function show(Lesson $lesson)
    {
        dd('Lesson Controller Berhasil Dipanggil!', $lesson);
        // 1. Load relasi agar navigasi breadcrumb berjalan
        $lesson->load(['module.course']);
        
        // 2. Load badges untuk layout (INI SOLUSI AGAR TIDAK BLANK) 🛠️
        $user = Auth::user();
        $badges = $user ? $user->badges : collect([]);

        // Kirim data ke View
        return view('lessons.show', compact('lesson', 'badges'));
    }

    /**
     * Menandai materi selesai & memberi XP
     */
    public function complete(Request $request, Lesson $lesson)
    {
        $user = Auth::user();
        
        // Cek apakah user sudah pernah menyelesaikan materi ini?
        $hasCompleted = UserProgress::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->where('is_completed', true)
            ->exists();

        if ($hasCompleted) {
            return response()->json([
                'success' => true, // Tetap true agar tombol jadi 'Selesai'
                'message' => 'Kamu sudah menyelesaikan materi ini sebelumnya.',
                'xp_reward' => 0
            ]);
        }

        // Simpan Progress ke Database
        UserProgress::create([
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
            'course_id' => $lesson->module->course_id,
            'is_completed' => true,
            'completed_at' => now(),
            'xp_awarded' => true
        ]);

        // Tambahkan XP ke User
        $xp = $lesson->xp_reward ?? 10;
        
        if (method_exists($user, 'addXP')) {
            $user->addXP($xp);
        } else {
            $user->experience = ($user->experience ?? 0) + $xp;
            $user->save();
        }

        // Kirim respon sukses ke Javascript
        return response()->json([
            'success' => true, // <--- INI KUNCI AGAR TOMBOL BERUBAH 🔑
            'message' => 'Hore! Materi Selesai. +' . $xp . ' XP',
            'xp_reward' => $xp
        ]);
    }
}
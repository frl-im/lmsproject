<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        return view('lessons.show', compact('lesson'));
    }

    /**
     * Mark the lesson as complete for the user.
     */
    public function complete(Request $request, Lesson $lesson)
    {
        $user = Auth::user();
        
        // --- LOGIC PEMBERIAN XP & PENYIMPANAN PROGRESS ---
        // 1. Cek apakah user sudah menyelesaikan lesson ini sebelumnya
        //    (contoh: $user->progress()->where('lesson_id', $lesson->id)->exists())
        // 2. Jika belum, tambahkan XP ke user
        //    $user->xp += $lesson->xp_reward;
        //    $user->save();
        // 3. Tandai lesson ini sebagai selesai untuk user
        //    (contoh: $user->progress()->create(['lesson_id' => $lesson->id, 'status' => 'completed']))
        //
        // Untuk sekarang, kita hanya kirim response JSON sederhana
        
        return response()->json([
            'message' => 'Kerja Bagus! Kamu mendapatkan ' . $lesson->xp_reward . ' XP!',
            'xp_reward' => $lesson->xp_reward
        ]);
    }
}

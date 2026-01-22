<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Lesson;
use App\Models\Course;
use App\Models\UserProgress;
use App\Models\QuizResult;
use App\Http\Controllers\CompletionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    /**
     * Menampilkan halaman kuis
     */
    public function show(Course $course, Lesson $lesson)
    {
        try {
            // 1. Pastikan lesson tipe kuis
            if ($lesson->type !== 'kuis') {
                return redirect()->route('lessons.show', ['course' => $course->id, 'lesson' => $lesson->id])
                    ->with('error', 'Lesson ini bukan tipe kuis');
            }

            $user = Auth::user();
            
            // 2. Cek riwayat pengerjaan user
            $previousAttempt = QuizResult::where('user_id', $user->id)
                ->where('lesson_id', $lesson->id)
                ->first(); // Mengambil data hasil kuis terakhir

            // 3. Ambil soal
            $questions = $lesson->questions()->orderBy('id')->get();

            if ($questions->isEmpty()) {
                return redirect()->route('lessons.show', ['course' => $course->id, 'lesson' => $lesson->id])
                    ->with('error', 'Kuis belum memiliki soal');
            }

            return view('quiz.show', compact('lesson', 'questions', 'previousAttempt', 'user'));

        } catch (\Exception $e) {
            return redirect()->route('lessons.show', ['course' => $course->id, 'lesson' => $lesson->id])
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Memproses jawaban kuis
     * Logika: 
     * - Attempt Pertama: Dapat Nilai + Dapat XP
     * - Attempt Kedua dst (Remedial): Dapat Perbaikan Nilai + TIDAK Dapat XP
     */
    public function submit(Request $request, Lesson $lesson)
    {
        try {
            if ($lesson->type !== 'kuis') {
                return redirect()->route('lessons.show', $lesson)
                    ->with('error', 'Lesson ini bukan tipe kuis');
            }

            $user = Auth::user();

            $request->validate([
                'answers' => 'required|array',
                'answers.*' => 'required|in:A,B,C,D',
            ]);

            DB::beginTransaction();

            // Cek apakah ini percobaan pertama atau pengulangan
            $previousResult = QuizResult::where('user_id', $user->id)
                ->where('lesson_id', $lesson->id)
                ->first();

            $isFirstAttempt = !$previousResult;

            // Hitung Skor
            $answers = $request->input('answers');
            $questions = $lesson->questions()->get();
            
            $correctCount = 0;
            $totalQuestions = $questions->count();
            $totalScore = 0;

            foreach ($questions as $question) {
                $userAnswer = $answers[$question->id] ?? null;
                if ($userAnswer && $userAnswer === $question->correct_answer) {
                    $correctCount++;
                    $totalScore += $question->point ?? 10;
                }
            }

            $percentage = ($totalQuestions > 0) ? ($correctCount / $totalQuestions * 100) : 0;
            $finalScore = round($percentage);
            $isPassed = $finalScore >= 70;

            // --- LOGIKA UTAMA ---
            if ($isFirstAttempt) {
                // == PERCOBAAN PERTAMA (DAPAT XP) ==
                
                $xpReward = $lesson->xp_reward ?? 10;
                
                // 1. Simpan Hasil Kuis
                QuizResult::create([
                    'user_id' => $user->id,
                    'lesson_id' => $lesson->id,
                    'total_questions' => $totalQuestions,
                    'correct_answers' => $correctCount,
                    'score' => $finalScore,
                    'xp_earned' => $xpReward, // XP dicatat
                    'passed' => $isPassed,
                ]);

                // 2. Simpan Progress Materi
                UserProgress::updateOrCreate(
                    ['user_id' => $user->id, 'lesson_id' => $lesson->id],
                    [
                        'course_id' => $lesson->module->course_id,
                        'quiz_score' => $finalScore,
                        'is_completed' => true,
                        'xp_awarded' => true,
                        'completed_at' => now(),
                    ]
                );

                // 3. Tambah XP ke User (Peringkat Naik)
                if (method_exists($user, 'addXP')) {
                    $user->addXP($xpReward);
                } else {
                    $user->experience = ($user->experience ?? 0) + $xpReward;
                    $user->save();
                }

                // 4. Track Misi Harian (jika ada)
                if (method_exists($user, 'trackQuizCompletion')) {
                    $user->trackQuizCompletion();
                }

                $message = "Selamat! Jawaban terkirim.";

            } else {
                // == PERCOBAAN ULANG / REMEDIAL (TIDAK ADA XP) ==
                
                // Hanya update jika nilai baru LEBIH BAIK dari sebelumnya
                if ($finalScore > $previousResult->score) {
                    $previousResult->update([
                        'score' => $finalScore,
                        'correct_answers' => $correctCount,
                        'passed' => $isPassed, // Status lulus bisa berubah jadi true
                        'updated_at' => now(),
                    ]);
                    
                    // Update juga di UserProgress agar sinkron
                    UserProgress::where('user_id', $user->id)
                        ->where('lesson_id', $lesson->id)
                        ->update(['quiz_score' => $finalScore]);

                    $message = 'Skor meningkat! Score baru: ' . $finalScore . '%';
                } else {
                    $message = 'Latihan selesai (Skor tidak meningkat).';
                }

                // PERHATIKAN: Tidak ada kode $user->addXP() di blok ini!
                // Peringkat user AMAN.
                $xpReward = 0; 
            }

            DB::commit();

            return redirect()->route('lessons.show', [$lesson->module->course, $lesson])->with([
                'quiz_result' => true,
                'passed' => $isPassed,
                'percentage' => $finalScore,
                'correct_count' => $correctCount,
                'total_questions' => $totalQuestions,
                'score' => $totalScore,
                'xp_reward' => $xpReward, // Akan bernilai 0 jika remedial
                'message' => $message
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('lessons.show', [$lesson->module->course, $lesson])
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

        /**
     * Quiz khusus Premium
     */
    public function premium()
    {
        $user = Auth::user();

        // Double safety
        if (!$user || !$user->isPremium()) {
            abort(403, 'Fitur ini hanya untuk pengguna Premium');
        }

        // Contoh: ambil semua lesson tipe kuis (bisa kamu sesuaikan)
        $lessons = Lesson::where('type', 'kuis')
            ->with('module.course')
            ->latest()
            ->get();

        return view('quiz.premium', compact('lessons'));
    }

}
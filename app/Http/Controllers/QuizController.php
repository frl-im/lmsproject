<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Lesson;
use App\Models\UserProgress;
use App\Http\Controllers\CompletionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    /**
     * Show quiz for student
     */
    public function show(Lesson $lesson)
    {
        try {
            // Pastikan lesson tipe kuis dan user sudah authenticated
            if ($lesson->type !== 'kuis') {
                return redirect()->route('lessons.show', $lesson)
                    ->with('error', 'Lesson ini bukan tipe kuis');
            }

            $user = Auth::user();
            
            // Cek apakah user sudah pernah mengerjakan kuis
            $previousAttempt = UserProgress::where('user_id', $user->id)
                ->where('lesson_id', $lesson->id)
                ->first();

            // Get semua questions untuk lesson ini
            $questions = $lesson->questions()->orderBy('id')->get();

            // Jika tidak ada soal, redirect dengan error
            if ($questions->isEmpty()) {
                return redirect()->route('lessons.show', $lesson)
                    ->with('error', 'Kuis belum memiliki soal');
            }

            return view('quiz.show', compact('lesson', 'questions', 'previousAttempt', 'user'));
        } catch (\Exception $e) {
            return redirect()->route('lessons.show', $lesson ?? null)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Submit quiz answers dengan anti-farming logic
     */
    public function submit(Request $request, Lesson $lesson)
    {
        try {
            // Pastikan lesson tipe kuis
            if ($lesson->type !== 'kuis') {
                return redirect()->route('lessons.show', $lesson)
                    ->with('error', 'Lesson ini bukan tipe kuis');
            }

            $user = Auth::user();

            // Validasi - minimal ada satu jawaban
            $request->validate([
                'answers' => 'required|array',
                'answers.*' => 'required|in:A,B,C,D',
            ]);

            DB::beginTransaction();

            // Cek apakah user sudah pernah submit kuis ini (anti-farming)
            $existingProgress = UserProgress::where('user_id', $user->id)
                ->where('lesson_id', $lesson->id)
                ->first();

            $isFirstAttempt = !$existingProgress;

            $answers = $request->input('answers');
            $questions = $lesson->questions()->get();
            
            $correctCount = 0;
            $totalQuestions = $questions->count();
            $totalScore = 0;

            // Hitung jawaban benar
            foreach ($questions as $question) {
                $userAnswer = $answers[$question->id] ?? null;
                
                if ($userAnswer && $userAnswer === $question->correct_answer) {
                    $correctCount++;
                    $totalScore += $question->point ?? 10;
                }
            }

            // Hitung persentase
            $percentage = ($totalQuestions > 0) ? ($correctCount / $totalQuestions * 100) : 0;

            // ANTI-FARMING LOGIC: 
            // Jika first attempt: simpan score dan award XP
            // Jika retry: update score tapi TIDAK award XP lagi
            if ($isFirstAttempt) {
                // FIRST TIME - Award XP
                $xpReward = $lesson->xp_reward ?? 10;
                
                $progress = UserProgress::create([
                    'user_id' => $user->id,
                    'lesson_id' => $lesson->id,
                    'course_id' => $lesson->module->course_id,
                    'quiz_score' => $percentage,
                    'quiz_attempts' => 1,
                    'is_completed' => true,
                    'xp_awarded' => true,
                    'completed_at' => now(),
                ]);

                // Award XP to user
                $user->addXP($xpReward);

                // Track daily mission for quiz completion
                $user->trackQuizCompletion();

                DB::commit();

                return redirect()->route('lessons.show', $lesson)->with([
                    'quiz_result' => true,
                    'passed' => $percentage >= 70,
                    'is_first_attempt' => true,
                    'percentage' => $percentage,
                    'correct_count' => $correctCount,
                    'total_questions' => $totalQuestions,
                    'score' => $totalScore,
                    'xp_reward' => $xpReward,
                    'message' => 'Kerja Bagus! Kamu mendapatkan ' . $xpReward . ' XP!',
                ]);
            } else {
                // RETRY - Update score only, NO XP
                // Update hanya jika score lebih tinggi dari sebelumnya
                if ($percentage > $existingProgress->quiz_score) {
                    $existingProgress->update([
                        'quiz_score' => $percentage,
                        'quiz_attempts' => DB::raw('quiz_attempts + 1'),
                    ]);
                } else {
                    $existingProgress->increment('quiz_attempts');
                }

                DB::commit();

                return redirect()->route('lessons.show', $lesson)->with([
                    'quiz_result' => true,
                    'passed' => $percentage >= 70,
                    'is_first_attempt' => false,
                    'percentage' => $percentage,
                    'previous_score' => $existingProgress->quiz_score,
                    'correct_count' => $correctCount,
                    'total_questions' => $totalQuestions,
                    'score' => $totalScore,
                    'xp_reward' => 0,
                    'message' => 'Latihan selesai (Tanpa Poin Tambahan)',
                ]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('lessons.show', $lesson)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}


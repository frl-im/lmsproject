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
    }

    /**
     * Submit quiz answers
     */
    public function submit(Request $request, Lesson $lesson)
    {
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

        try {
            DB::beginTransaction();

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

            // Simpan hasil kuis
            $progress = UserProgress::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'lesson_id' => $lesson->id,
                ],
                [
                    'course_id' => $lesson->module->course_id,
                    'quiz_score' => $percentage,
                    'quiz_attempts' => DB::raw('IFNULL(quiz_attempts, 0) + 1'),
                ]
            );

            // Jika nilai >= 70, tandai sebagai selesai dan beri XP
            $passed = $percentage >= 70;
            
            if ($passed) {
                $progress->update(['completed_at' => now()]);
                
                // Award XP
                $xpReward = $lesson->xp_reward ?? 10;
                $user->increment('experience', $xpReward);
            }

            DB::commit();

            return redirect()->route('lessons.show', $lesson)->with([
                'quiz_result' => true,
                'passed' => $passed,
                'percentage' => $percentage,
                'correct_count' => $correctCount,
                'total_questions' => $totalQuestions,
                'score' => $totalScore,
                'xp_reward' => $passed ? ($lesson->xp_reward ?? 10) : 0,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('lessons.show', $lesson)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

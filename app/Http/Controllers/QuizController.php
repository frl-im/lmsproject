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
     * Show quiz for student
     */
    public function show(Course $course, Lesson $lesson)
    {
        try {
            // Pastikan lesson tipe kuis dan user sudah authenticated
            if ($lesson->type !== 'kuis') {
                return redirect()->route('lessons.show', ['course' => $course->id, 'lesson' => $lesson->id])
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
     * Submit quiz answers dengan anti-farming logic dan QuizResult tracking
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

            // Cek apakah user sudah pernah submit kuis ini (dari QuizResult)
            $previousResult = QuizResult::where('user_id', $user->id)
                ->where('lesson_id', $lesson->id)
                ->first();

            $isFirstAttempt = !$previousResult;

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
            $isPassed = $percentage >= 70;

            // ANTI-FARMING LOGIC: 
            if ($isFirstAttempt) {
                // FIRST TIME - Award XP and create QuizResult
                $xpReward = $lesson->xp_reward ?? 10;
                
                // Simpan ke quiz_results
                QuizResult::create([
                    'user_id' => $user->id,
                    'lesson_id' => $lesson->id,
                    'total_questions' => $totalQuestions,
                    'correct_answers' => $correctCount,
                    'score' => round($percentage),
                    'xp_earned' => $xpReward,
                    'passed' => $isPassed,
                ]);

                // Simpan ke user_progress juga untuk tracking completion
                $existingProgress = UserProgress::where('user_id', $user->id)
                    ->where('lesson_id', $lesson->id)
                    ->first();

                if ($existingProgress) {
                    $existingProgress->update([
                        'quiz_score' => $percentage,
                        'is_completed' => true,
                        'xp_awarded' => true,
                        'completed_at' => now(),
                    ]);
                } else {
                    UserProgress::create([
                        'user_id' => $user->id,
                        'lesson_id' => $lesson->id,
                        'course_id' => $lesson->module->course_id,
                        'quiz_score' => $percentage,
                        'is_completed' => true,
                        'xp_awarded' => true,
                        'completed_at' => now(),
                    ]);
                }

                // Award XP to user
                $user->addXP($xpReward);

                // Track daily mission for quiz completion
                $user->trackQuizCompletion();

                DB::commit();

                return redirect()->route('lessons.show', [$lesson->module->course, $lesson])->with([
                    'quiz_result' => true,
                    'passed' => $isPassed,
                    'percentage' => round($percentage),
                    'correct_count' => $correctCount,
                    'total_questions' => $totalQuestions,
                    'score' => $totalScore,
                    'xp_reward' => $xpReward,
                ]);
            } else {
                // RETRY - Update score only jika lebih baik, NO XP reward
                $newScore = round($percentage);
                
                if ($newScore > $previousResult->score) {
                    $previousResult->update([
                        'score' => $newScore,
                        'correct_answers' => $correctCount,
                        'passed' => $isPassed,
                        'updated_at' => now(),
                    ]);
                    $message = 'Skor meningkat! Score baru: ' . $newScore . '%';
                } else {
                    $message = 'Latihan selesai (Score tidak meningkat)';
                }

                DB::commit();

                return redirect()->route('lessons.show', [$lesson->module->course, $lesson])->with([
                    'quiz_result' => true,
                    'passed' => $isPassed,
                    'percentage' => $newScore,
                    'previous_score' => $previousResult->score,
                    'correct_count' => $correctCount,
                    'total_questions' => $totalQuestions,
                    'score' => $totalScore,
                    'xp_reward' => 0,
                    'is_retry' => true,
                    'message' => $message,
                ]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('lessons.show', [$lesson->module->course, $lesson])
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}


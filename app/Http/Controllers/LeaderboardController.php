<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\QuizResult;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaderboardController extends Controller
{
    /**
     * Show global XP leaderboard
     */
    public function index()
    {
        $currentMonth = Carbon::now();
        
        // Get users ranked by XP
        $users = User::withCount('quizResults')
            ->orderBy('experience', 'desc')
            ->paginate(20);

        $currentUser = Auth::user();
        $currentUserRank = $this->getUserRank($currentUser?->id);

        return view('leaderboard.index', compact('users', 'currentUser', 'currentUserRank', 'currentMonth'));
    }

    /**
     * Show monthly ranking based on quiz scores in current month
     */
    public function monthly()
    {
        $currentMonth = Carbon::now();
        $monthName = $currentMonth->format('F Y');

        // Get users ranked by total quiz scores in current month
        $users = User::select('users.*', 
                \DB::raw('SUM(quiz_results.score) as total_score'),
                \DB::raw('COUNT(quiz_results.id) as quiz_count')
            )
            ->leftJoin('quiz_results', 'users.id', '=', 'quiz_results.user_id')
            ->whereYear('quiz_results.created_at', $currentMonth->year)
            ->whereMonth('quiz_results.created_at', $currentMonth->month)
            ->orWhereNull('quiz_results.id')
            ->groupBy('users.id')
            ->orderBy('total_score', 'desc')
            ->paginate(20);

        $currentUser = Auth::user();
        $currentUserMonthlyRank = $this->getUserMonthlyRank($currentUser?->id, $currentMonth);

        return view('leaderboard.monthly', compact('users', 'currentUser', 'currentUserMonthlyRank', 'monthName', 'currentMonth'));
    }

    /**
     * Show course-specific ranking
     */
    public function byCourse($courseId)
    {
        $course = \App\Models\Course::findOrFail($courseId);
        
        // Get users ranked by quiz scores in this course
        $users = User::select('users.*',
                \DB::raw('SUM(quiz_results.score) as total_score'),
                \DB::raw('COUNT(quiz_results.id) as quiz_count')
            )
            ->leftJoin('quiz_results', 'users.id', '=', 'quiz_results.user_id')
            ->leftJoin('lessons', 'quiz_results.lesson_id', '=', 'lessons.id')
            ->leftJoin('modules', 'lessons.module_id', '=', 'modules.id')
            ->where('modules.course_id', $courseId)
            ->groupBy('users.id')
            ->orderBy('total_score', 'desc')
            ->paginate(20);

        $currentUser = Auth::user();
        $currentUserRank = $this->getUserCourseRank($currentUser?->id, $courseId);
        
        // Calculate current user's total score in this course
        $currentUserScore = 0;
        if ($currentUser) {
            $currentUserScore = QuizResult::where('user_id', $currentUser->id)
                ->join('lessons', 'quiz_results.lesson_id', '=', 'lessons.id')
                ->join('modules', 'lessons.module_id', '=', 'modules.id')
                ->where('modules.course_id', $courseId)
                ->sum('quiz_results.score');
        }

        // Calculate average and highest scores
        $averageScore = \DB::table('quiz_results')
            ->join('lessons', 'quiz_results.lesson_id', '=', 'lessons.id')
            ->join('modules', 'lessons.module_id', '=', 'modules.id')
            ->where('modules.course_id', $courseId)
            ->avg('quiz_results.score');

        $highestScore = \DB::table('quiz_results')
            ->join('lessons', 'quiz_results.lesson_id', '=', 'lessons.id')
            ->join('modules', 'lessons.module_id', '=', 'modules.id')
            ->where('modules.course_id', $courseId)
            ->max('quiz_results.score');

        return view('leaderboard.course', compact('users', 'course', 'currentUser', 'currentUserRank', 'currentUserScore', 'averageScore', 'highestScore'));
    }

    /**
     * Get user's global rank
     */
    private function getUserRank($userId)
    {
        if (!$userId) return null;

        $userXP = User::find($userId)?->experience ?? 0;
        $rank = User::where('experience', '>', $userXP)->count() + 1;

        return $rank;
    }

    /**
     * Get user's rank in current month
     */
    private function getUserMonthlyRank($userId, $month)
    {
        if (!$userId) return null;

        $userMonthlyScore = QuizResult::where('user_id', $userId)
            ->whereYear('created_at', $month->year)
            ->whereMonth('created_at', $month->month)
            ->sum('score');

        $rank = \DB::table('quiz_results')
            ->selectRaw('SUM(score) as total_score')
            ->whereYear('created_at', $month->year)
            ->whereMonth('created_at', $month->month)
            ->groupBy('user_id')
            ->having('total_score', '>', $userMonthlyScore)
            ->count() + 1;

        return $rank;
    }

    /**
     * Get user's rank in a specific course
     */
    private function getUserCourseRank($userId, $courseId)
    {
        if (!$userId) return null;

        $userCourseScore = QuizResult::where('user_id', $userId)
            ->join('lessons', 'quiz_results.lesson_id', '=', 'lessons.id')
            ->join('modules', 'lessons.module_id', '=', 'modules.id')
            ->where('modules.course_id', $courseId)
            ->sum('quiz_results.score');

        $rank = \DB::table('quiz_results')
            ->join('lessons', 'quiz_results.lesson_id', '=', 'lessons.id')
            ->join('modules', 'lessons.module_id', '=', 'modules.id')
            ->where('modules.course_id', $courseId)
            ->selectRaw('user_id, SUM(score) as total_score')
            ->groupBy('user_id')
            ->havingRaw('SUM(score) > ?', [$userCourseScore])
            ->count() + 1;

        return $rank;
    }
}


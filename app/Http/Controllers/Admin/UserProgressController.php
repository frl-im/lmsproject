<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Certificate;
use App\Models\QuizResult;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserProgressController extends Controller
{
    /**
     * Display list of all users with their progress
     */
    public function index(Request $request)
    {
        $query = User::where('is_admin', false);

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Sort by XP/ranking
        $sortBy = $request->input('sort', 'experience');
        if (in_array($sortBy, ['experience', 'points', 'name'])) {
            $direction = $request->input('direction', 'desc');
            $query->orderBy($sortBy, $direction);
        }

        $users = $query->paginate(20);

        // Calculate progress for each user
        foreach ($users as $user) {
            $user->progress = $this->calculateUserProgress($user);
        }

        return view('admin.user-progress.index', compact('users'));
    }

    /**
     * Show detailed progress for a specific user
     */
    public function show(User $user)
    {
        // Ensure user is not admin
        if ($user->is_admin) {
            abort(403, 'Cannot view admin user progress');
        }

        // Get user progress data
        $progress = $this->calculateUserProgress($user);
        
        // Get courses with completion status
        $courses = Course::with([
            'lessons' => function ($q) {
                $q->with('userProgress');
            }
        ])->get();

        // Map course progress
        $courseProgress = $courses->map(function ($course) use ($user) {
            $totalLessons = $course->lessons->count();
            $completedLessons = $user->lessons()
                ->wherePivot('is_completed', true)
                ->where('course_id', $course->id)
                ->count();

            return [
                'course' => $course,
                'total' => $totalLessons,
                'completed' => $completedLessons,
                'percentage' => $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0,
            ];
        });

        // Get quiz results
        $quizResults = $user->quizResults()
            ->with('lesson')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get certificates
        $certificates = $user->certificates()
            ->with('course', 'issuedBy')
            ->orderBy('earned_at', 'desc')
            ->get();

        // Get ranking info
        $globalRank = User::where('is_admin', false)
            ->where('experience', '>', $user->experience)
            ->count() + 1;

        return view('admin.user-progress.show', compact(
            'user',
            'progress',
            'courseProgress',
            'quizResults',
            'certificates',
            'globalRank'
        ));
    }

    /**
     * Show ranking overview (top 10 users)
     */
    public function rankings(Request $request)
    {
        $type = $request->input('type', 'global'); // global, monthly, course
        $courseId = $request->input('course_id');

        $query = User::where('is_admin', false);

        if ($type === 'monthly') {
            // Get ranking based on XP earned this month
            $query->select('users.*')
                ->addSelect(DB::raw('COALESCE(SUM(CASE WHEN MONTH(quiz_results.created_at) = MONTH(NOW()) AND YEAR(quiz_results.created_at) = YEAR(NOW()) THEN COALESCE(quiz_results.xp_awarded, 0) ELSE 0 END), 0) as monthly_xp'))
                ->leftJoin('quiz_results', 'users.id', '=', 'quiz_results.user_id')
                ->groupBy('users.id')
                ->orderByDesc('monthly_xp');
        } elseif ($type === 'course' && $courseId) {
            // Get ranking for specific course
            $query->select('users.*')
                ->addSelect(DB::raw('COALESCE(SUM(CASE WHEN course_id = ' . $courseId . ' THEN quiz_results.score ELSE 0 END), 0) as course_score'))
                ->leftJoin('quiz_results', 'users.id', '=', 'quiz_results.user_id')
                ->groupBy('users.id')
                ->orderByDesc('course_score');
        } else {
            // Global ranking (all time)
            $query->orderBy('experience', 'desc');
        }

        $topUsers = $query->take(100)->get();

        // Add rank, certificates info
        $topUsers = $topUsers->map(function ($user, $index) use ($type) {
            $user->rank = $index + 1;
            $user->certificates_count = $user->certificates()->count();
            return $user;
        });

        $courses = Course::all();

        return view('admin.user-progress.rankings', compact('topUsers', 'type', 'courseId', 'courses'));
    }

    /**
     * Award certificate to users (bulk action for top 3)
     */
    public function awardCertificates(Request $request)
    {
        $request->validate([
            'type' => 'required|in:global_rank_1,global_rank_2,global_rank_3,monthly_rank_1,monthly_rank_2,monthly_rank_3,course_complete',
            'course_id' => 'nullable|exists:courses,id',
            'user_ids' => 'required|array|min:1|max:3',
            'user_ids.*' => 'exists:users,id',
        ]);

        $admin = auth()->user();
        $awardedCount = 0;

        foreach ($request->user_ids as $userId) {
            $user = User::find($userId);
            if (!$user || $user->is_admin) {
                continue;
            }

            // Check if certificate already exists
            $exists = Certificate::where([
                'user_id' => $userId,
                'type' => $request->type,
                'course_id' => $request->course_id,
            ])->exists();

            if (!$exists) {
                // Determine rank from type
                preg_match('/rank_(\d+)/', $request->type, $matches);
                $rank = $matches[1] ?? null;

                Certificate::create([
                    'user_id' => $userId,
                    'course_id' => $request->course_id,
                    'type' => $request->type,
                    'rank' => $rank,
                    'earned_at' => now(),
                    'issued_by' => $admin->id,
                ]);

                $awardedCount++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Sertifikat berhasil diberikan kepada {$awardedCount} pengguna",
            'count' => $awardedCount,
        ]);
    }

    /**
     * Auto-award certificates to top 3 (one-click action)
     */
    public function autoAwardTopThree(Request $request)
    {
        $request->validate([
            'type' => 'required|in:global_rank,monthly_rank,course_rank',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $admin = auth()->user();
        $type = $request->type;
        $courseId = $request->course_id;

        // Get top 3 users based on type
        $topThree = $this->getTopThreeUsers($type, $courseId);

        $awardedCount = 0;
        foreach ($topThree as $user) {
            $rank = $user['rank'];
            $certificateType = $type === 'course_rank' 
                ? "course_rank_{$rank}" 
                : "{$type}_{$rank}";

            $exists = Certificate::where([
                'user_id' => $user['user']->id,
                'type' => $certificateType,
                'course_id' => $courseId,
            ])->exists();

            if (!$exists) {
                Certificate::create([
                    'user_id' => $user['user']->id,
                    'course_id' => $courseId,
                    'type' => $certificateType,
                    'rank' => $rank,
                    'earned_at' => now(),
                    'issued_by' => $admin->id,
                ]);

                $awardedCount++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Sertifikat berhasil diberikan kepada 3 pengguna teratas",
            'count' => $awardedCount,
            'users' => $topThree,
        ]);
    }

    /**
     * Delete certificate
     */
    public function revokeCertificate(Certificate $certificate)
    {
        $certificate->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sertifikat berhasil dicabut',
        ]);
    }

    /**
     * Calculate overall progress for a user
     */
    private function calculateUserProgress(User $user): array
    {
        // Total lessons
        $totalLessons = \App\Models\Lesson::count();
        
        // Completed lessons
        $completedLessons = $user->lessons()
            ->wherePivot('is_completed', true)
            ->count();

        // Quiz attempts & passed
        $quizAttempts = $user->quizResults()->count();
        $quizzesPasssed = $user->quizResults()
            ->where('score', '>=', 70)
            ->count();

        // Certificates
        $certificatesCount = $user->certificates()->count();

        // Calculate percentage
        $percentage = $totalLessons > 0 
            ? round(($completedLessons / $totalLessons) * 100)
            : 0;

        return [
            'total_lessons' => $totalLessons,
            'completed_lessons' => $completedLessons,
            'progress_percentage' => $percentage,
            'quiz_attempts' => $quizAttempts,
            'quizzes_passed' => $quizzesPasssed,
            'xp' => $user->experience,
            'points' => $user->points,
            'certificates' => $certificatesCount,
        ];
    }

    /**
     * Get top 3 users for certificate awarding
     */
    private function getTopThreeUsers($type, $courseId = null): array
    {
        $query = User::where('is_admin', false);

        if ($type === 'global_rank') {
            $users = $query->orderBy('experience', 'desc')->take(3)->get();
        } elseif ($type === 'monthly_rank') {
            $users = User::select('users.*')
                ->selectRaw('COALESCE(SUM(CASE WHEN MONTH(quiz_results.created_at) = MONTH(NOW()) AND YEAR(quiz_results.created_at) = YEAR(NOW()) THEN COALESCE(quiz_results.xp_awarded, 0) ELSE 0 END), 0) as monthly_xp')
                ->leftJoin('quiz_results', 'users.id', '=', 'quiz_results.user_id')
                ->where('users.is_admin', false)
                ->groupBy('users.id')
                ->orderByDesc('monthly_xp')
                ->take(3)
                ->get();
        } else {
            $users = $query->take(3)->get();
        }

        return $users->map(function ($user, $index) {
            return [
                'user' => $user,
                'rank' => $index + 1,
            ];
        })->toArray();
    }
}

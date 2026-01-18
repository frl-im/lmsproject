<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show landing page for guest users
     */
    public function index()
    {
        try {
            // Jika sudah login
            if (Auth::check()) {
                $user = Auth::user();
                
                // Redirect ke admin dashboard jika admin
                if ($user->isAdmin()) {
                    return redirect()->route('admin.dashboard');
                }
                
                // Redirect ke user dashboard
                return redirect()->route('dashboard');
            }

            // Guest - show landing page
            $courses = Course::take(6)->get(); // Tampilkan 6 course di landing
            
            return view('home.landing', compact('courses'));
        } catch (\Exception $e) {
            return view('home.landing', ['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Show free content preview (teaser)
     */
    public function previewLesson($lessonId)
    {
        try {
            // Ambil lesson dari database
            $lesson = \App\Models\Lesson::findOrFail($lessonId);
            
            // Cek apakah lesson bersifat free (teaser)
            $isFree = $lesson->is_free ?? false;
            
            if (!$isFree && !Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan Login atau Berlangganan untuk akses penuh.',
                    'require_auth' => true,
                ]);
            }

            return response()->json([
                'success' => true,
                'lesson' => $lesson,
                'is_free' => $isFree,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show user dashboard with learning progress
     */
    public function dashboard()
    {
        try {
            $user = Auth::user();
            
            // Redirect admin ke admin dashboard
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            // Get enrolled courses
            $courses = $user->courses()->withCount('modules')->get();
            
            // Get recent activity
            $recentProgress = $user->userProgresses()
                ->with('lesson.module.course')
                ->orderBy('completed_at', 'DESC')
                ->take(5)
                ->get();

            return view('dashboard', compact('courses', 'recentProgress', 'user'));
        } catch (\Exception $e) {
            return redirect()->route('home')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

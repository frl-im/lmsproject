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
            // Tampilkan landing page (REVISI: Menampilkan semua kursus, termasuk draft)
            $courses = Course::withCount('modules') // Hitung jumlah modul
                ->latest()           // Urutkan dari yang terbaru
                ->take(6)            // Ambil 6 saja
                ->get();
            
            return view('home.landing', compact('courses'));
        } catch (\Exception $e) {
            return view('home.landing', [
                'courses' => collect(), 
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show free content preview (teaser)
     */
    public function previewLesson($lessonId)
    {
        try {
            $lesson = \App\Models\Lesson::findOrFail($lessonId);
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
            
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            // Load relasi user
            $user->load('badges', 'userProgresses');

            // Ambil kursus yang diikuti user
            // Jika user belum enroll, tampilkan semua kursus agar dashboard tidak kosong
            $courses = Course::with('modules.lessons')
                ->withCount('modules')
                ->latest()
                ->get();
            
            // Hitung progress (Sederhana)
            $courses->transform(function($course) {
                $course->progress = 0; // Default 0%
                return $course;
            });

            // Activity log (defensive)
            $recentProgress = $user->userProgresses()
                ->with('lesson.module.course')
                ->orderBy('completed_at', 'DESC')
                ->take(5)
                ->get();

            $badges = $user->badges;

            return view('dashboard', compact('courses', 'recentProgress', 'user', 'badges'));
        } catch (\Exception $e) {
            return redirect()->route('home')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
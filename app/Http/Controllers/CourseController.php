<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Menampilkan daftar kursus di Dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $courses = Course::withCount('modules')->get();
        // Pastikan variabel badges selalu terkirim
        $badges = $user ? $user->badges : collect([]);

        return view('dashboard', compact('courses', 'user', 'badges'));
    }

    /**
     * Menampilkan detail kursus
     */
    public function show(Course $course)
    {
        try {
            $course->load(['modules.lessons']);
            
            $user = Auth::user();
            $badges = $user ? $user->badges : collect([]);

            return view('courses.show', compact('course', 'badges'));
        } catch (\Exception $e) {
            dd('Error di show:', $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }


        /**
     * Menampilkan kursus khusus Premium
     */
    public function premium()
    {
        $user = Auth::user();

        // Double safety (walau sudah pakai middleware premium)
        if (!$user || !$user->isPremium()) {
            abort(403, 'Fitur ini hanya untuk pengguna Premium');
        }

        // Ambil course (boleh sama / boleh dibedakan flag premium)
        $courses = Course::with(['modules.lessons'])->get();

        return view('courses.premium', compact('courses'));
    }

}
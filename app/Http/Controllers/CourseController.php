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
        // 1. Load materi dengan relasi
        $course->load(['modules.lessons']);
        
        // 2. Ambil data user & badges
        $user = Auth::user();
        $badges = $user ? $user->badges : collect([]);

        // 3. Ambil daftar semua course untuk sidebar/menu
        $courses = Course::all(); 

        // Kirim semua data ke view
        return view('courses.show', compact('course', 'badges', 'courses', 'user'));
    }
}
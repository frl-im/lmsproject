<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource for the student dashboard.
     */
    public function index()
    {
        $courses = Course::withCount('modules')->get();
        return view('dashboard', compact('courses'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load('modules.lessons'); // Eager load modules and their lessons
        return view('courses.show', compact('course'));
    }
}

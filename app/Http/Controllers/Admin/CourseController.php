<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Course::create($request->all());

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Kursus berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        // Redirect to edit view since showing is not primary
        return redirect()->route('admin.courses.edit', $course);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course->update($request->all());

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Kursus berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Kursus berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::with('module.course')->latest()->paginate(10);
        return view('admin.lessons.index', compact('lessons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = Module::with('course')->get();
        return view('admin.lessons.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
            'content' => 'required|string',
            'type' => ['required', Rule::in(['materi', 'kuis'])],
            'xp_reward' => 'required|integer|min:0',
        ]);

        Lesson::create($request->all());

        return redirect()->route('admin.lessons.index')
                         ->with('success', 'Materi/Kuis berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        return redirect()->route('admin.lessons.edit', $lesson);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        $modules = Module::with('course')->get();
        return view('admin.lessons.edit', compact('lesson', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
            'content' => 'required|string',
            'type' => ['required', Rule::in(['materi', 'kuis'])],
            'xp_reward' => 'required|integer|min:0',
        ]);

        $lesson->update($request->all());

        return redirect()->route('admin.lessons.index')
                         ->with('success', 'Materi/Kuis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('admin.lessons.index')
                         ->with('success', 'Materi/Kuis berhasil dihapus.');
    }
}

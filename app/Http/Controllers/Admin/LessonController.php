<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Module $module)
    {
        $lessons = $module->lessons()->paginate(10);
        return view('admin.lessons.index', compact('module', 'lessons'));
    }

    public function create(Module $module)
    {
        return view('admin.lessons.create', compact('module'));
    }

    public function store(Request $request, Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:materi,kuis,studi_kasus',
            'content' => 'nullable|string',
        ]);

        $module->lessons()->create($request->all());

        return redirect()->route('admin.modules.lessons.index', $module)
                         ->with('success', 'Lesson berhasil ditambahkan!');
    }

  public function edit(Lesson $lesson) // Kita akan gunakan shallow binding
{
    // Ambil module dari relasi
    $module = $lesson->module;

    return view('admin.lessons.edit', compact('module', 'lesson'));
}

    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:materi,kuis,studi_kasus',
            'content' => 'nullable|string',
        ]);

        $lesson->update($request->all());

        return redirect()->route('admin.modules.lessons.index', $lesson->module)
                         ->with('success', 'Lesson berhasil diperbarui!');
    }

    public function destroy(Lesson $lesson)
    {
        $module = $lesson->module; // Simpan module sebelum lesson dihapus
        $lesson->delete();

        return redirect()->route('admin.modules.lessons.index', $module)
                         ->with('success', 'Lesson berhasil dihapus!');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index(Course $course)
    {
        $modules = $course->modules()->orderBy('order', 'asc')->paginate(10);
        return view('admin.modules.index', compact('course', 'modules'));
    }

    public function create(Course $course)
    {
        return view('admin.modules.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|integer',
        ]);

        $course->modules()->create($request->all());

        return redirect()->route('admin.courses.modules.index', $course)
                         ->with('success', 'Module berhasil ditambahkan!');
    }

    public function edit(Course $course, Module $module)
    {
        return view('admin.modules.edit', compact('course', 'module'));
    }

    public function update(Request $request, Course $course, Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|integer',
        ]);

        $module->update($request->all());

        return redirect()->route('admin.courses.modules.index', $course)
                         ->with('success', 'Module berhasil diperbarui!');
    }

    public function destroy(Course $course, Module $module)
    {
        $module->delete();

        return redirect()->route('admin.courses.modules.index', $course)
                         ->with('success', 'Module berhasil dihapus!');
    }
}
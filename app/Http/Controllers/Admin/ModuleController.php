<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Course;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modules = Module::with('course')->latest()->paginate(10);
        return view('admin.modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return view('admin.modules.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
        ]);

        Module::create($request->all());

        return redirect()->route('admin.modules.index')
                         ->with('success', 'Modul berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        return redirect()->route('admin.modules.edit', $module);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module)
    {
        $courses = Course::all();
        return view('admin.modules.edit', compact('module', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
        ]);

        $module->update($request->all());

        return redirect()->route('admin.modules.index')
                         ->with('success', 'Modul berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()->route('admin.modules.index')
                         ->with('success', 'Modul berhasil dihapus.');
    }
}

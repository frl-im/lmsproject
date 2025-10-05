<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\ModuleController as AdminModuleController; // <-- Tambahkan ini
use App\Http\Controllers\Admin\LessonController as AdminLessonController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Grup Rute Admin
Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Rute untuk Courses (sudah ada)
        Route::resource('courses', AdminCourseController::class);

        // TAMBAHKAN RUTE BARU INI UNTUK MODULES
        Route::resource('courses.modules', AdminModuleController::class);
         // TAMBAHKAN RUTE BARU INI UNTUK LESSONS
        Route::resource('modules.lessons', AdminLessonController::class)->shallow();

    });

require __DIR__.'/auth.php';
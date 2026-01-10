<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\ModuleController as AdminModuleController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CompletionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Rute Publik
Route::get('/', function () {
    return view('welcome');
});

// 2. Rute Siswa (Setelah Login)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard siswa adalah halaman daftar kursus
    Route::get('/dashboard', [CourseController::class, 'index'])->name('dashboard');

    // Detail Kursus
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    
    // Tampilan Materi/Kuis
    Route::get('/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
    Route::post('/lessons/{lesson}/complete', [CompletionController::class, 'completeLesson'])->name('lessons.complete');

    // Papan Peringkat (Leaderboard)
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
    
    // Rute Profil Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 3. Rute Admin (Grup dengan Prefix dan Nama)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Resources untuk Admin
    Route::resource('courses', AdminCourseController::class);
    Route::resource('modules', AdminModuleController::class);
    Route::resource('lessons', AdminLessonController::class);
});

// Rute login khusus admin
Route::get('admin/login', [AuthenticatedSessionController::class, 'createAdmin'])
                ->name('admin.login');

// Mengimpor rute otentikasi bawaan Laravel Breeze
require __DIR__.'/auth.php';
<?php

use Illuminate\Support\Facades\Route;

// USER CONTROLLERS
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\CompletionController;
use App\Http\Controllers\QuizController;

// ADMIN CONTROLLERS
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\ModuleController as AdminModuleController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\QuestionController;

// AUTH
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


// ROUTE PUBLIK

    Route::get('/', function () {
        return view('welcome');
    });


// ROUTE LOGIN ADMIN

    Route::get('/admin/login', [AuthenticatedSessionController::class, 'createAdmin'])
        ->name('admin.login');


// ROUTE SISWA / USER

    Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard siswa
    Route::get('/dashboard', [CourseController::class, 'index'])
        ->name('dashboard');

    // Kursus
    Route::get('/courses/{course}', [CourseController::class, 'show'])
        ->name('courses.show');

    // Lesson (materi / quiz)
    Route::get('/lessons/{lesson}', [LessonController::class, 'show'])
        ->name('lessons.show');

    // Selesaikan lesson
    Route::post('/lessons/{lesson}/complete', [CompletionController::class, 'completeLesson'])
        ->name('lessons.complete');

    // Quiz user
    Route::get('/lessons/{lesson}/quiz', [QuizController::class, 'show'])
        ->name('quiz.show');

    Route::post('/quiz/submit', [QuizController::class, 'submit'])
        ->name('quiz.submit');

    // Leaderboard
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])
        ->name('leaderboard.index');

    // Profile (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ROUTE ADMIN

        Route::middleware(['auth', 'admin'])
            ->prefix('admin')
            ->name('admin.')
            ->group(function () {

        // Redirect root admin
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        // Dashboard admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // CRUD utama
        Route::resource('courses', AdminCourseController::class);
        Route::resource('modules', AdminModuleController::class);
        Route::resource('lessons', AdminLessonController::class);

 // 🔥 QUIZ ADMIN

        // List soal per lesson
        Route::get('lessons/{lesson}/quiz', [QuestionController::class, 'index'])
            ->name('quiz.index');

        // Form tambah soal
        Route::get('lessons/{lesson}/quiz/create', [QuestionController::class, 'create'])
            ->name('quiz.create');

        // Simpan soal
        Route::post('lessons/{lesson}/quiz', [QuestionController::class, 'store'])
            ->name('quiz.store');

        // Edit soal
        Route::get('quiz/{question}/edit', [QuestionController::class, 'edit'])
            ->name('quiz.edit');

        // Update soal
        Route::put('quiz/{question}', [QuestionController::class, 'update'])
            ->name('quiz.update');

        // Hapus soal
        Route::delete('quiz/{question}', [QuestionController::class, 'destroy'])
            ->name('quiz.destroy');
    });

// ROUTE AUTH BAWAAN
require __DIR__.'/auth.php';

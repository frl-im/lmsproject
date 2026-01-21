<?php

use Illuminate\Support\Facades\Route;

// USER CONTROLLERS
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\CompletionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ConsultController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Api\DailyMissionController;
use App\Http\Controllers\PaymentController;


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

    // Landing page (redirect based on auth status)
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    // Preview lesson untuk guest (teaser)
    Route::get('/preview/lesson/{lessonId}', [HomeController::class, 'previewLesson'])
        ->name('preview.lesson');


// ROUTE LOGIN ADMIN

    Route::get('/admin/login', [AuthenticatedSessionController::class, 'createAdmin'])
        ->name('admin.login');


// ROUTE SISWA / USER

    Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard siswa

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
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

    Route::post('/lessons/{lesson}/quiz/submit', [QuizController::class, 'submit'])
        ->name('quiz.submit');

    // Leaderboard
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])
        ->name('leaderboard.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile.show');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Finance / Subscription (BAGIAN 3)
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('index');
        Route::get('/features', [FinanceController::class, 'features'])->name('features');
        Route::post('/purchase-premium', [FinanceController::class, 'purchasePremium'])->name('purchase');
        Route::get('/status', [FinanceController::class, 'getSubscriptionStatus'])->name('status');
    });

    // 🔒 PREMIUM 
    Route::middleware(['premium'])->group(function () {
        Route::get('/courses/premium', [CourseController::class, 'premium'])->name('courses.premium');
        Route::get('/quiz/premium', [QuizController::class, 'premium'])->name('quiz.premium');
        // Route::get('/certificate', [CertificateController::class, 'index'])->name('certificate.index');
    });

    // Consult / Chat (BAGIAN 3)
    Route::prefix('consult')->name('consult.')->group(function () {
        Route::get('/', [ConsultController::class, 'index'])->name('index');
        Route::post('/send', [ConsultController::class, 'sendMessage'])->name('send');
        Route::get('/messages', [ConsultController::class, 'getMessages'])->name('messages');
        Route::patch('/messages/{messageId}/read', [ConsultController::class, 'markAsRead'])->name('mark-read');
        Route::delete('/messages/{messageId}', [ConsultController::class, 'deleteMessage'])->name('delete');
    });

    // 💳 PAYMENT / SUBSCRIPTION ROUTES
    Route::prefix('payment')->name('payment.')->group(function () {
        // Public route - upgrade page (will redirect to login if not auth)
        Route::get('/upgrade', [PaymentController::class, 'showUpgrade'])->name('upgrade');
        
        // Protected routes
        Route::middleware(['auth'])->group(function () {
            // Midtrans
            Route::get('/midtrans/checkout', [PaymentController::class, 'midtransCheckout'])->name('midtrans.checkout');
            
            // Stripe
            Route::get('/stripe/checkout', [PaymentController::class, 'stripeCheckout'])->name('stripe.checkout');
            
            // PayPal
            Route::get('/paypal/checkout', [PaymentController::class, 'paypalCheckout'])->name('paypal.checkout');
            
            // Manual Transfer
            Route::get('/manual/checkout', [PaymentController::class, 'manualCheckout'])->name('manual.checkout');
            
            // Simulasi Success
            Route::get('/simulate-success', [PaymentController::class, 'simulateSuccess'])->name('simulate-success');
            
            // Check Status
            Route::get('/check-status/{referenceCode}', [PaymentController::class, 'checkStatus'])->name('check-status');
        });
    });

// ROUTE ADMIN

    Route::middleware(['auth', 'verified', 'admin'])
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

    // API Routes for Daily Missions
    Route::middleware(['auth'])->prefix('api')->group(function () {
        Route::get('/daily-missions', [DailyMissionController::class, 'getTodaysMissions'])
            ->name('api.daily-missions.today');
        
        Route::post('/daily-missions/{mission}/complete', [DailyMissionController::class, 'completeMission'])
            ->name('api.daily-missions.complete');

        Route::get('/daily-missions/statistics', [DailyMissionController::class, 'getStatistics'])
            ->name('api.daily-missions.statistics');
    });

    }); // Close authenticated user routes

// ROUTE AUTH BAWAAN
require __DIR__.'/auth.php';

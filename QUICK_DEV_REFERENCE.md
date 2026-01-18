# 🔧 QUICK REFERENCE - LMS COMMANDS & TIPS

## 🚀 Setup & Migrations

```bash
# Run all migrations
php artisan migrate

# Check migration status
php artisan migrate:status

# Rollback last migration
php artisan migrate:rollback

# Rollback specific migration
php artisan migrate:rollback --step=1

# Refresh all
php artisan migrate:refresh --seed
```

## 🧹 Cache & Config

```bash
# Clear all cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize
php artisan optimize

# Development mode
php artisan serve
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/QuizTest.php

# With coverage
php artisan test --coverage
```

## 📊 Database Tinker

```bash
# Open tinker shell
php artisan tinker

# Check user XP
$user = User::find(1);
dd($user->experience);

# Give XP
$user->addXP(100);

# Upgrade to premium
$user->upgradeToPremium();

# Check admin status
dd($user->isAdmin());

# Get user messages
$user->messages()->latest()->get();

# Check progress
$user->userProgresses()->count();
```

## 🔍 Useful Artisan Commands

```bash
# List routes
php artisan route:list

# Show route detail
php artisan route:list | grep home

# List all models
php artisan model:list

# Show logs
tail -f storage/logs/laravel.log

# Database info
php artisan db

# Seeder run
php artisan db:seed

# Specific seeder
php artisan db:seed --class=UserSeeder
```

## 📝 Code Snippets

### Add XP to User
```php
Auth::user()->addXP(50);
```

### Check if User Completed Lesson
```php
$completed = UserProgress::hasUserCompletedLesson(
    Auth::id(), 
    $lesson->id
);
```

### Create Message
```php
Message::create([
    'user_id' => auth()->id(),
    'subject' => 'My Subject',
    'message' => 'Message content',
    'is_read' => false,
]);
```

### Get User Stats
```php
$user = Auth::user();
$xp = $user->experience;
$points = $user->points;
$isPremium = $user->isPremium();
$isAdmin = $user->isAdmin();
```

### Query Progress
```php
// Get completed lessons for user
$completed = UserProgress::where('user_id', auth()->id())
    ->where('is_completed', true)
    ->count();

// Get progress for course
$progress = $course->getProgressPercentage(auth()->id());

// Get quiz attempts
$attempts = UserProgress::where('lesson_id', $lesson->id)
    ->where('user_id', auth()->id())
    ->pluck('quiz_attempts')
    ->first();
```

## 🎯 Routes Quick Reference

### Landing & Public
```
GET  /                          Landing page
GET  /preview/lesson/{id}       Preview lesson (teaser)
GET  /admin/login               Admin login
```

### User Dashboard (Auth Required)
```
GET  /dashboard                 User dashboard
GET  /courses/{course}          View course
GET  /lessons/{lesson}          View lesson
POST /lessons/{lesson}/complete Complete lesson
GET  /lessons/{lesson}/quiz     Take quiz
POST /lessons/{lesson}/quiz/submit Submit quiz
```

### Finance (Auth Required)
```
GET  /finance                   Finance dashboard
GET  /finance/features          View features
POST /finance/purchase-premium  Buy premium (simulasi)
GET  /finance/status            Get subscription status
```

### Consult (Auth Required)
```
GET  /consult                   Chat page
POST /consult/send              Send message
GET  /consult/messages          Get messages (AJAX)
PATCH /consult/messages/{id}/read Mark as read
DELETE /consult/messages/{id}   Delete message
```

### Admin Routes
```
GET  /admin/dashboard           Admin dashboard
GET  /admin/courses             Manage courses
GET  /admin/modules             Manage modules
GET  /admin/lessons             Manage lessons
GET  /admin/lessons/{lesson}/quiz Manage quiz questions
```

## 🐛 Common Issues & Solutions

### Issue: "Ambiguous column 'id'"
**Solution**: Use specific column names in joins
```php
// WRONG
->join('modules', 'id', '=', 'lessons.module_id')

// RIGHT
->join('modules', 'modules.id', '=', 'lessons.module_id')
```

### Issue: XP awarded multiple times
**Solution**: Check `xp_awarded` flag
```php
// Check if XP already awarded
if ($progress->hasXPBeenAwarded()) {
    // Don't award XP
} else {
    // Award XP
    $user->addXP(10);
    $progress->markXPAsAwarded();
}
```

### Issue: User seeing admin content
**Solution**: Ensure middleware checking
```php
// Protect admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin routes
});

// Check in controller
if (!auth()->user()->isAdmin()) {
    return redirect('/dashboard');
}
```

### Issue: Premium not working
**Solution**: Check field in database
```php
// Make sure is_premium exists
Schema::table('users', function (Blueprint $table) {
    if (!Schema::hasColumn('users', 'is_premium')) {
        $table->boolean('is_premium')->default(false);
    }
});
```

## 📋 File Locations

```
Models:
  app/Models/User.php
  app/Models/UserProgress.php
  app/Models/Lesson.php
  app/Models/Message.php

Controllers:
  app/Http/Controllers/QuizController.php
  app/Http/Controllers/CompletionController.php
  app/Http/Controllers/HomeController.php
  app/Http/Controllers/FinanceController.php
  app/Http/Controllers/ConsultController.php

Views:
  resources/views/home/landing.blade.php
  resources/views/finance/index.blade.php
  resources/views/consult/index.blade.php

Migrations:
  database/migrations/2025_01_18_*

Routes:
  routes/web.php
  routes/auth.php (bawaan)
```

## 🎨 Tailwind Classes Used

```
Colors: blue, green, red, yellow, gray
Sizing: px-4, py-2, text-lg, text-2xl
Spacing: mb-4, mt-8, gap-6
Borders: border-2, rounded-lg, shadow-lg
Hover: hover:bg-blue-700, hover:text-white
Flex: flex, justify-center, items-center
Grid: grid, grid-cols-1, md:grid-cols-2, lg:grid-cols-3
Display: hidden, block, inline-block
Responsive: hidden, md:flex, lg:block
```

## 🔐 Security Checklist

- [x] User authentication required for dashboard
- [x] Admin middleware for admin routes
- [x] CSRF protection on forms
- [x] User can only see own data
- [x] XP can't be manipulated (anti-farming)
- [x] Premium status verified on server side
- [x] Messages only show to message owner

## 📈 Performance Tips

1. Use eager loading: `.with('modules', 'lessons')`
2. Add database indexes on foreign keys
3. Cache course list on landing page
4. Pagination for large message lists
5. Use Select in queries to limit columns

## 📞 Contact & Debug

```php
// Enable debug mode
APP_DEBUG=true

// Log errors
Log::info('Message:', ['key' => $value]);
Log::error('Error:', exception: $e);

// Check database connection
dd(DB::connection()->getPdo());

// View all queries
DB::listen(function ($query) {
    dd($query->sql);
});
```

---

**Last Updated**: 18 January 2026
**Version**: 1.0 Complete
**Status**: 🚀 Ready for Production

# Quick Reference - Quiz & Ranking System

## 🚀 Getting Started

### Test Credentials
```
Email: user@email.com
Password: user123
```

### Quick URLs
```
Home:                  http://127.0.0.1:8000
Dashboard:            http://127.0.0.1:8000/dashboard
Quiz:                 http://127.0.0.1:8000/courses/{id}/lessons/{id}/quiz
Leaderboard:          http://127.0.0.1:8000/leaderboard
Monthly Ranking:      http://127.0.0.1:8000/leaderboard/monthly
Course Ranking:       http://127.0.0.1:8000/leaderboard/course/{id}
```

---

## 📋 Key Files

### Models
- `app/Models/QuizResult.php` - Quiz attempt tracking
- `app/Models/Question.php` - MCQ questions
- `app/Models/User.php` - User with quiz relationships

### Controllers
- `app/Http/Controllers/QuizController.php`
  - `show()` - Display quiz
  - `submit()` - Handle submission

- `app/Http/Controllers/LeaderboardController.php`
  - `index()` - Global ranking
  - `monthly()` - Monthly ranking
  - `byCourse()` - Course ranking

### Views
- `resources/views/quiz/show.blade.php` - Quiz interface
- `resources/views/leaderboard/index.blade.php` - Global leaderboard
- `resources/views/leaderboard/monthly.blade.php` - Monthly leaderboard
- `resources/views/leaderboard/course.blade.php` - Course leaderboard

---

## 🎯 Core Logic

### Quiz Scoring
```php
// Calculate percentage
$percentage = ($correctAnswers / $totalQuestions) * 100;

// Check if passed (70% threshold)
$passed = $percentage >= 70;

// First attempt: create record + award XP
if (!$existingResult) {
    QuizResult::create([...]);
    User::addXP($xpReward);
}

// Retry: update only if improved
else if ($percentage > $existingResult->score) {
    $existingResult->update(['score' => $percentage]);
}
```

### Monthly Aggregation
```php
$users = User::select('users.*',
    DB::raw('SUM(quiz_results.score) as total_score'),
    DB::raw('COUNT(quiz_results.id) as quiz_count')
)
->leftJoin('quiz_results', 'users.id', '=', 'quiz_results.user_id')
->whereYear('quiz_results.created_at', $month->year)
->whereMonth('quiz_results.created_at', $month->month)
->groupBy('users.id')
->orderBy('total_score', 'desc')
->paginate(20);
```

---

## 🔧 Common Tasks

### Add Questions Programmatically
```php
Question::create([
    'lesson_id' => 1,
    'question' => 'What is 2+2?',
    'option_a' => '3',
    'option_b' => '4',
    'option_c' => '5',
    'option_d' => '6',
    'correct_answer' => 'B',
    'point' => 10,
]);
```

### Change Pass Threshold
Edit `QuizController@submit()`:
```php
// Change 70 to desired percentage
if ($percentage >= 70) {
    // Pass logic
}
```

### Adjust XP Reward
Edit `QuizController@submit()`:
```php
// Change 10 to desired XP amount
$xpReward = $lesson->xp_reward ?? 10;
```

### Reseed Questions
```bash
php artisan db:seed --class=QuestionSeeder
```

### Reset All Data
```bash
php artisan migrate:fresh --seed
```

---

## 📊 Database Quick Reference

### Quiz Results
```
id, user_id, lesson_id, total_questions, correct_answers, score, xp_earned, passed, created_at, updated_at
```

### Questions
```
id, lesson_id, question, option_a, option_b, option_c, option_d, correct_answer, point, created_at, updated_at
```

---

## 🎨 View Data Variables

### quiz/show.blade.php
```
$lesson          - Current lesson
$questions       - Quiz questions
$previousAttempt - Prior QuizResult (if exists)
```

### leaderboard/index.blade.php
```
$users           - Paginated User collection
$currentUser     - Authenticated user
$currentUserRank - User's global rank
```

### leaderboard/monthly.blade.php
```
$users                   - Paginated users with aggregated scores
$currentUser             - Authenticated user
$currentUserMonthlyRank  - User's monthly rank
$monthName               - Current month (e.g., "January 2026")
```

### leaderboard/course.blade.php
```
$course              - Course object
$users               - Paginated users with course scores
$currentUser         - Authenticated user
$currentUserRank     - User's rank in course
$currentUserScore    - User's total score in course
$averageScore        - Average score in course
$highestScore        - Highest score in course
```

---

## 🔗 Routes

### Quiz Routes
```
GET  /courses/{course}/lessons/{lesson}/quiz
POST /lessons/{lesson}/quiz/submit
```

### Leaderboard Routes
```
GET /leaderboard
GET /leaderboard/monthly
GET /leaderboard/course/{course}
```

### Named Routes in Blade
```php
route('quiz.show', [$course, $lesson])
route('quiz.submit')
route('leaderboard.index')
route('leaderboard.monthly')
route('leaderboard.course', $course)
```

---

## ✅ Testing Checklist

- [ ] Login with user@email.com
- [ ] Navigate to a course with lessons
- [ ] Open a lesson with type='kuis'
- [ ] Click quiz button
- [ ] Verify all questions load
- [ ] Select answers for all questions
- [ ] Submit quiz
- [ ] Check XP awarded (if score ≥ 70%)
- [ ] Check QuizResult created in DB
- [ ] Visit /leaderboard - see global ranking
- [ ] Visit /leaderboard/monthly - see monthly ranking
- [ ] Visit /leaderboard/course/{id} - see course ranking
- [ ] Verify current user highlighted
- [ ] Take quiz again - no XP awarded
- [ ] Check score updated if improved

---

## 🐛 Debugging

### Check Database
```bash
php artisan tinker

# Count records
>>> App\Models\Question::count()
>>> App\Models\QuizResult::count()
>>> App\Models\User::count()

# View sample data
>>> App\Models\Question::with('lesson')->first()
>>> App\Models\QuizResult::with('user', 'lesson')->first()
>>> App\Models\User::with('quizResults')->first()
```

### Check Logs
```bash
tail -f storage/logs/laravel.log
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

---

## 📈 Performance Tips

1. **Cache leaderboards**: Store static leaderboards for 1 hour
2. **Lazy load**: Don't load all users, paginate results
3. **Index foreign keys**: Add indexes on user_id, lesson_id
4. **Optimize queries**: Use select() to fetch only needed columns
5. **Monitor response time**: Log slow queries

---

## 🎓 Learning Resources

- **Laravel Docs**: https://laravel.com/docs
- **Blade Templating**: https://laravel.com/docs/blade
- **Eloquent ORM**: https://laravel.com/docs/eloquent
- **Database Queries**: https://laravel.com/docs/queries
- **Migrations**: https://laravel.com/docs/migrations

---

## 📞 Common Issues & Solutions

| Issue | Solution |
|-------|----------|
| Quiz blank | Check questions exist in DB |
| No leaderboard | Take a quiz first |
| Wrong score | Verify correct_answer field |
| No XP | Check score >= 70% and first attempt |
| Slow queries | Add database indexes |
| 404 errors | Verify routes in web.php |

---

## 🚀 Deploy Checklist

- [ ] Run migrations: `php artisan migrate`
- [ ] Seed data: `php artisan db:seed`
- [ ] Clear cache: `php artisan cache:clear`
- [ ] Test quiz flow
- [ ] Test all leaderboards
- [ ] Verify XP system
- [ ] Check anti-farming
- [ ] Test on mobile

---

**Last Updated**: January 21, 2026  
**Version**: 1.0  
**Status**: Production Ready ✅

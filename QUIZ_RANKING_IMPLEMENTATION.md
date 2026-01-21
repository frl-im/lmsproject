# Quiz & Ranking System Implementation Summary

## ✅ Completed Features

### 1. Quiz System with Multiple Choice Questions
- **Status**: FULLY IMPLEMENTED
- **Components**:
  - Quiz display page (`resources/views/quiz/show.blade.php`)
  - Quiz submission logic with scoring
  - Anti-farming mechanism (first attempt awards XP, retries don't)
  - Real-time score calculation and feedback

### 2. Quiz Database Layer
- **Models Created**:
  - `QuizResult` - Tracks all quiz attempts with scores
  - `Question` - Stores multiple choice questions with 4 options
  
- **Database Tables**:
  - `quiz_results` - Tracks user quiz attempts (user_id, lesson_id, score, xp_earned, passed)
  - `questions` - Stores MCQ questions (lesson_id, question, options A-D, correct_answer, point)

### 3. Ranking Systems (3 Types)

#### A. Global XP Leaderboard
- **Route**: `/leaderboard`
- **Controller Method**: `LeaderboardController@index()`
- **Features**:
  - Ranks users by total Experience Points
  - Shows user level (calculated from XP)
  - Displays current user's position
  - Pagination (20 per page)
  - Visual badges for top 3 users (🥇🥈🥉)

#### B. Monthly Quiz Ranking
- **Route**: `/leaderboard/monthly`
- **Controller Method**: `LeaderboardController@monthly()`
- **Features**:
  - Ranks users by total quiz scores in current month
  - Uses database aggregation (SUM of quiz_results.score)
  - Filtered by year and month using Carbon
  - Shows quiz count per user
  - Displays month name (e.g., "January 2026")

#### C. Course-Specific Ranking
- **Route**: `/leaderboard/course/{course}`
- **Controller Method**: `LeaderboardController@byCourse($courseId)`
- **Features**:
  - Ranks users by quiz performance in specific course
  - Shows total score, quiz count, and average score
  - Course statistics (total participants, average score, highest score)
  - Proper relationship joining (quiz_results → lessons → modules)

### 4. Quiz Submission & Scoring Logic

#### First Attempt:
- Creates new QuizResult entry
- Calculates percentage: (correct_answers / total_questions) × 100
- Awards XP if user passes (score ≥ 70%)
- Tracks daily mission completion
- Returns success response with detailed results

#### Retry Attempt:
- Updates existing QuizResult only if score improves
- NO XP awarded on retries (prevents farming)
- Shows message if score doesn't improve
- Allows unlimited practice

### 5. Views & User Interface

#### Quiz Show View (`resources/views/quiz/show.blade.php`)
```
✅ Quiz interface with:
- Lesson title and metadata
- Quiz information (total questions, pass threshold, XP reward)
- Radio button options for each question (A, B, C, D)
- Real-time progress tracking
- Form validation
- Submit/Cancel buttons
```

#### Leaderboard Index View (`resources/views/leaderboard/index.blade.php`)
```
✅ Global ranking with:
- User profile avatar
- Global rank position
- Current user XP and level
- Navigation to other leaderboards
- Pagination support
- Medal badges for top 3
```

#### Leaderboard Monthly View (`resources/views/leaderboard/monthly.blade.php`)
```
✅ Monthly ranking with:
- Current month name
- User quiz count in month
- Total score for month
- Current user position highlight
- Pagination support
```

#### Leaderboard Course View (`resources/views/leaderboard/course.blade.php`)
```
✅ Course-specific ranking with:
- Course title and name
- Course statistics grid
- Total participants
- Average score in course
- Highest score achieved
- User's rank in course
- Pagination support
```

## 📊 Database Schema

### quiz_results Table
```
id (PK)
user_id (FK → users) - CASCADE DELETE
lesson_id (FK → lessons) - CASCADE DELETE
total_questions (INT) - Default 0
correct_answers (INT) - Default 0
score (INT 0-100) - Default 0
xp_earned (INT) - Default 0
passed (BOOLEAN) - Default 0
created_at, updated_at (TIMESTAMPS)
```

### questions Table
```
id (PK)
lesson_id (FK → lessons) - CASCADE DELETE
question (TEXT)
option_a (TEXT)
option_b (TEXT)
option_c (TEXT)
option_d (TEXT)
correct_answer (ENUM: A|B|C|D)
point (INT) - Default 10
created_at, updated_at (TIMESTAMPS)
```

## 🛣️ Routes Implemented

```
GET  /leaderboard                      → LeaderboardController@index()      [leaderboard.index]
GET  /leaderboard/monthly              → LeaderboardController@monthly()    [leaderboard.monthly]
GET  /leaderboard/course/{course}      → LeaderboardController@byCourse()   [leaderboard.course]
GET  /courses/{course}/lessons/{lesson}/quiz → QuizController@show()       [quiz.show]
POST /lessons/{lesson}/quiz/submit     → QuizController@submit()           [quiz.submit]
```

## 🎯 Key Implementation Details

### Anti-Farming Logic
```php
// First attempt
$quizResult = QuizResult::create([...]);
$user->addXP($xpReward);

// Retry
if ($newScore > $oldScore) {
    $quizResult->update(['score' => $newScore]);
} else {
    return "Score tidak meningkat";
    // NO XP awarded
}
```

### Monthly Aggregation Query
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

## 📝 Sample Questions Seeder

- Created `QuestionSeeder.php` for generating sample quiz questions
- Each lesson gets 5 sample questions
- Questions are dynamically generated based on lesson name
- Registered in `DatabaseSeeder.php` for automatic seeding

## 🔧 Migrations Created

1. **2026_01_21_150614_create_quiz_results_table.php**
   - Tracks all quiz attempts with scores and XP

2. **2026_01_21_151615_create_questions_table.php**
   - Stores multiple choice questions

## ✅ Testing Steps

### 1. Access Quiz
```
1. Login as user@email.com / user123
2. Navigate to a course
3. Click on a lesson with type 'kuis'
4. Click "Mulai Mengerjakan Kuis"
```

### 2. Submit Quiz
```
1. Select answers for all 5 questions
2. Click "Kirim Jawaban"
3. Verify XP is awarded (first attempt only)
4. Check QuizResult is created in database
```

### 3. Check Leaderboards
```
1. /leaderboard - See global XP rankings
2. /leaderboard/monthly - See current month's rankings
3. /leaderboard/course/{courseId} - See course-specific rankings
```

### 4. Verify Anti-Farming
```
1. First attempt: Should get XP if score ≥ 70%
2. Second attempt: Should NOT get additional XP
3. If new score < old score: Show "Skor tidak meningkat"
```

## 📱 Controller Methods Overview

### QuizController
- `show(Lesson $lesson)` - Display quiz with questions
- `submit(Request $request, Lesson $lesson)` - Handle quiz submission

### LeaderboardController
- `index()` - Global XP ranking
- `monthly()` - Current month ranking
- `byCourse($courseId)` - Course-specific ranking
- `getUserRank($userId)` - Helper to calculate global rank
- `getUserMonthlyRank($userId, $month)` - Helper for monthly rank
- `getUserCourseRank($userId, $courseId)` - Helper for course rank

## 🎨 View Format

All views use the `@extends('layouts.app')` format with `@section('content')`:
- ✅ quiz/show.blade.php
- ✅ leaderboard/index.blade.php
- ✅ leaderboard/monthly.blade.php
- ✅ leaderboard/course.blade.php

## 🚀 Deployment Checklist

- [x] Quiz model and migration
- [x] Question model and migration
- [x] LeaderboardController with 3 ranking systems
- [x] Quiz submission with anti-farming logic
- [x] Question seeder with sample data
- [x] All 3 leaderboard views
- [x] Routes configured
- [x] Database seeded with questions
- [x] Views formatted correctly

## 🎯 User Request Fulfillment

**Original Request**: "Buatkan Quiz setiap akhir materi dengan soal pilihan ganda dan sistem nilai dan juga buatkan juga sistem ranking tertinggi saat mengerjakan courses di tiap bulan"

**Status**: ✅ FULLY IMPLEMENTED

- ✅ Quiz di akhir materi (setiap lesson bisa memiliki type 'kuis')
- ✅ Soal pilihan ganda (4 opsi A-B-C-D)
- ✅ Sistem nilai (scoring 0-100%, XP rewards)
- ✅ Ranking global (Global Leaderboard)
- ✅ Ranking bulanan (Monthly Ranking)
- ✅ Ranking per kursus (Course-specific Ranking)

## 📞 Support Notes

If you need to:
1. **Add more questions**: Edit `QuestionSeeder.php` and run `php artisan db:seed --class=QuestionSeeder`
2. **Adjust XP rewards**: Modify lesson's `xp_reward` field or change `quizController@submit` logic
3. **Change pass threshold**: Modify the `70` value in `QuizController@submit()`
4. **Reset rankings**: Run `php artisan migrate:fresh --seed`

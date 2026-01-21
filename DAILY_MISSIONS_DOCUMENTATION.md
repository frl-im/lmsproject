# Daily Missions Feature - Implementasi Lengkap

## 📋 Overview
Fitur "Misi Hari Ini" (Daily Missions) memungkinkan user untuk menyelesaikan 3 misi harian yang berbeda dan mendapatkan reward XP & Points.

## 🎯 Misi yang Tersedia

1. **Selesaikan 1 Materi (✓)**
   - Target: Menyelesaikan 1 lesson
   - Reward: 100 XP + 50 Points
   - Trigger: Ketika user menyelesaikan lesson

2. **Ikuti 1 Quiz (📝)**
   - Target: Menyelesaikan 1 quiz
   - Reward: 150 XP + 75 Points
   - Trigger: Ketika user submit quiz dengan score

3. **Pertahankan Streak (🔥)**
   - Target: Login/aktif 1 hari
   - Reward: 200 XP + 100 Points
   - Trigger: Ketika user aktif di hari yang sama

## 🗄️ Database Schema

### Table: `daily_missions`
```sql
- id (primary key)
- user_id (foreign key -> users)
- mission_type (enum: lesson_complete, quiz_complete, streak_maintain)
- progress (int) - Progress saat ini (0-target)
- target (int) - Target yang harus dicapai
- reward_xp (int) - Reward XP untuk mission
- reward_points (int) - Reward Points untuk mission
- is_completed (boolean) - Status penyelesaian
- mission_date (date) - Tanggal misi (unique per user per type)
- completed_at (timestamp) - Waktu penyelesaian
- created_at, updated_at
```

**Unique Constraint:** `user_id + mission_date + mission_type`

## 🔧 Models

### DailyMission Model (`app/Models/DailyMission.php`)

**Key Methods:**
- `getTodaysMissions($userId)` - Get atau create misi untuk hari ini
- `createTodaysMissions($userId)` - Create 3 misi standar untuk hari baru
- `completeProgress($increment = 1)` - Update progress misi
- `isCompleted()` - Check apakah misi sudah selesai
- `getProgress()` - Get progress (max = target)
- `getProgressPercentage()` - Get progress dalam persen

### User Model - Trait Integration
User model menggunakan trait `TracksDailyMissions` dengan methods:
- `trackLessonCompletion()` - Track lesson completion
- `trackQuizCompletion()` - Track quiz completion
- `trackStreakMaintenance()` - Track streak maintenance
- `completeDailyMission(DailyMission $mission)` - Complete mission & award rewards

## 🎬 Controllers

### DashboardController (`app/Http/Controllers/DashboardController.php`)
```php
- Fetch daily missions untuk user
- Pass ke view untuk display
```

### API DailyMissionController (`app/Http/Controllers/Api/DailyMissionController.php`)
**Routes:**
- `GET /api/daily-missions` - Get today's missions
- `POST /api/daily-missions/{mission}/complete` - Complete a mission
- `GET /api/daily-missions/statistics` - Get statistics

**Response Format:**
```json
{
  "success": true,
  "message": "Mission completed! You earned 100 XP and 50 points.",
  "reward_xp": 100,
  "reward_points": 50,
  "user_xp": 500,
  "user_points": 250,
  "mission": {
    "id": 1,
    "type": "lesson_complete",
    "is_completed": true,
    "completed_at": "2026-01-21 10:30:00"
  }
}
```

## 📱 Frontend Implementation

### Dashboard View (`resources/views/dashboard.blade.php`)

**Features:**
- Interactive mission cards dengan hover effect
- Real-time progress display
- Click to complete mission
- Animated reward notification
- Auto-update XP & Points di header

### JavaScript Functionality

1. **Mission Card Click Handler**
   - Check if mission already completed
   - Send POST request ke API
   - Update UI dengan progress
   - Show reward notification

2. **Real-time Stats Update**
   - Animate number change dari old ke new value
   - Update header XP & Points
   - Smooth 600ms animation

3. **Reward Notification**
   - Show centered modal dengan reward details
   - 2.5s auto-close
   - Bounce animation untuk visual impact

## 🔄 How It Works

### User Menyelesaikan Lesson
1. User klik tombol "Selesaikan" di lesson
2. CompletionController -> `completeLesson()`
3. Update UserProgress & award XP
4. Call `$user->trackLessonCompletion()`
5. Misi "Selesaikan 1 Materi" progress +1
6. Jika progress == target, auto-complete misi

### User Klik Mission Card
1. JavaScript detect click
2. POST ke `/api/daily-missions/{id}/complete`
3. Backend verify & complete mission
4. Award XP & Points ke user
5. Return response dengan new stats
6. Frontend update UI & show notification

## 🎨 UI Components

### Mission Card
```html
<div class="mission-card bg-white/20 rounded-xl p-4">
  <div class="text-2xl mb-2">✓</div> <!-- Icon -->
  <p class="text-xs font-semibold mb-2">Selesaikan 1 Materi</p>
  <div class="flex justify-between items-center text-xs mb-2">
    <span>0/1</span> <!-- Progress -->
  </div>
  <div class="progress-bar bg-white/20 rounded-full h-1.5">
    <div class="bg-white" style="width: 0%"></div>
  </div>
  <div class="reward-info text-xs mt-2">
    <span>+100 XP</span> • <span>+50 Pts</span>
  </div>
</div>
```

### Reward Notification
```
🎉
Misi Selesai!
⭐ +100 XP
💎 +50 Pts
```

## 🚀 API Routes

```php
// In routes/web.php
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/daily-missions', [DailyMissionController::class, 'getTodaysMissions']);
    Route::post('/daily-missions/{mission}/complete', [DailyMissionController::class, 'completeMission']);
    Route::get('/daily-missions/statistics', [DailyMissionController::class, 'getStatistics']);
});
```

## 📊 Integration Points

### CompletionController
```php
// Setelah user selesaikan lesson
$user->trackLessonCompletion();
```

### QuizController
```php
// Setelah user submit quiz pertama kali
$user->trackQuizCompletion();
```

## 🧪 Testing

### Manual Testing
1. Login sebagai user
2. Go to dashboard
3. Click salah satu mission card
4. Verify notification muncul
5. Verify XP & Points di header ter-update
6. Refresh page, verify mission status persist

### API Testing (Postman)
```
POST /api/daily-missions/1/complete
Headers:
  - X-CSRF-TOKEN: {token}
  - Content-Type: application/json
  - Accept: application/json

Response:
{
  "success": true,
  "reward_xp": 100,
  "reward_points": 50,
  "user_xp": 500,
  "user_points": 250
}
```

## 🔐 Security Features

1. **User Authorization** - Mission hanya bisa di-complete oleh owner-nya
2. **Double Completion Prevention** - Misi yang sudah selesai tidak bisa di-complete lagi
3. **CSRF Protection** - API request memerlukan CSRF token
4. **Unique Constraint** - Hanya 1 misi per user per hari per type

## 📈 Future Enhancements

1. Leaderboard berdasarkan daily missions completed
2. Streak tracking - berapa hari berturut-turut complete missions
3. Special missions pada hari-hari tertentu
4. Bonus rewards untuk complete semua 3 missions
5. Mission difficulty levels
6. Custom missions per user

## 📝 Files Modified/Created

### Created:
- `app/Models/DailyMission.php`
- `app/Traits/TracksDailyMissions.php`
- `app/Http/Controllers/Api/DailyMissionController.php`
- `database/migrations/2026_01_21_105309_create_daily_missions_table.php`

### Modified:
- `app/Models/User.php` - Add trait & relation
- `app/Http/Controllers/DashboardController.php` - Add daily missions fetch
- `app/Http/Controllers/CompletionController.php` - Add tracking
- `app/Http/Controllers/QuizController.php` - Add tracking
- `resources/views/dashboard.blade.php` - Add interactive UI & JavaScript
- `routes/web.php` - Add API routes

---

**Created:** January 21, 2026
**Status:** ✅ Complete & Tested

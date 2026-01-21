# 🎯 Quick Guide - Navigasi, Notifikasi & Quiz

## 📍 Dimana Apa Berada?

### 🔝 Header Navigation
```
[Logo] [📚 Pelajaran] [🏆 Leaderboard]        [🔔] [👤 User]
                                              ↑
                                        Click untuk buka
                                        notification
```

**Klik Navigation**:
- "📚 Pelajaran" → Kembali ke dashboard
- "🏆 Leaderboard" → Buka global leaderboard

---

## 📚 Pelajaran / Lesson

### Di Halaman Lesson
```
┌─────────────────────────────┐
│ Judul Lesson                │
├─────────────────────────────┤
│ [Konten Lesson]             │
├─────────────────────────────┤
│ [Tombol Aksi]               │  ← Ada 2 jenis:
├─────────────────────────────┤
│ Prev | Progress | Next      │
└─────────────────────────────┘

TYPE 'MATERI':
  ✅ Button: "Tandai Selesai & Klaim XP"
  → Klik untuk selesaikan & dapat XP
  → Notifikasi otomatis muncul

TYPE 'KUIS':
  📝 Button: "Mulai Kuis"
  → Klik untuk mulai quiz
  → 5 soal pilihan ganda
  → Notifikasi hasil otomatis
```

---

## 🧪 Mengerjakan Quiz

### Step by Step

**1. Open Quiz**
```
Klik "Mulai Kuis" di lesson type='kuis'
                    ↓
        /courses/{}/lessons/{}/quiz
                    ↓
        Halaman quiz dengan soal
```

**2. Isi Soal**
```
┌─ 1. Pertanyaan? ──────────────┐
│  ○ Opsi A                     │
│  ○ Opsi B ✓ (pilih)           │
│  ○ Opsi C                     │
│  ○ Opsi D                     │
└───────────────────────────────┘

Setiap soal harus dijawab!
Progress bar menunjukkan progress
```

**3. Submit**
```
Click "Kirim Jawaban"
                    ↓
        Server process
                    ↓
    ┌─ Hasil Quiz ──────┐
    │ Score: XX%        │
    │ Jawab: X/5        │
    │ XP: +XX (jika ≥70%)
    └───────────────────┘
                    ↓
        Notifikasi otomatis
```

---

## 🔔 Notification System

### Notification Bell

**Lokasi**: Top right di header (sebelum user menu)

**Tampilan Normal**:
```
🔔 
(tanpa dot)
```

**Ada Notifikasi**:
```
🔔 ← Red dot di atas
●
```

### Buka Notification Dropdown

**Klik bell icon** → Dropdown terbuka

```
┌─────────────────────────────┐
│ Notifikasi                  │
├─────────────────────────────┤
│ ✅ Materi "xxx" selesai!    │
│    Baru saja                │
│                             │
│ 📝 Selamat! Lulus Kuis!     │
│    Baru saja                │
│                             │
│ ✅ Materi "yyy" selesai!    │
│    1 menit yang lalu        │
└─────────────────────────────┘
```

**Close**: Klik di luar dropdown atau klik area manapun

---

## 🏆 Leaderboard

### Akses Leaderboard

**Option 1: Dari Navbar**
```
Klik "🏆 Leaderboard" di header
        ↓
    /leaderboard (Global)
```

**Option 2: Dari Dashboard**
```
Dashboard ada 2 cards:
  │
  ├─ 📊 Global Leaderboard
  │  Klik → /leaderboard
  │
  └─ 📅 Ranking Bulanan
     Klik → /leaderboard/monthly
```

**Option 3: Direct URL**
```
Global:    /leaderboard
Monthly:   /leaderboard/monthly
By Course: /leaderboard/course/{courseId}
```

### Lihat di Leaderboard

```
┌────────────────────────────────┐
│ Rank │ Player  │ XP  │ Level   │
├────────────────────────────────┤
│ 🥇   │ Player1 │ 500 │ Lvl 5   │
│ 🥈   │ Player2 │ 450 │ Lvl 4   │
│ 🥉   │ Player3 │ 400 │ Lvl 4   │
│  #4  │ You     │ 350 │ Lvl 3 ← Highlighted
│  #5  │ Player5 │ 300 │ Lvl 3   │
└────────────────────────────────┘
```

---

## 📊 Leaderboard Types

### 1. Global Leaderboard (XP Based)
```
URL: /leaderboard

Ranking berdasarkan:
- Total Experience Points
- User Level

Info:
- Rank position
- Total XP
- Level calculated
- Quiz count
- User position highlighted
```

### 2. Monthly Leaderboard (Quiz Scores)
```
URL: /leaderboard/monthly

Ranking berdasarkan:
- Total quiz scores bulan ini
- Current month only

Info:
- Rank in month
- Quiz attempts
- Score total
- Month name (Jan 2026)
```

### 3. Course Leaderboard
```
URL: /leaderboard/course/{courseId}

Ranking berdasarkan:
- Quiz scores in specific course
- Course-filtered only

Info:
- Course rank
- Score in course
- Course statistics
- Avg score
- Highest score
```

---

## 🎯 Notification Examples

### Lesson Complete
```
⏱️ Saat: User klik "Tandai Selesai"

Toast (3 detik):
  ✨ Selamat! +10 XP

Bell Dropdown:
  ✅ Materi "Pengenalan Python" selesai!
     Baru saja
```

### Quiz Pass (Score ≥ 70%)
```
⏱️ Saat: User submit quiz dengan score ≥70%

Result Alert:
  🎉 Selamat! Kamu Lulus Kuis!
  Skor: 85%
  Benar: 4/5
  XP: +10

Bell Dropdown:
  📝 Selamat! Kamu Lulus Kuis!
     Baru saja
```

### Quiz Fail (Score < 70%)
```
⏱️ Saat: User submit quiz dengan score <70%

Result Alert:
  Oops! Skor Kurang
  Skor: 60%
  Benar: 3/5
  Untuk lulus: minimal 70%
  [Coba Lagi]

Bell Dropdown:
  📝 Oops! Skor Kurang
     Baru saja
```

---

## 🎮 Full User Journey

```
START
  │
  ├─→ Login
  │    │
  │    └─→ DASHBOARD
  │         │
  │         ├─→ [📚 Pelajaran] (stay here)
  │         │
  │         ├─→ [🏆 Leaderboard]
  │         │    └─→ View global ranking
  │         │
  │         ├─→ [📊 Global Leaderboard Card]
  │         │    └─→ /leaderboard
  │         │
  │         ├─→ [📅 Monthly Ranking Card]
  │         │    └─→ /leaderboard/monthly
  │         │
  │         ├─→ Select Course
  │         │    │
  │         │    └─→ COURSE PAGE
  │         │         │
  │         │         └─→ Select Lesson
  │         │              │
  │         │              └─→ LESSON PAGE
  │         │                   │
  │         │                   ├─→ Type 'materi'
  │         │                   │    │
  │         │                   │    └─→ Click "Tandai Selesai"
  │         │                   │         │
  │         │                   │         ├─→ Toast: ✨ +XP
  │         │                   │         ├─→ Bell: Red dot
  │         │                   │         └─→ Notification: ✅ Selesai
  │         │                   │
  │         │                   └─→ Type 'kuis'
  │         │                        │
  │         │                        └─→ Click "Mulai Kuis"
  │         │                             │
  │         │                             └─→ QUIZ PAGE
  │         │                                  │
  │         │                                  ├─→ Answer Questions
  │         │                                  │
  │         │                                  └─→ Submit
  │         │                                       │
  │         │                                       ├─→ Result Alert
  │         │                                       ├─→ Bell: Red dot
  │         │                                       └─→ Notification
  │         │
  │         └─→ Click [🔔] Bell
  │              │
  │              └─→ View all notifications
  │                   - ✅ Lesson completed
  │                   - 📝 Quiz results
  │                   - 🎉 Achievements
  │
  └─→ [👤 User Menu]
       │
       ├─→ Lihat Profil
       ├─→ Edit Profil
       └─→ Logout

```

---

## ⚡ Quick Tips

### Shortcuts
- **Dashboard**: Click logo "LMS Pro"
- **Leaderboard**: Click "🏆 Leaderboard"
- **Notifications**: Click "🔔" bell
- **Profile**: Click user avatar

### Dashboard Shortcuts
- **Global Rank**: Click blue card "Lihat Ranking Global"
- **Monthly Rank**: Click yellow card "Lihat Score Bulan Ini"

### Navigation
- **Back**: Use browser back button or click previous lesson
- **Next**: Click next lesson or continue button

### Quiz Tips
- **Must answer all**: Progress bar shows answered
- **Min 70%**: To pass and get XP
- **Can retry**: No XP on retry, but can improve score
- **See result**: Notification shows automatically

---

## 🎓 Features Summary

| Feature | Where | How |
|---------|-------|-----|
| Navigation | Header | Click menu items |
| Leaderboard | Navbar/Cards | Click link |
| Notifications | Bell icon | Click 🔔 |
| Quiz | Lesson page | Click "Mulai Kuis" |
| Dashboard | Navbar | Click logo |
| Profile | Navbar | Click avatar |
| Logout | Navbar | Click avatar → Logout |

---

## ✅ Verification

**All working?**
- [ ] Navigation menu visible
- [ ] Leaderboard link works
- [ ] Notification bell visible
- [ ] Quiz button shows for quiz lessons
- [ ] Notifications trigger correctly
- [ ] Dashboard shortcuts visible

**If any issue?**
- Try refreshing page (F5)
- Clear browser cache
- Check browser console (F12)
- Restart server: `php artisan serve`

---

**Enjoy your LMS! 🚀**

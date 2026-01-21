# 🎖️ ADMIN CERTIFICATES & PROGRESS MONITORING - QUICK REFERENCE

## 🔗 Access Points

```
Dashboard Admin → Buttons:
├── 📊 Pantau Progress User
│   └── /admin/users/progress
│       ├── List all users with progress
│       ├── Click user → Detail page
│       └── Award certificates individually
│
├── 🏆 Lihat Ranking
│   └── /admin/rankings
│       ├── Global ranking (all-time XP)
│       ├── Monthly ranking (this month)
│       ├── Course ranking (per course)
│       └── Auto-Award top 3 (one-click)
│
└── Other links...
    ├── Manage Courses
    ├── Manage Lessons
    └── Manage Questions
```

---

## 📊 USER PROGRESS PAGE

**URL:** `/admin/users/progress`

### Features:
- List all non-admin users (20 per page)
- **Search:** By name or email
- **Sort:** By XP, Name, or Points
- **View per user:**
  - Name & email
  - Total XP (⭐)
  - Progress % with bar
  - Quiz passed/total
  - Certificates count
  - 👁️ "Lihat" button → Detail

### Quick Action:
```
Search: "Ahmad" → Find Ahmad
Sort: By XP → See top performers
Click: "👁️ Lihat" → View detailed progress
```

---

## 👁️ USER DETAIL PAGE

**URL:** `/admin/users/{user}/progress`

### Displays:
```
HEADER
├─ User name & email
└─ Total XP (large icon)

STAT CARDS (4 boxes)
├─ 🏅 Global Rank
├─ 📚 Progress %
├─ ✅ Quiz Passed (X/Y)
└─ 🎖️ Certificates (count)

COURSE PROGRESS (LEFT)
├─ Course 1 [████░░] 80%
├─ Course 2 [██░░░░] 35%
└─ Course 3 [██████░] 85%

QUIZ RESULTS (LEFT)
├─ Quiz Name | Score | XP | Date
├─ Materi 1  | 95%   | +20| Jan 10
└─ Quiz ...

CERTIFICATES (RIGHT)
├─ 🥇 Peringkat 1 | Jan 15 | ✕
├─ 🥈 Peringkat 2 | Jan 10 | ✕
└─ [🎖️ Award Certificate] ← Button
```

### Actions:
1. **View in Detail** - See complete history
2. **Award Certificate** - Click button → Modal
3. **Revoke Certificate** - Click ✕ on cert
4. **Back to List** - Back to /progress

---

## 🏆 RANKINGS PAGE

**URL:** `/admin/rankings`

### Filter Options:

#### Global Ranking (Default)
- Shows: All-time XP
- Metric: ⭐ total experience
- Top users: Sorted by XP

#### Monthly Ranking
- Shows: XP earned this month
- Metric: 📅 monthly_xp
- Top users: Sorted by this month

#### Course Ranking
- Shows: Score in specific course
- Metric: 📊 quiz score
- Select course → See rankings

### Display:

```
[Dropdown: Ranking Type] [Dropdown: Course (if needed)]
[⚡ Auto-Award Top 3 Sertifikat]

TOP 3 HIGHLIGHT CARDS:
┌──────────────┬──────────────┬──────────────┐
│ 🥇 PERINGKAT │ 🥈 PERINGKAT │ 🥉 PERINGKAT │
│      1       │      2       │      3       │
│              │              │              │
│ Name         │ Name         │ Name         │
│ email@...    │ email@...    │ email@...    │
│ ⭐ 5000 XP   │ ⭐ 4500 XP   │ ⭐ 4000 XP   │
│              │              │              │
│ [🎖️ Award]  │ [🎖️ Award]  │ [🎖️ Award]  │
└──────────────┴──────────────┴──────────────┘

FULL TABLE:
┌────┬──────┬────────┬─────┬──────┬──────┐
│Rank│Name  │Email   │XP   │Cert  │Action│
├────┼──────┼────────┼─────┼──────┼──────┤
│🥇 1│Ahmad │a@...   │5000 │  2   │👁️🎖️│
│🥈 2│Budi  │b@...   │4500 │  1   │👁️🎖️│
│🥉 3│Citra │c@...   │4000 │  0   │👁️🎖️│
│ 4  │Dono  │d@...   │3500 │  0   │👁️🎖️│
│...
└────┴──────┴────────┴─────┴──────┴──────┘
```

### Actions:
1. **View User** - Click 👁️ icon
2. **Award Certificate** - Click 🎖️ icon
3. **Auto-Award Top 3** - Button at top

---

## 🎖️ AWARD CERTIFICATE - MANUAL

**Where:** User Detail page or Rankings page

### Steps:
```
1. Click "🎖️ Award Certificate" button
   ↓
2. Modal opens:
   ┌─────────────────────────────────┐
   │ 🎖️ Berikan Sertifikat           │
   ├─────────────────────────────────┤
   │ Tipe Sertifikat:                │
   │ [Dropdown ▼]                    │
   │ Options:                        │
   │ - 🥇 Peringkat 1 Global         │
   │ - 🥈 Peringkat 2 Global         │
   │ - 🥉 Peringkat 3 Global         │
   │ - 🥇 Peringkat 1 Bulanan        │
   │ - 🥈 Peringkat 2 Bulanan        │
   │ - 🥉 Peringkat 3 Bulanan        │
   │ - ✨ Selesai Kursus             │
   │                                 │
   │ Kursus (Opsional):              │
   │ [Dropdown ▼]                    │
   │ Options: (list of courses)      │
   │                                 │
   │ [Batal] [Berikan]               │
   └─────────────────────────────────┘
   ↓
3. Select type (required)
4. Select course (optional)
5. Click "Berikan"
   ↓
6. Alert: "Sertifikat berhasil diberikan"
7. Page refreshes
8. Certificate now shows in list
```

### Certificate Types:

| Icon | Type | Used For |
|------|------|----------|
| 🥇 | Rank 1 | Top user |
| 🥈 | Rank 2 | 2nd place |
| 🥉 | Rank 3 | 3rd place |
| ✨ | Complete | Course completion |

---

## ⚡ AUTO-AWARD TOP 3 - ONE-CLICK

**Where:** Rankings page (`/admin/rankings`)

### Steps:
```
1. Go to /admin/rankings
   ↓
2. Select type:
   ├─ Global (default)
   ├─ Monthly
   └─ Course (select course)
   ↓
3. If Course: Select course from dropdown
   ↓
4. Click "⚡ Auto-Award Top 3 Sertifikat"
   ↓
5. Confirm: "Berikan sertifikat kepada 3 pengguna teratas?"
   [YES] [NO]
   ↓
6. If YES:
   - System gets top 3 users
   - Creates certificates rank 1, 2, 3
   - Auto-detects duplicates
   - Shows: "Sertifikat berhasil diberikan kepada 3 pengguna"
   ↓
7. Page refreshes
8. Top 3 cards now show certificates
```

### What Happens:
```
Auto-Award Logic:
├─ Get top 3 users (by type)
├─ For each user:
│  ├─ Check: Certificate already exists?
│  ├─ If NO: Create certificate
│  └─ If YES: Skip (no duplicate)
├─ Count created certificates
└─ Return result message

Results:
├─ 3 users: "3 sertifikat berhasil"
├─ 2 users: "2 sertifikat berhasil" (1 was duplicate)
├─ 1 user: "1 sertifikat berhasil" (2 were duplicates)
└─ 0 users: "Tidak ada sertifikat baru" (all duplicates)
```

---

## 🎯 CERTIFICATE TYPES REFERENCE

```
TYPE                    | RANK | USE CASE
─────────────────────────┼──────┼────────────────────────
global_rank_1          | 1    | Top user (all-time XP)
global_rank_2          | 2    | 2nd place (all-time)
global_rank_3          | 3    | 3rd place (all-time)
monthly_rank_1         | 1    | Top this month
monthly_rank_2         | 2    | 2nd this month
monthly_rank_3         | 3    | 3rd this month
course_complete        | —    | Course completion
```

---

## 📱 MOBILE USAGE

```
Pantau Progress User (Mobile):
├─ Full-width search bar
├─ Stacked table columns
├─ Swipe-able results
├─ Large touch buttons
└─ Pagination at bottom

Rankings (Mobile):
├─ Dropdown filters stack
├─ Top 3 cards stack vertically
├─ Table scrolls horizontally
└─ Large award buttons
```

---

## 🔄 WORKFLOW EXAMPLES

### Example 1: Award Certificates After Monthly Ranking
```
Time: End of month (e.g., Jan 31)

Admin Workflow:
1. Go to /admin/rankings
2. Change type to "Monthly"
3. Verify top 3 users
4. Click "⚡ Auto-Award Top 3"
5. Confirm
6. Done! Each top 3 get 1 certificate

Result:
├─ 🥇 Ahmad → monthly_rank_1 certificate
├─ 🥈 Budi → monthly_rank_2 certificate
└─ 🥉 Citra → monthly_rank_3 certificate
```

### Example 2: Monitor Struggling Student
```
Admin Workflow:
1. Go to /admin/users/progress
2. Sort by XP ascending (lowest first)
3. Find struggling student (low XP)
4. Click "👁️ Lihat"
5. See: Progress 20%, quizzes failing, no XP
6. Action: Send message/support
7. Revisit later to check improvement
```

### Example 3: Award Course Completion
```
Admin Workflow:
1. Go to /admin/users/progress
2. Find student with 100% on a course
3. Click "👁️ Lihat"
4. Scroll to Certificates section
5. Click "🎖️ Award Certificate"
6. Select type: "✨ Selesai Kursus"
7. Select course: "Python Basics"
8. Click "Berikan"
9. Certificate now shows with date

Result:
├─ User sees certificate on profile
├─ Badge in database
└─ Admin can revoke if needed
```

---

## ⚙️ ADMIN DROPDOWN MENU

In navbar when logged in as admin:

```
Dashboard Admin:
├─ 📊 Pantau Progress User
├─ 🏆 Lihat Ranking
├─ Manage Courses
├─ Manage Modules
├─ Manage Lessons
├─ Manage Quiz Questions
└─ Settings
```

---

## 🆘 COMMON ISSUES

### Q: Can't find user progress page
**A:** Go to Admin Dashboard, click "📊 Pantau Progress User" button

### Q: Top 3 already have certificates
**A:** Auto-award detects duplicates automatically (won't create again)

### Q: How to remove a certificate?
**A:** On user detail page, click ✕ next to certificate

### Q: Ranking not updating?
**A:** Page loads latest data each time. Just refresh or navigate away/back

### Q: Can't see course ranking?
**A:** Rankings dropdown → Select "Course" → Choose course from dropdown

### Q: User has 0 XP
**A:** They haven't taken any quizzes or quizzes weren't scored. Check quiz_results table

---

## 📊 COLUMNS EXPLAINED

**In User List:**
- `#` - Row number (pagination offset)
- `Nama` - Full name
- `Email` - Email address
- `XP` - Total experience points (⭐)
- `Progress` - Percent & bar (lessons completed/total)
- `Quiz` - Passed/Total attempts (green/orange)
- `Sertifikat` - Count of certificates (🎖️)
- `Aksi` - Action button (👁️ Lihat)

**In Rankings:**
- `Peringkat` - Rank (1-100)
- `Nama` - User name
- `Email` - Email address
- `XP/Score` - Metric based on ranking type
- `Sertifikat` - Count awarded
- `Aksi` - View/Award buttons

**In Detail Page:**
- Course section: Name | Progress % | Bar | Completed/Total
- Quiz section: Quiz Name | Score | XP Earned | Date
- Certificate section: Type | Rank | Date | Remove ✕

---

## 🎨 COLOR CODING

```
Backgrounds:
├─ 🥇 Gold → Rank 1 (golden)
├─ 🥈 Silver → Rank 2 (gray)
├─ 🥉 Bronze → Rank 3 (orange)
└─ ✨ White → Generic certificates

Status Colors:
├─ Blue → Information/Links
├─ Green → Success/Passed
├─ Yellow → XP/Points
├─ Purple → Certificates/Special
├─ Orange → Warnings/Low score
└─ Red → Delete/Revoke
```

---

**Quick Tip:** Bookmark `/admin/rankings` for daily monitoring!

# 🧪 TESTING & DEMO GUIDE

## Prerequisites
- Laravel server running (`php artisan serve` atau Laragon)
- Database properly configured
- Assets built (`npm run build`)
- Test user accounts created

---

## 📝 SETUP TEST DATA

### 1. Create Test Users

```bash
php artisan tinker
```

Paste this in tinker:

```php
// Admin user
\App\Models\User::create([
    'name' => 'Admin User',
    'email' => 'admin@test.com',
    'password' => bcrypt('password'),
    'is_admin' => true,
    'email_verified_at' => now(),
]);

// Student user
\App\Models\User::create([
    'name' => 'Siswa User',
    'email' => 'siswa@test.com',
    'password' => bcrypt('password'),
    'is_admin' => false,
    'email_verified_at' => now(),
]);

exit;
```

---

## 🚀 TEST 1: AUTH SYSTEM

### Objective
Verify that admin and student login routes correctly based on `is_admin` flag.

### Steps

#### A. Test Admin Login
```
1. Open http://localhost:8000/admin/login
2. Email: admin@test.com
3. Password: password
4. Click "Login Admin"
5. Expected: Redirect to http://localhost:8000/admin/dashboard
6. Check: Browser URL shows /admin/dashboard
7. Check: You see admin navigation & dashboard
```

#### B. Test Student Login
```
1. Logout if logged in (top right menu)
2. Open http://localhost:8000/login
3. Email: siswa@test.com
4. Password: password
5. Click "Login Siswa"
6. Expected: Redirect to http://localhost:8000/dashboard
7. Check: Browser URL shows /dashboard
8. Check: You see student navigation & courses list
```

#### C. Test Admin Can't Be Redirected
```
1. Login as admin
2. Try to access /dashboard (student dashboard)
3. Expected: Page works but no issues
4. Try to access /admin/dashboard directly
5. Expected: Loads correctly
6. Refresh /admin/dashboard
7. Expected: Still on admin dashboard (not redirected to student)
```

#### D. Test Session Persistence
```
1. Login as admin
2. Refresh page multiple times
3. Expected: Stay logged in as admin
4. Open DevTools → Application → Cookies
5. Check: XSRF-TOKEN & LARAVEL_SESSION cookies present
6. Logout
7. Expected: Redirect to / (home)
8. Check: Cookies cleared
```

**Result:** ✅ PASS if all redirects work correctly and sessions persist

---

## 🎓 TEST 2: ADMIN QUIZ MANAGEMENT

### Objective
Verify admin can create, read, update, delete quiz questions.

### Prerequisites
- Login as admin
- Need a lesson with type='kuis'

### Steps

#### A. Create a Quiz Lesson (if needed)

```
1. Go to /admin/lessons
2. Click "Create Lesson"
3. Title: "Matematika Dasar Quiz"
4. Type: "kuis"
5. Content: "Test your basic math skills"
6. XP Reward: 20
7. Click "Create"
8. Note the lesson ID (e.g., /admin/lessons/5)
```

#### B. Test Add Question

```
1. Go to http://localhost:8000/admin/lessons/{ID}/quiz
2. Click "+ Tambah Soal" button (blue button top right)
3. Expected: Redirect to /admin/lessons/{ID}/quiz/create
4. Fill form:
   Pertanyaan: "Berapakah hasil dari 5 + 3?"
   Opsi A: "6"
   Opsi B: "8"
   Opsi C: "10"
   Opsi D: "12"
   Jawaban Benar: Select "B"
   Poin: 10
5. Click "Simpan Soal" button
6. Expected: 
   - Redirect back to quiz index
   - Green success message appears
   - Question listed in table
   - Shows: No. 1, Pertanyaan, Jawaban (B), Poin (10)
```

#### C. Test Edit Question

```
1. In question list, find your question
2. Click "Edit" button (blue link)
3. Expected: Redirect to /admin/quiz/{ID}/edit
4. Check form is pre-filled with correct data
5. Change question text to: "Berapakah hasil dari 5 + 3? (Edited)"
6. Click "Update Soal"
7. Expected: 
   - Back to list
   - Green success message
   - Question text updated in table
```

#### D. Test Delete Question

```
1. In question list, find your question
2. Click "Hapus" button (red link)
3. Expected: Browser confirmation dialog appears
   "Yakin hapus soal ini?"
4. Click "OK" to confirm
5. Expected:
   - Delete request sent
   - Redirect to quiz index
   - Green success message
   - Question removed from table
   - Table now empty or shows other questions
```

#### E. Test Add Multiple Questions

```
1. Repeat step B three more times with different questions:
   Q1: "2+2=?" Options: [3,4,5,6] Answer: B (4)
   Q2: "5+5=?" Options: [8,10,12,15] Answer: B (10)
   Q3: "10-5=?" Options: [3,5,7,9] Answer: B (5)
2. Expected: All 3 questions in list
3. Verify each has correct answer shown
4. Verify point column shows correct values
```

**Result:** ✅ PASS if all CRUD operations work without errors

---

## 🎮 TEST 3: STUDENT QUIZ TAKING

### Objective
Verify student can take quiz and system calculates score correctly.

### Prerequisites
- Logged in as student
- Quiz lesson exists with questions
- Must have at least 4 questions (for 75% passing test)

### Steps

#### A. Navigate to Quiz

```
1. Go to http://localhost:8000/dashboard
2. Find a course
3. Click on course to see modules
4. Click on module to see lessons
5. Find quiz lesson (type=kuis)
6. Expected: Lesson shows "Mulai Mengerjakan Kuis →" button (purple)
7. Click the button
8. Expected: Redirect to /lessons/{ID}/quiz
```

#### B. Take Quiz (Passing Scenario)

```
1. On quiz page, see all questions numbered
2. Each question shows:
   - Question text
   - Radio buttons for A, B, C, D options
3. Answer questions correctly:
   Q1: Select B (correct)
   Q2: Select B (correct)
   Q3: Select B (correct)
   Q4: Select A (wrong)
4. Result: 3/4 = 75% (should PASS since ≥70%)
5. Click "Kirim Jawaban" button (green)
6. Expected:
   - Page processes and redirects
   - Green success box appears
   - Shows: "🎉 Selamat! Kamu Lulus Kuis!"
   - Shows: "Skor: 75% (3/4 Benar)"
   - Shows: "✨ Kamu mendapatkan 20 XP!"
   - Shows: "Nilai Akhir: 30 poin"
7. Check: Lesson marked as completed
8. Check: XP added to user profile
```

#### C. Take Quiz (Failing Scenario)

```
1. Go to different quiz lesson (if available) or retry
2. Answer questions mostly wrong:
   Q1: Select A (wrong)
   Q2: Select C (wrong)
   Q3: Select B (correct)
   Q4: Select B (correct)
3. Result: 2/4 = 50% (should FAIL since <70%)
4. Click "Kirim Jawaban"
5. Expected:
   - Page processes and redirects
   - Orange warning box appears
   - Shows: "Oops! Skor Kurang"
   - Shows: "Skor: 50% (2/4 Benar)"
   - Shows: "Untuk lulus, kamu butuh minimal 70%"
   - Shows: "Coba Lagi" button
6. Check: "Coba Lagi" button visible
7. Click "Coba Lagi"
8. Expected: Form still shows but previous answers cleared
9. Answer differently & submit again
```

#### D. Test Quiz Attempt Counter

```
1. After multiple attempts, check user_progress table:
   SELECT * FROM user_progress WHERE lesson_id={ID} AND user_id={USERID}
2. Expected: quiz_attempts = number of attempts made
3. Verify quiz_score stores last attempt percentage
4. Verify completed_at is NULL if never passed (or passed only)
```

#### E. Test Previously Completed Quiz

```
1. If you already passed a quiz
2. Go back to lesson
3. Click "Mulai Quiz" button again
4. Expected: Get warning message at top:
   "✓ Kuis Sudah Diselesaikan"
   Shows last score percentage & attempts
   Option to review results or back button
5. Verify button changes to "Review Results"
```

**Result:** ✅ PASS if scoring works, XP awarded, and attempt tracking accurate

---

## 🎨 TEST 4: UI/UX POLISH

### Objective
Verify all auth pages are properly themed and responsive.

### Steps

#### A. Login Page Design

```
1. Open http://localhost:8000/login
2. Visual Check:
   ☑️ Blue gradient background
   ☑️ "🚀 LMS Gamifikasi" title visible
   ☑️ "Login Siswa - Mulai Petualangan Belajar!" subtitle
   ☑️ White card with form
   ☑️ Email input with 📧 icon
   ☑️ Password input with 🔐 icon
   ☑️ Blue submit button
   ☑️ "Forgot password?" link
   ☑️ "Daftar di sini" register link
   ☑️ "Admin?" link at bottom
3. Interaction Check:
   ☑️ Hover submit button → see scale effect
   ☑️ Focus inputs → see blue ring
   ☑️ Mobile: Responsive layout
4. Dark Mode Check:
   ☑️ Open DevTools
   ☑️ Toggle dark mode (Ctrl+Shift+P > Dark)
   ☑️ Check colors adjust properly
```

#### B. Register Page Design

```
1. Open http://localhost:8000/register
2. Visual Check:
   ☑️ Green gradient background
   ☑️ "🎮 LMS Gamifikasi" title
   ☑️ "Daftar & Mulai Belajar dengan Asyik!" subtitle
   ☑️ White card with form
   ☑️ Name input with 👤 icon
   ☑️ Email input with 📧 icon
   ☑️ Password inputs with 🔐 ✓ icons
   ☑️ Info box with 💡 tip
   ☑️ Green submit button
   ☑️ Login link for existing users
   ☑️ Back to home link
3. Interaction Check:
   ☑️ Submit button hover effect
   ☑️ Input focus rings
   ☑️ Mobile responsive
4. Dark Mode:
   ☑️ Colors adjust in dark mode
```

#### C. Admin Login Design

```
1. Open http://localhost:8000/admin/login
2. Visual Check:
   ☑️ Dark gradient background (professional)
   ☑️ "🔐 Admin Panel" title
   ☑️ "LMS Gamifikasi - Area Administrasi" subtitle
   ☑️ Dark gray card with amber border
   ☑️ Email input with dark bg & amber focus
   ☑️ Password input with dark bg & amber focus
   ☑️ Warning box with amber border
   ☑️ Amber gradient submit button
   ☑️ "Bukan admin?" link with blue color
3. Interaction Check:
   ☑️ Hover effects work
   ☑️ Focus states show amber ring
   ☑️ Mobile responsive
```

#### D. Mobile Responsiveness

```
1. Open http://localhost:8000/login
2. DevTools → Toggle device toolbar (Ctrl+Shift+M)
3. Test sizes:
   ☑️ iPhone SE (375px): Form stacks properly
   ☑️ iPhone 12 (390px): Looks good
   ☑️ iPad (768px): Two-column layout if available
   ☑️ Desktop (1920px): Centered form
4. Check:
   ☑️ Text readable
   ☑️ Buttons clickable (48px min)
   ☑️ Form inputs not cut off
   ☑️ No horizontal scroll
5. Test same on register & admin-login pages
```

#### E. Form Validation Errors

```
1. Open login page
2. Try to submit without filling email
3. Expected: Error message appears below email field
4. Same for password field
5. Open register page
6. Submit without matching passwords
7. Expected: Error message for password_confirmation
8. Check error styling (red text, clear message)
```

**Result:** ✅ PASS if all pages look good, responsive, and interactive

---

## 📊 TEST 5: INTEGRATION TEST

### Objective
Verify entire flow works end-to-end.

### Steps

```
1. LOGIN & NAVIGATE
   ☑️ Login as student
   ☑️ See dashboard with courses
   ☑️ Click course → see modules
   ☑️ Click module → see lessons
   
2. TAKE QUIZ
   ☑️ Find quiz lesson
   ☑️ Click "Mulai Quiz"
   ☑️ Answer questions
   ☑️ Submit answers
   
3. GET RESULTS
   ☑️ See score feedback
   ☑️ If passed: see XP reward
   ☑️ If failed: see retry option
   
4. CHECK UPDATES
   ☑️ Profile shows updated XP
   ☑️ Leaderboard (if available) shows new rank
   ☑️ Lesson shows completion status
   
5. ADMIN CHECK
   ☑️ Logout as student
   ☑️ Login as admin
   ☑️ See admin dashboard
   ☑️ Can manage quiz questions
   ☑️ View student attempt data
```

**Result:** ✅ PASS if entire flow works smoothly

---

## 🐛 DEBUGGING TIPS

### If Quiz Button Doesn't Show
```
- Check lesson type = 'kuis' (case sensitive)
- Check lesson has questions
- Check view file has button code
- Run: php artisan cache:clear
```

### If Score Calculation Wrong
```
- Check correct_answer is A/B/C/D (uppercase)
- Check student answer matches exactly
- Check database has quiz_score column
- Debug: Add dd() in controller
```

### If XP Not Awarded
```
- Check CompletionController still exists
- Check user.experience column in DB
- Check quiz_score ≥ 70 logic
- Run: php artisan tinker
  -> $user = User::find(1); $user->experience;
```

### If Redirect Wrong
```
- Check middleware 'admin' registered
- Check bootstrap/app.php
- Check routes have correct middleware
- Run: php artisan route:list | grep admin
```

---

## ✅ FINAL CHECKLIST

Before marking as READY:

- [ ] All tests pass
- [ ] No console errors
- [ ] No PHP errors
- [ ] Responsive on mobile
- [ ] Dark mode works
- [ ] Validation working
- [ ] Score calculation accurate
- [ ] XP awarded correctly
- [ ] Admin can manage questions
- [ ] Student can take quiz
- [ ] UI matches design
- [ ] No broken links
- [ ] Session persists
- [ ] Logout works
- [ ] Database queries efficient

---

## 📞 TROUBLESHOOTING

If you encounter issues:

1. **Clear Cache**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   ```

2. **Rebuild Assets**
   ```bash
   npm run build
   ```

3. **Check Database**
   ```bash
   php artisan tinker
   > Schema::hasTable('questions')
   > Schema::hasTable('user_progress')
   ```

4. **Check Routes**
   ```bash
   php artisan route:list | grep quiz
   ```

5. **Check Logs**
   ```bash
   tail -f storage/logs/laravel.log
   ```

---

**Test Guide Version:** 1.0
**Last Updated:** 17 Jan 2026
**Status:** Ready for Testing ✅

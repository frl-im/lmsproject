# ✅ QA TESTING CHECKLIST - LMS IMPLEMENTATION

## 🔧 PRE-DEPLOYMENT CHECKLIST

### Database & Migrations
- [ ] Run `php artisan migrate`
- [ ] Check all tables created: users, user_progress, lessons, messages
- [ ] Verify columns: experience, points, is_premium, is_free, is_completed, xp_awarded
- [ ] Check indexes on foreign keys

### Cache & Config
- [ ] Run `php artisan cache:clear`
- [ ] Run `php artisan route:clear`
- [ ] Run `php artisan config:clear`
- [ ] Verify routes with `php artisan route:list`

### File Permissions
- [ ] `/storage` is writable
- [ ] `/bootstrap/cache` is writable
- [ ] `/public` accessible

---

## 🧪 BAGIAN 1: ANTI-FARMING LOGIC TESTS

### Quiz Submission Tests
- [ ] **Test 1.1**: First quiz attempt
  - User takes quiz
  - Score saved ✓
  - XP awarded ✓
  - Message: "Kerja Bagus! Kamu mendapatkan X XP!"
  - `xp_awarded = true` ✓
  - `is_completed = true` ✓
  
- [ ] **Test 1.2**: Retry same quiz
  - User retakes same quiz
  - Score updated (if higher) ✓
  - NO XP awarded ✓
  - Message: "Latihan selesai (Tanpa Poin Tambahan)" ✓
  - `xp_awarded` remains true ✓
  - User experience unchanged ✓

- [ ] **Test 1.3**: Better score on retry
  - User gets 50% first time
  - User gets 80% second time
  - Score updated to 80% ✓
  - Still NO XP ✓

- [ ] **Test 1.4**: Multiple retries
  - User retakes same quiz 3 times
  - quiz_attempts = 3 ✓
  - Only best score kept ✓
  - XP only awarded once ✓

### Lesson Completion Tests
- [ ] **Test 1.5**: First lesson completion
  - User completes lesson
  - `is_completed = true` ✓
  - `xp_awarded = true` ✓
  - XP added to user.experience ✓
  - Flash message: "Kerja Bagus!" ✓

- [ ] **Test 1.6**: Second completion attempt
  - User tries to complete same lesson again
  - Error response: 422 ✓
  - Message: "Latihan selesai (Tanpa Poin Tambahan)" ✓
  - No XP added ✓

### Database Verification
- [ ] **Test 1.7**: Check user_progress fields
  ```sql
  SELECT * FROM user_progress WHERE user_id = 1;
  -- Verify: id, user_id, course_id, lesson_id, is_completed, 
  --         xp_awarded, quiz_score, quiz_attempts, created_at
  ```

- [ ] **Test 1.8**: Check user experience
  ```sql
  SELECT experience FROM users WHERE id = 1;
  -- Should match XP awarded amount
  ```

---

## 🏠 BAGIAN 2: LANDING PAGE & ROUTING TESTS

### Route Redirects
- [ ] **Test 2.1**: Guest user accesses `/`
  - Redirected to landing page ✓
  - Can see landing page template ✓
  - No auth required ✓

- [ ] **Test 2.2**: Logged-in user (regular) accesses `/`
  - Redirected to `/dashboard` ✓
  - Dashboard shows courses ✓

- [ ] **Test 2.3**: Logged-in admin accesses `/`
  - Redirected to `/admin/dashboard` ✓
  - Admin dashboard shows ✓

### Landing Page Content
- [ ] **Test 2.4**: Landing page elements
  - Logo visible (left) ✓
  - Menu items visible (center): Features, Courses, Pricing, Contact ✓
  - Language dropdown visible (right) ✓
  - Login button visible (far right) ✓

- [ ] **Test 2.5**: Features section
  - 6 feature cards displayed ✓
  - Icons visible ✓
  - Descriptions readable ✓

- [ ] **Test 2.6**: Course preview section
  - Course cards displayed ✓
  - Course title, description, module count shown ✓
  - Click on card opens teaser modal ✓
  - Modal has "Login" button ✓

- [ ] **Test 2.7**: Pricing section
  - Free plan shown ✓
  - Premium plan highlighted ✓
  - Feature comparison visible ✓

### Teaser/Free Preview
- [ ] **Test 2.8**: Guest user clicks on course
  - Teaser modal appears ✓
  - Shows preview message ✓
  - Has Login & Register buttons ✓
  - Can close modal ✓

- [ ] **Test 2.9**: Route `/preview/lesson/{id}` (guest)
  - Returns JSON with message ✓
  - `require_auth = true` ✓

- [ ] **Test 2.10**: Free lesson access (is_free = true)
  - Guest can see preview ✓
  - Content visible ✓
  - No auth needed ✓

- [ ] **Test 2.11**: Non-free lesson access (is_free = false)
  - Guest sees modal asking to login ✓
  - Content not visible ✓

### Navbar Functionality
- [ ] **Test 2.12**: Language dropdown
  - Dropdown opens on hover ✓
  - Language options visible ✓
  - Can click language ✓

- [ ] **Test 2.13**: Login button
  - Redirects to login page ✓
  - Form validation works ✓

---

## 💰 BAGIAN 3: PAYMENT & FINANCE TESTS

### Finance Page
- [ ] **Test 3.1**: Logged-in user accesses `/finance`
  - Finance page loads ✓
  - User stats displayed:
    - Status (Free/Premium) ✓
    - XP count ✓
    - Points count ✓

- [ ] **Test 3.2**: Premium status display
  - Free user shows "👤 Free" ✓
  - Premium user shows "⭐ Premium" ✓

### Pricing Plans
- [ ] **Test 3.3**: Free plan display
  - Features listed correctly ✓
  - Price: Rp 0 ✓
  - Button: "✓ Paket Aktif" (for free users) ✓

- [ ] **Test 3.4**: Premium plan display
  - Features listed correctly ✓
  - Price: Rp 99.000 ✓
  - "⭐ PAKET TERPOPULER" badge visible ✓
  - Button: "🚀 Upgrade Sekarang" ✓

### Simulasi Pembayaran
- [ ] **Test 3.5**: Free user clicks "Upgrade Sekarang"
  - Form submits to `/finance/purchase-premium` ✓
  - Processing... ✓
  - Response: success = true ✓

- [ ] **Test 3.6**: After upgrade
  - User status changes to "⭐ Premium" ✓
  - `is_premium = true` in DB ✓
  - XP increased by 100 (bonus) ✓
  - Flash message: "Pembayaran Berhasil (Simulasi)" ✓

- [ ] **Test 3.7**: Premium user sees correct buttons
  - "✓ Paket Aktif" button disabled ✓
  - Can't click upgrade again ✓

### Feature Comparison
- [ ] **Test 3.8**: Feature comparison table
  - All features listed ✓
  - Correct ✓ and ✗ marks ✓
  - Clear visual difference ✓

---

## 💬 BAGIAN 3B: SIMULASI CHAT (CONSULT)

### Consult Page Loading
- [ ] **Test 3.9**: User accesses `/consult`
  - Page loads ✓
  - Chat form visible ✓
  - Message list visible ✓

### Send Message
- [ ] **Test 3.10**: Send message form
  - Subject field accepts input ✓
  - Message textarea accepts input ✓
  - Submit button clickable ✓

- [ ] **Test 3.11**: Submit message
  - Form submits to `/consult/send` ✓
  - POST request with CSRF token ✓
  - Response: success = true ✓
  - Flash message: "Pesan Anda telah dikirim" ✓

- [ ] **Test 3.12**: Message saved to DB
  ```sql
  SELECT * FROM messages WHERE user_id = 1;
  -- Verify: subject, message, is_read = false, is_admin_reply = false
  ```

### Message List
- [ ] **Test 3.13**: Messages display
  - Recent messages shown ✓
  - Timestamp displays ✓
  - Subject visible ✓
  - Message content visible ✓

- [ ] **Test 3.14**: Message status
  - "Belum dibaca" badge shows ✓
  - "⏳ Menunggu Balasan" status shows ✓
  - If admin replied: "✓ Admin Sudah Balas" ✓

### Message Management
- [ ] **Test 3.15**: Delete message
  - Click delete button ✓
  - Confirmation dialog ✓
  - Message deleted ✓
  - Page refreshes ✓

- [ ] **Test 3.16**: Mark as read (if implemented)
  - Message marked as read ✓
  - Badge disappears ✓

### Auto-refresh
- [ ] **Test 3.17**: Messages auto-update
  - New message appears without page reload ✓
  - Timestamp updates ✓
  - Every 30 seconds check ✓

### Sidebar Info
- [ ] **Test 3.18**: Admin status
  - "🟢 Online Sekarang" shows ✓
  - Response time info shows ✓

- [ ] **Test 3.19**: Stats section
  - Total messages count ✓
  - Replied messages count ✓

---

## 🔐 SECURITY TESTS

### Authentication & Authorization
- [ ] **Test 4.1**: Unauthenticated user accesses `/dashboard`
  - Redirected to login ✓

- [ ] **Test 4.2**: Regular user accesses `/admin/dashboard`
  - Redirected or error ✓
  - Can't access admin routes ✓

- [ ] **Test 4.3**: Admin can access `/admin/dashboard`
  - Page loads ✓
  - Admin content visible ✓

### CSRF Protection
- [ ] **Test 4.4**: POST request without CSRF token
  - Request rejected ✓
  - 419 error or redirect ✓

- [ ] **Test 4.5**: POST request with valid CSRF token
  - Request accepted ✓
  - Action proceeds ✓

### Data Isolation
- [ ] **Test 4.6**: User A can only see own messages
  - User A's messages visible ✓
  - User B's messages NOT visible ✓

- [ ] **Test 4.7**: User can't manually change is_premium via URL
  - Only via purchase endpoint ✓
  - Direct DB update prevented ✓

---

## 🎨 UI/UX TESTS

### Responsive Design
- [ ] **Test 5.1**: Desktop view (1920px)
  - Layout looks good ✓
  - All elements visible ✓

- [ ] **Test 5.2**: Tablet view (768px)
  - Grid responsive ✓
  - Menu collapses if needed ✓

- [ ] **Test 5.3**: Mobile view (375px)
  - All content accessible ✓
  - Buttons clickable ✓
  - No horizontal scroll ✓

### Navigation
- [ ] **Test 5.4**: Navbar links work
  - All links clickable ✓
  - Correct pages load ✓

- [ ] **Test 5.5**: Breadcrumbs/back buttons
  - Users can navigate back ✓
  - Context maintained ✓

### Form Validation
- [ ] **Test 5.6**: Empty subject on message
  - Form shows error ✓
  - Prevents submission ✓

- [ ] **Test 5.7**: Empty message body
  - Form shows error ✓
  - Prevents submission ✓

### Loading States
- [ ] **Test 5.8**: Payment button loading
  - Button shows loading state ✓
  - Disabled during submission ✓
  - Re-enabled after response ✓

---

## 🔍 EDGE CASES

### Anti-Farming Edge Cases
- [ ] **Test 6.1**: Same user, different lessons
  - Each gets own XP ✓
  - No conflict ✓

- [ ] **Test 6.2**: Same user, same lesson, days apart
  - Still can't farm XP ✓
  - Anti-farming permanent ✓

- [ ] **Test 6.3**: Quiz with 0 questions
  - Error message shows ✓
  - No crash ✓

### Payment Edge Cases
- [ ] **Test 6.4**: Already premium user clicks upgrade
  - Error: Already premium ✓
  - No double charge ✓

- [ ] **Test 6.5**: Spam upgrade clicks
  - Only one upgrade processes ✓
  - Idempotent ✓

### Chat Edge Cases
- [ ] **Test 6.6**: Very long message
  - Truncated display or scrollable ✓
  - Doesn't break layout ✓

- [ ] **Test 6.7**: Special characters in message
  - Escaped properly ✓
  - XSS prevented ✓

- [ ] **Test 6.8**: Delete own message multiple times
  - First delete works ✓
  - Second delete: 404 or error ✓

---

## 📊 PERFORMANCE TESTS

- [ ] **Test 7.1**: Landing page load time
  - < 3 seconds with courses ✓

- [ ] **Test 7.2**: Dashboard load time
  - < 2 seconds ✓

- [ ] **Test 7.3**: Consult page load time
  - < 2 seconds ✓

- [ ] **Test 7.4**: Query optimization
  - No N+1 queries ✓
  - Eager loading used ✓

- [ ] **Test 7.5**: Database indexes
  - Queries use indexes ✓
  - No full table scans ✓

---

## 🐛 BUG TRACKING

| Bug # | Description | Status | Fix |
|-------|-------------|--------|-----|
| BUG-001 | | ☐ NEW | |
| BUG-002 | | ☐ NEW | |
| BUG-003 | | ☐ NEW | |

---

## ✅ FINAL CHECKLIST

- [ ] All tests pass
- [ ] No console errors
- [ ] No database errors
- [ ] Performance acceptable
- [ ] Security validated
- [ ] Responsive works on all devices
- [ ] User feedback positive
- [ ] Documentation complete
- [ ] Code commented
- [ ] Ready for production deploy

---

## 🚀 DEPLOYMENT

- [ ] Backup database
- [ ] Run migrations on production
- [ ] Clear cache on production
- [ ] Test landing page
- [ ] Test user flow
- [ ] Monitor errors
- [ ] Check logs

---

**Tested By**: _______________
**Date**: _______________
**Status**: ☐ PASS / ☐ FAIL
**Notes**: 

---

**Last Updated**: 18 January 2026

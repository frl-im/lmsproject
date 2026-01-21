# 🎯 Setup Guide - Sistem Pembayaran Premium LMS

## Quick Start (5 Menit)

### ✅ Step 1: Jalankan Migration
```bash
php artisan migrate
```

Output yang diharapkan:
```
INFO  Running migrations.
  2026_01_21_update_users_subscription  ✓ DONE
```

### ✅ Step 2: Setup .env

Edit file `.env` dan tambahkan (atau ubah jika sudah ada):

```env
# ========== PAYMENT GATEWAY ==========

# MIDTRANS (Recommended untuk Indonesia)
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxxxx
MIDTRANS_PRODUCTION=false

# STRIPE (Untuk pembayaran internasional)
STRIPE_SECRET_KEY=sk_test_xxxxxxxxxxxxxx
STRIPE_PUBLIC_KEY=pk_test_xxxxxxxxxxxxxx
```

### ✅ Step 3: Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
```

---

## 🔑 Mendapatkan API Keys

### MIDTRANS (Pilihan Utama untuk Indonesia)

**Langkah-langkah:**
1. Buka https://www.midtrans.com
2. Klik "Sign Up" atau login jika sudah punya akun
3. Ikuti proses registrasi dan verifikasi email
4. Masuk ke dashboard: https://dashboard.midtrans.com
5. Pergi ke **Settings** → **Access Keys**
6. Copy:
   - **Server Key** → `MIDTRANS_SERVER_KEY`
   - **Client Key** → `MIDTRANS_CLIENT_KEY`
7. Pastikan mode **Sandbox** (jangan production dulu)

**Testing dengan Sandbox:**
```
MIDTRANS_PRODUCTION=false
```

**Test Payment Cards (Sandbox):**
- Visa: 4811 1111 1111 1114
- Mastercard: 5105 1051 0510 5100
- Expiry: 12/25
- CVV: 123

---

### STRIPE (Opsional)

**Langkah-langkah:**
1. Buka https://stripe.com
2. Klik "Create account" atau login
3. Verifikasi email Anda
4. Masuk ke dashboard: https://dashboard.stripe.com
5. Pergi ke **Developers** → **API Keys**
6. Gunakan **Test Mode** (ada toggle di atas)
7. Copy:
   - **Secret Key** → `STRIPE_SECRET_KEY` (mulai dengan `sk_test_`)
   - **Publishable Key** → `STRIPE_PUBLIC_KEY` (mulai dengan `pk_test_`)

**Test Payment Cards:**
- Visa: 4242 4242 4242 4242
- Mastercard: 5555 5555 5555 4444
- Expiry: Masa depan (mis: 12/25)
- CVV: Angka berapapun (mis: 123)

---

## 📂 File Structure yang Dibuat

```
✅ CREATED FILES:
├── app/Http/Controllers/PaymentController.php
│   └── Main payment logic untuk semua metode
│
├── app/Models/Payment.php (UPDATED)
│   └── Added relationships & helper methods
│
├── config/
│   ├── midtrans.php
│   └── stripe.php
│
├── database/migrations/
│   └── 2026_01_21_update_users_subscription.php
│   └── Adds: is_premium, premium_expires_at, subscription_status
│
├── resources/views/payment/
│   ├── upgrade.blade.php
│   │   └── Main payment method selection page
│   ├── midtrans.blade.php
│   │   └── Midtrans payment form
│   ├── manual-pending.blade.php
│   │   └── Manual transfer instructions
│   └── paypal-pending.blade.php
│       └── PayPal placeholder (coming soon)
│
├── resources/views/home/landing.blade.php (UPDATED)
│   └── Added payment integration & upgrade button
│
└── .env.payment.example
    └── Example environment variables
```

---

## 🧪 Testing Checklist

### Test 1: User Registration & Login
```
✓ Buka http://localhost/register
✓ Buat akun baru
✓ Login dengan akun tersebut
✓ Verify di database: users table
```

### Test 2: Landing Page
```
✓ Buka http://localhost/ (home page)
✓ Scroll ke section "Pilih Paket Anda"
✓ Lihat 2 cards: Gratis dan Premium
✓ Premium card harus punya tombol "Upgrade Sekarang"
✓ Click tombol tersebut
```

### Test 3: Payment Page
```
✓ URL harus /payment/upgrade
✓ Tampilkan 4 metode pembayaran:
   - Midtrans
   - Stripe
   - Manual Transfer
   - PayPal (Coming Soon)
```

### Test 4: Midtrans Payment
```
✓ Click "Midtrans" button
✓ Akan redirect ke halaman snap.midtrans.com
✓ Pilih metode pembayaran (e.g., Transfer Bank)
✓ Test dengan card: 4811 1111 1111 1114
✓ Expiry: 12/25, CVV: 123
✓ Setelah berhasil → Auto-activate premium
✓ Database update: 
   - users.is_premium = 1
   - users.premium_expires_at = sekarang + 1 bulan
   - payments.status = paid
```

### Test 5: Manual Transfer
```
✓ Click "Transfer Manual" button
✓ Tampilkan detail rekening:
   - Bank: BCA
   - No Rek: 1234567890
   - Amount: Rp 99.000
   - Ref Code: TRANSFER-XXX
✓ Ada tombol "Copy" untuk setiap field
✓ Ada button "Check Status Sekarang"
```

### Test 6: Check Status
```
✓ Dari manual transfer page
✓ Click "Cek Status Sekarang"
✓ Status harus "pending" (belum transfer)
✓ Setelah manual verifikasi → Status jadi "paid"
```

---

## 📊 Database Verification

Setelah setup, verify database dengan:

```bash
php artisan tinker
```

Kemudian jalankan:

```php
# Check users table
DB::table('users')->first();

# Harusnya ada kolom:
# - is_premium (boolean)
# - premium_expires_at (timestamp)
# - subscription_status (enum)

# Check payments table
DB::table('payments')->get();
```

---

## 🔗 Routes yang Tersedia

**Setelah login, akses routes berikut:**

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/payment/upgrade` | GET | Lihat halaman pilih metode |
| `/payment/midtrans/checkout` | GET | Checkout via Midtrans |
| `/payment/stripe/checkout` | GET | Checkout via Stripe |
| `/payment/manual/checkout` | GET | Manual transfer |
| `/payment/check-status/{refCode}` | GET | Check payment status |

**Testing routes di browser:**
```
http://localhost/payment/upgrade
http://localhost/payment/check-status/TRANSFER-1-abc123
```

---

## 🚀 Deploy ke Production

### Sebelum Live:

1. **Change Midtrans Mode:**
```env
MIDTRANS_PRODUCTION=true
```

2. **Get Production Keys:**
   - Login ke https://dashboard.midtrans.com
   - Switch ke **Production** mode
   - Get production Server Key & Client Key

3. **Update .env:**
```env
MIDTRANS_SERVER_KEY=Mid-server-xxxx (production)
MIDTRANS_CLIENT_KEY=Mid-client-xxxx (production)
MIDTRANS_PRODUCTION=true
```

4. **Test di Staging dulu!**

5. **Setup Webhook (Midtrans):**
   - Dashboard → Settings → Notification URL
   - Set ke: `https://yourdomain.com/payment/midtrans/callback`

---

## ⚠️ Common Issues & Solutions

### Issue 1: "Call to undefined class PaymentController"
**Solution:**
```bash
composer dump-autoload
php artisan cache:clear
```

### Issue 2: "MIDTRANS_SERVER_KEY not found"
**Solution:**
- Edit `.env` file
- Pastikan keys sudah benar
- Run: `php artisan config:clear`

### Issue 3: "Payment tidak tercatat di database"
**Solution:**
- Check migrations sudah jalan: `php artisan migrate:status`
- Check payments table exist: `DB::table('payments')->get()`
- Verify PaymentController logic

### Issue 4: Premium status tidak berubah
**Solution:**
```php
# Manual update di tinker
$user = User::find(1);
$user->is_premium = true;
$user->premium_expires_at = now()->addMonth();
$user->save();
```

---

## 📞 Support & Debug

### Enable Debug Mode
```env
APP_DEBUG=true
```

### Check Logs
```bash
tail -f storage/logs/laravel.log
```

### Test Payment Endpoint
```bash
# Sebelum live, test Midtrans
curl -X GET http://localhost/payment/upgrade \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## ✅ Pre-Launch Checklist

- [ ] Database migrations sudah jalan
- [ ] .env sudah punya MIDTRANS_SERVER_KEY & CLIENT_KEY
- [ ] User bisa register & login
- [ ] Landing page menampilkan pricing section
- [ ] Upgrade button mengarah ke /payment/upgrade
- [ ] Bisa select payment method
- [ ] Midtrans sandbox payment berfungsi
- [ ] User premium status berubah setelah payment
- [ ] Check status endpoint berfungsi
- [ ] Manual transfer flow bekerja
- [ ] Database mencatat semua transactions

---

## 🎉 Siap Go Live!

Setelah semua checklist ✅, sistem pembayaran Anda siap!

**Features yang sudah included:**
- ✅ 3+ Payment Methods
- ✅ Auto Premium Activation
- ✅ Payment Tracking
- ✅ User-friendly UI
- ✅ Real-time Status Check
- ✅ Security (CSRF, Auth middleware)

**Next improvements (optional):**
- [ ] Email notifications
- [ ] Invoice PDF generation
- [ ] Subscription auto-renewal
- [ ] Refund system
- [ ] Analytics dashboard

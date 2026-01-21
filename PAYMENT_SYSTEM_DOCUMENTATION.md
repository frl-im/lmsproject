# 📚 Dokumentasi Sistem Pembayaran Premium LMS

## Overview
Sistem pembayaran premium yang terintegrasi penuh dengan fitur gamifikasi dan tracking progress pada LMS Anda.

---

## ✅ Fitur yang Telah Diimplementasikan

### 1. **Payment Methods (Metode Pembayaran)**
- ✅ Midtrans (Transfer Bank, e-Wallet, Kartu Kredit)
- ✅ Stripe (Kartu Kredit Internasional)
- ✅ Manual Transfer (Bank lokal)
- ✅ PayPal (Coming Soon)

### 2. **User Interface**
- ✅ Landing page dengan pricing section
- ✅ Halaman upgrade premium yang user-friendly
- ✅ Modal pembayaran dengan 4 metode pilihan
- ✅ Sistem status pembayaran real-time
- ✅ FAQ dan instruksi pembayaran yang jelas

### 3. **Backend Integration**
- ✅ PaymentController dengan semua logic pembayaran
- ✅ Payment Model untuk database
- ✅ User Model update dengan subscription fields
- ✅ Database migrations untuk tabel users dan payments
- ✅ Routes untuk semua payment endpoints

### 4. **Payment Flow**
- ✅ User dapat upgrade ke premium
- ✅ Auto-activate premium setelah pembayaran
- ✅ Tracking pembayaran dengan reference code
- ✅ Check status pembayaran real-time
- ✅ Email notification (siap untuk diintegrasikan)

---

## 🚀 Cara Menggunakan

### Step 1: Setup Environment Variables

Edit file `.env` dan tambahkan:

```env
# MIDTRANS
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxx
MIDTRANS_PRODUCTION=false

# STRIPE
STRIPE_SECRET_KEY=sk_test_xxxxxx
STRIPE_PUBLIC_KEY=pk_test_xxxxxx
```

### Step 2: Dapatkan API Keys

#### Untuk Midtrans:
1. Buka https://www.midtrans.com
2. Daftar dan buat akun developer
3. Dashboard → Settings → Access Keys
4. Copy Server Key dan Client Key

#### Untuk Stripe:
1. Buka https://stripe.com
2. Buat akun developer
3. Dashboard → Developers → API Keys
4. Copy Secret Key dan Publishable Key

### Step 3: Install Dependencies (jika belum)

```bash
composer require midtrans/midtrans-php
composer require stripe/stripe-php
```

### Step 4: Test Pembayaran

**Test Cards:**
- Visa: `4811 1111 1111 1114`
- Mastercard: `5105 1051 0510 5100`
- Expiry: `12/25`, CVV: `123`

---

## 📂 File Structure

```
app/
├── Http/
│   └── Controllers/
│       └── PaymentController.php        # Main payment logic
├── Models/
│   ├── Payment.php                      # Payment model (sudah ada)
│   └── User.php                         # Updated dengan subscription fields
config/
├── midtrans.php                         # Midtrans config
└── stripe.php                           # Stripe config
database/
└── migrations/
    └── 2026_01_21_update_users_subscription.php
resources/
└── views/
    ├── home/
    │   └── landing.blade.php            # Updated dengan payment integration
    └── payment/
        ├── upgrade.blade.php            # Halaman pilih metode pembayaran
        ├── midtrans.blade.php           # Midtrans payment form
        ├── manual-pending.blade.php     # Manual transfer instructions
        └── paypal-pending.blade.php     # PayPal placeholder
routes/
└── web.php                              # Updated dengan payment routes
```

---

## 🔄 User Journey

```
Landing Page
    ↓
User Click "Upgrade Sekarang" (Premium Card)
    ↓
redirect to /payment/upgrade
    ↓
Pilih Metode Pembayaran:
    ├─ Midtrans → Payment Gateway
    ├─ Stripe → Payment Gateway
    └─ Manual Transfer → Instruksi Transfer
    ↓
After Payment Success
    ↓
Auto-Activate Premium
    ↓
Update User Status → is_premium = true
    ↓
Redirect to Dashboard dengan Success Message
```

---

## 💾 Database Fields

### Table: `users` (NEW FIELDS)
```sql
- is_premium (boolean) -- Default: false
- premium_expires_at (timestamp) -- Tanggal expired premium
- subscription_status (enum) -- free, premium, expired
```

### Table: `payments` (EXISTING)
```sql
- id
- user_id (FK)
- reference_code (unique)
- method (midtrans, stripe, manual, paypal)
- amount (default: 99000)
- status (pending, paid, failed)
- timestamps
```

---

## 🔌 API Endpoints

### Payment Routes (Protected - Auth Required)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/payment/upgrade` | Tampilkan halaman upgrade |
| GET | `/payment/midtrans/checkout` | Midtrans checkout |
| POST | `/payment/midtrans/callback` | Midtrans callback (no CSRF) |
| GET | `/payment/stripe/checkout` | Stripe checkout |
| GET | `/payment/stripe/success` | Stripe success redirect |
| GET | `/payment/paypal/checkout` | PayPal checkout |
| GET | `/payment/manual/checkout` | Manual transfer |
| GET | `/payment/check-status/{refCode}` | Check payment status |

---

## 🧪 Testing Checklist

- [ ] Registrasi user baru
- [ ] Login ke akun
- [ ] Klik "Upgrade Sekarang" di landing page
- [ ] Pilih Midtrans → Test pembayaran dengan test card
- [ ] Verify premium status berubah di database
- [ ] Check premium expires_at date (harus +1 bulan)
- [ ] Test manual transfer flow
- [ ] Test stripe payment
- [ ] Verify fitur premium accessible setelah upgrade
- [ ] Test check status endpoint

---

## 🔒 Security Notes

✅ **CSRF Protection:**
- Midtrans callback di-exclude dari CSRF middleware

✅ **Authentication:**
- Semua payment routes require login

✅ **Data Validation:**
- Reference code unique di database
- Amount fixed (99000) - tidak bisa diubah user

✅ **Best Practices:**
- Server key disimpan di environment variable
- Client key untuk frontend payment form
- Signature verification untuk callback

---

## 📱 Screenshots / Preview

### Landing Page
- Navigation dengan "Harga" section
- Pricing cards: Gratis vs Premium
- Premium card menampilkan "Upgrade Sekarang" button

### Payment Page
- Metode pembayaran yang jelas dengan icons
- Detail paket premium
- FAQ section

### Manual Transfer
- Detail rekening bank
- Copy button untuk nomor rekening & amount
- Kode referensi unik per user
- Check status real-time button

---

## 🐛 Troubleshooting

### Problem: "Call to undefined function \Midtrans\..."
**Solution:** Install midtrans package
```bash
composer require midtrans/midtrans-php
```

### Problem: "Stripe key not found"
**Solution:** Pastikan STRIPE_SECRET_KEY di .env

### Problem: Payment tidak terverifikasi
**Solution:** 
- Check MIDTRANS_SERVER_KEY di .env
- Pastikan webhook signature match
- Verify transaction di dashboard Midtrans

### Problem: Manual transfer payment pending selamanya
**Solution:**
- Check database payments table
- Manual verify dengan `php artisan tinker`:
  ```php
  $payment = Payment::find(id);
  $payment->markAsPaid();
  $payment->user->upgradeToPremium();
  ```

---

## 🚀 Next Steps

1. **Email Notifications** - Kirim email konfirmasi pembayaran
2. **Invoice Generation** - Generate PDF invoice
3. **Subscription Renewal** - Auto-extend premium
4. **Refund System** - Handle refund requests
5. **Analytics Dashboard** - Track revenue & conversions

---

## 📞 Support

Untuk setup atau bantuan:
- WhatsApp: Admin
- Email: admin@lmspro.com
- Documentation: docs.lmspro.com

---

## 📝 Version History

- **v1.0** (21 Jan 2026) - Initial release dengan Midtrans, Stripe, Manual Transfer
- **Future** - PayPal, Subscription Auto-Renewal

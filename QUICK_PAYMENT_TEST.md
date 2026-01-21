# 🎯 QUICK START: Sistem Pembayaran Simulasi

**Status**: ✅ Ready to Test

## Apa Itu Sistem Ini?

Sistem pembayaran **SIMULASI MURNI** untuk LMS Gamifikasi Premium tanpa perlu API Gateway:
- ✅ Tidak perlu Midtrans API key
- ✅ Tidak perlu Stripe API key  
- ✅ Tidak perlu PayPal API key
- ✅ Cukup klik tombol → Premium aktif langsung

## Testing (2 Menit Setup)

### Step 1: Buat User Test
```bash
cd c:\laragon\www\lmsproject
php artisan tinker
```

```php
User::create([
    'name' => 'Test User',
    'email' => 'test@mail.com',
    'password' => bcrypt('password'),
    'email_verified_at' => now(),
    'is_premium' => false
])

exit
```

### Step 2: Login
```
1. Buka http://localhost:8000
2. Login: test@mail.com / password
3. Klik "Upgrade Sekarang" (di landing page atau button di dashboard)
```

### Step 3: Pilih Metode Pembayaran
```
Klik salah satu:
- 🏦 Midtrans (Simulasi)
- 💳 Stripe (Simulasi)
- 💰 PayPal (Simulasi)
- 🔄 Transfer Manual (Simulasi)
```

### Step 4: Simulasi Pembayaran
```
1. Lihat halaman dengan:
   - Kode Referensi (bisa di-copy)
   - Jumlah: Rp 99.000
   - 2 button: "Simulasi Berhasil" dan "Batal"

2. Klik "Simulasi Pembayaran Berhasil" ✓
```

### Step 5: Premium Aktif! 🎉
```
✅ Redirect ke dashboard
✅ Notifikasi "Selamat! Akun Anda telah diupgrade ke Premium"
✅ User status berubah ke Premium (1 bulan)
✅ Akses premium features dibuka
```

## Verifikasi Database

```bash
php artisan tinker

# Check user premium status
User::find(1)->is_premium         # => true
User::find(1)->premium_expires_at # => 2026-02-22 ...
User::find(1)->subscription_status # => 'premium'

# Check payment record
Payment::where('user_id', 1)->get()
# Output:
# [
#   {
#     "id": 1,
#     "user_id": 1,
#     "reference_code": "MIDTRANS-1-ABC123DE",
#     "method": "midtrans",
#     "amount": 99000,
#     "status": "paid",
#     ...
#   }
# ]

exit
```

## File-File Penting

```
app/Http/Controllers/PaymentController.php     ← Main logic
resources/views/payment/upgrade.blade.php      ← Payment methods
resources/views/payment/simulate.blade.php     ← Simulasi page
routes/web.php                                  ← Routes (payment)
database/migrations/...create_payments_table   ← DB schema
tests/Feature/PaymentSimulationTest.php        ← Unit tests
```

## Fitur yang Bekerja

| Feature | Status |
|---------|--------|
| Pilih 4 metode pembayaran | ✅ |
| Generate reference code | ✅ |
| Simpan payment record | ✅ |
| Halaman simulasi | ✅ |
| Aktivasi premium otomatis | ✅ |
| Update user subscription fields | ✅ |
| Check payment status | ✅ |
| Expires at (1 bulan) | ✅ |

## Routes

```
GET  /payment/upgrade                          → Halaman pilihan metode
GET  /payment/midtrans/checkout                → Simulasi Midtrans
GET  /payment/stripe/checkout                  → Simulasi Stripe
GET  /payment/paypal/checkout                  → Simulasi PayPal
GET  /payment/manual/checkout                  → Simulasi Manual
GET  /payment/simulate-success?ref=XXX         → Aktivasi premium
GET  /payment/check-status/{referenceCode}     → Check status API
```

## Upgrade ke Payment Gateway Real (Nanti)

Saat ingin upgrade ke **Midtrans Real** atau **Stripe Real**:

1. Buka `app/Http/Controllers/PaymentController.php`
2. Update `midtransCheckout()` - uncomment Midtrans SDK code
3. Update `stripeCheckout()` - uncomment Stripe Session code
4. Tambah env variables:
   ```env
   MIDTRANS_SERVER_KEY=SB-xxx
   MIDTRANS_CLIENT_KEY=SB-xxx
   STRIPE_SECRET_KEY=sk_test_xxx
   STRIPE_PUBLIC_KEY=pk_test_xxx
   ```
5. Run `php artisan config:clear`
6. Test dengan sandbox credentials

## Troubleshooting

**Q: Halaman upgrade tidak muncul?**
```bash
php artisan cache:clear
php artisan route:clear
```

**Q: User tidak jadi premium?**
```bash
php artisan tinker
DB::table('users')->where(id, 1)->get()
# Check is_premium = 1, premium_expires_at has value
```

**Q: Payment record tidak tersimpan?**
```bash
php artisan migrate --fresh
php artisan tinker
DB::table('payments')->count()
```

**Q: Button simulasi tidak bekerja?**
- Pastikan sudah login
- Cek browser console (F12) untuk error
- Cek routes: `php artisan route:list --path=payment`

## Testing Checklist

- [ ] Login berhasil
- [ ] Bisa akses /payment/upgrade
- [ ] 4 metode payment terlihat
- [ ] Klik setiap metode → halaman simulasi muncul
- [ ] Reference code bisa di-copy
- [ ] Tombol "Simulasi Berhasil" bisa diklik
- [ ] Redirect ke dashboard berhasil
- [ ] Notifikasi sukses muncul
- [ ] User status berubah premium
- [ ] premium_expires_at terisi (1 bulan ke depan)
- [ ] Payment record tersimpan di database
- [ ] Status payment = 'paid'

---

## Support

Jika ada error atau pertanyaan:
1. Cek file: `PAYMENT_SIMULATION.md` (dokumentasi lengkap)
2. Cek file: `UPDATE_PAYMENT_SIMULATION.md` (changelog)
3. Run tests: `php artisan test tests/Feature/PaymentSimulationTest.php`

---

**Last Updated**: 22 Jan 2026  
**Version**: 1.0 (Simulasi Murni)  
**Next**: Upgrade ke payment gateway real (Midtrans/Stripe)

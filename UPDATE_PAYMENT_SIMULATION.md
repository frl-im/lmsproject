# Update Pembayaran: Simulasi Murni ✅

**Tanggal**: 22 Jan 2026  
**Status**: Siap Testing

## Ringkasan Perubahan

### Apa Yang Diubah?
Sistem pembayaran diubah dari **payment gateway real** (Midtrans API, Stripe API) menjadi **simulasi murni** untuk memudahkan development dan testing.

### Keuntungan Simulasi
- ✅ **Tidak perlu API keys** - Langsung bisa test tanpa setup gateway
- ✅ **Instant activation** - Premium langsung aktif setelah klik tombol
- ✅ **Data tersimpan** - Semua transaksi tercatat di database
- ✅ **Safe testing** - Tidak ada biaya real, murni testing
- ✅ **Easy QA** - Cukup klik tombol untuk test berbagai skenario

---

## File Yang Diubah

### 1. `app/Http/Controllers/PaymentController.php`
**Perubahan**: Disederhanakan dari 251 baris menjadi 165 baris

**Methods Sebelum**:
- midtransCheckout() - Panggil API Midtrans
- midtransCallback() - Handle webhook Midtrans
- stripeCheckout() - Redirect ke Stripe
- stripeSuccess() - Handle Stripe callback
- paypalCheckout() - PayPal placeholder
- manualCheckout() - Manual transfer

**Methods Sesudah**:
- midtransCheckout() - **SIMULASI** (cepat, tanpa API)
- stripeCheckout() - **SIMULASI** (cepat, tanpa API)
- paypalCheckout() - **SIMULASI** (cepat, tanpa API)
- manualCheckout() - **SIMULASI** (cepat, tanpa API)
- simulateSuccess() - **BARU** (aktifkan premium)
- checkStatus() - Tetap sama
- activatePremium() - Tetap sama

**Kode Dihapus**:
- Midtrans SDK initialization
- Stripe Session creation
- Callback handlers
- Error handling untuk API

**Kode Ditambah**:
```php
// Setiap checkout sekarang hanya:
1. Buat reference code
2. Simpan ke database dengan status 'pending'
3. Redirect ke halaman simulasi
```

### 2. `routes/web.php`
**Perubahan**: Streamlined payment routes

**Rute Dihapus**:
```php
Route::post('/midtrans/callback', ...)  // Tidak perlu callback
Route::get('/stripe/success', ...)      // Diganti dengan simulate-success
```

**Rute Ditambah**:
```php
Route::get('/payment/simulate-success', 'simulateSuccess')  // BARU
```

**Rute Tetap**:
- /payment/upgrade
- /payment/midtrans/checkout
- /payment/stripe/checkout
- /payment/paypal/checkout
- /payment/manual/checkout
- /payment/check-status/{ref}

### 3. `resources/views/payment/simulate.blade.php`
**Status**: File BARU ✨

Halaman simulasi interaktif dengan:
- Reference code display + copy button
- Amount display
- Info badge
- 2 buttons: 
  - "✓ Simulasi Pembayaran Berhasil" → Aktivasi premium
  - "Batal" → Kembali ke upgrade page

### 4. Dokumentasi
**Ditambah**: `PAYMENT_SIMULATION.md`
- Penjelasan detail sistem simulasi
- Step-by-step testing guide
- Troubleshooting tips
- Cara upgrade ke real gateway

---

## Testing Manual

### Akses 1: Guest User
```
1. Buka http://localhost:8000
2. Klik "Upgrade Sekarang" di halaman landing
3. Hasil: Redirect ke login (karena belum authenticated)
```

### Akses 2: Authenticated User
```
1. Login terlebih dahulu
2. Klik "Upgrade Sekarang"
3. Lihat halaman /payment/upgrade dengan 4 metode pembayaran
4. Pilih 1 metode (contoh: Midtrans)
5. Lihat halaman simulasi dengan:
   - Reference code
   - Amount (Rp 99.000)
   - Button "Simulasi Pembayaran Berhasil"
6. Klik tombol sukses
7. Redirect ke dashboard dengan notifikasi "Selamat! Akun Anda telah diupgrade ke Premium"
```

### Verifikasi Database
```bash
# Check payment record
php artisan tinker
DB::table('payments')->latest()->first()

# Check user premium status
User::find(1)->is_premium          # true
User::find(1)->premium_expires_at  # 2026-02-22 (1 bulan ke depan)
```

---

## Struktur Flow Payment

```
┌─ Login Page
│
├─ Dashboard / Landing
│  │
│  └─ Klik "Upgrade Sekarang"
│     │
│     ├─ /payment/upgrade (Guest? → Redirect login)
│     │  │
│     │  ├─ Pilih Midtrans → GET /payment/midtrans/checkout
│     │  ├─ Pilih Stripe → GET /payment/stripe/checkout
│     │  ├─ Pilih PayPal → GET /payment/paypal/checkout
│     │  └─ Pilih Manual → GET /payment/manual/checkout
│     │
│     └─ Halaman Simulasi (/payment/simulate)
│        │
│        └─ Klik "Simulasi Pembayaran Berhasil"
│           │
│           ├─ GET /payment/simulate-success?ref=XXX
│           │  │
│           │  ├─ Update payments table: status = 'paid'
│           │  ├─ Update users table: is_premium = true
│           │  ├─ Update users table: premium_expires_at = +1 bulan
│           │  │
│           │  └─ Redirect /dashboard + success notification
│           │
│           └─ Dashboard (User Sekarang Premium ✅)
```

---

## Contoh Kode Payment Simulasi

```php
// PaymentController@midtransCheckout
public function midtransCheckout()
{
    $user = Auth::user();
    
    // 1. Generate reference code
    $referenceCode = 'MIDTRANS-' . $user->id . '-' . Str::random(8);

    // 2. Simpan ke database
    Payment::create([
        'user_id' => $user->id,
        'reference_code' => $referenceCode,
        'method' => 'midtrans',
        'amount' => 99000,
        'status' => 'pending'  // ← Status pending, tunggu confirm
    ]);

    // 3. Show simulasi page
    return view('payment.simulate', [
        'referenceCode' => $referenceCode,
        'method' => 'Midtrans',
        'amount' => 99000
    ]);
}

// PaymentController@simulateSuccess
public function simulateSuccess(Request $request)
{
    $referenceCode = $request->query('ref');
    
    // 1. Cari payment record
    $payment = Payment::where('reference_code', $referenceCode)
        ->where('user_id', Auth::id())
        ->first();

    // 2. Aktivasi premium
    $this->activatePremium($payment);

    // 3. Success notification & redirect
    return redirect('/dashboard')
        ->with('success', 'Selamat! Akun Anda telah diupgrade ke Premium. 🎉');
}
```

---

## Checklist Testing

- [ ] User bisa akses /payment/upgrade (dengan login requirement)
- [ ] User bisa klik 4 metode pembayaran
- [ ] Setiap metode menampilkan halaman simulasi yang berbeda
- [ ] Reference code ter-copy dengan benar
- [ ] Amount ditampilkan dengan format Rp yang benar
- [ ] Klik "Simulasi Pembayaran Berhasil" mengaktifkan premium
- [ ] User redirect ke dashboard dengan notifikasi sukses
- [ ] Database tercatat: payment status = 'paid'
- [ ] Database tercatat: user is_premium = true
- [ ] Database tercatat: user premium_expires_at = +1 bulan
- [ ] Klik "Batal" kembali ke upgrade page
- [ ] Payment history tersimpan di database

---

## Troubleshooting

**Masalah**: Route /payment/upgrade tidak ditemukan
```bash
php artisan route:clear
php artisan cache:clear
```

**Masalah**: Halaman simulasi tidak tampil
```bash
# Check if view file exists
ls resources/views/payment/simulate.blade.php
```

**Masalah**: Simulasi tidak bisa klik tombol sukses
```
Pastikan sudah login dengan Auth::check()
```

**Masalah**: Premium tidak aktif setelah klik sukses
```bash
# Check database
php artisan tinker
DB::table('users')->where('id', 1)->get()
DB::table('payments')->where('reference_code', 'MIDTRANS-1-ABC123')->get()
```

---

## Next Steps (Jika Ingin Real Payment)

1. **Dapatkan API Keys**
   - Midtrans: https://dashboard.midtrans.com
   - Stripe: https://dashboard.stripe.com

2. **Update PaymentController**
   ```php
   // Uncomment Midtrans SDK logic
   // Uncomment Stripe Session logic
   ```

3. **Add Environment Variables**
   ```env
   MIDTRANS_SERVER_KEY=SB-xxx
   MIDTRANS_CLIENT_KEY=SB-xxx
   STRIPE_SECRET_KEY=sk_test_xxx
   STRIPE_PUBLIC_KEY=pk_test_xxx
   ```

4. **Test dengan Sandbox**
   - Midtrans: Gunakan test numbers di https://docs.midtrans.com
   - Stripe: Gunakan test cards (4242 4242 4242 4242)

---

**Created by**: AI Assistant  
**Date**: 22 Jan 2026  
**Status**: ✅ Ready for Testing

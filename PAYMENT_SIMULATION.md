# Sistem Pembayaran Simulasi

## Penjelasan

Sistem pembayaran LMS ini menggunakan **simulasi murni** tanpa terhubung ke payment gateway nyata (Midtrans, Stripe, PayPal, dsb). 

Ini sangat cocok untuk:
- 🧪 Development & Testing
- 📚 Demo aplikasi
- 🎓 Pembelajaran
- ✅ QA Testing

## Fitur

### 1. **4 Metode Pembayaran Simulasi**
- 🏦 Midtrans (Simulasi)
- 💳 Stripe (Simulasi) 
- 💰 PayPal (Simulasi)
- 🔄 Transfer Manual (Simulasi)

### 2. **Flow Pembayaran**
```
User membuka landing page
    ↓
Klik "Upgrade Sekarang" 
    ↓
Redirect ke /payment/upgrade (dengan login check)
    ↓
Pilih salah satu metode pembayaran
    ↓
Masuk ke halaman simulasi
    ↓
Klik "Simulasi Pembayaran Berhasil"
    ↓
Premium diaktifkan + redirect ke dashboard
```

### 3. **Database Records**
Setiap simulasi pembayaran membuat record di tabel `payments`:
```
{
  id: 1,
  user_id: 1,
  reference_code: "MIDTRANS-1-ABC123DE",
  method: "midtrans",
  amount: 99000,
  status: "paid",
  created_at: "2026-01-22 10:30:00",
  updated_at: "2026-01-22 10:31:00"
}
```

### 4. **Aktivasi Premium**
Ketika simulasi berhasil, sistem otomatis:
- ✅ Set `users.is_premium = true`
- ✅ Set `users.premium_expires_at = sekarang + 1 bulan`
- ✅ Set `users.subscription_status = 'premium'`
- ✅ Update `payments.status = 'paid'`

## Testing

### Step-by-Step Testing

#### 1. Buat Test User
```bash
# Buka Tinker
php artisan tinker

# Buat user test
User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => bcrypt('password'),
    'email_verified_at' => now(),
    'is_premium' => false
])
```

#### 2. Login & Akses Payment
```
1. Buka localhost:8000
2. Login dengan test@example.com / password
3. Klik "Upgrade Sekarang" atau akses /payment/upgrade
```

#### 3. Pilih Metode Pembayaran
```
Pilih salah satu dari 4 metode simulasi:
- Midtrans
- Stripe
- PayPal
- Transfer Manual
```

#### 4. Simulasi Pembayaran
```
Klik tombol "Simulasi Pembayaran Berhasil"
→ Status otomatis berubah menjadi "Paid"
→ User menjadi Premium
→ Redirect ke dashboard dengan notifikasi sukses
```

#### 5. Verifikasi Premium
```bash
# Di Tinker
$user = User::find(1);
$user->is_premium;           # true
$user->premium_expires_at;   # 2026-02-22 10:31:00
$user->subscription_status;  # 'premium'
```

## File-File Penting

### Controllers
- `app/Http/Controllers/PaymentController.php` - Main controller dengan 6 methods

### Views
- `resources/views/payment/upgrade.blade.php` - Halaman pilihan metode
- `resources/views/payment/simulate.blade.php` - Halaman simulasi interaktif

### Routes
```php
// Dalam routes/web.php
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/upgrade', ...);                      // PUBLIC
    Route::get('/midtrans/checkout', ...);            // AUTH
    Route::get('/stripe/checkout', ...);              // AUTH
    Route::get('/paypal/checkout', ...);              // AUTH
    Route::get('/manual/checkout', ...);              // AUTH
    Route::get('/simulate-success', ...);             // AUTH
    Route::get('/check-status/{ref}', ...);           // AUTH
});
```

### Models
- `app/Models/Payment.php` - Payment transaction record
- `app/Models/User.php` - Extended dengan subscription fields

### Database
- `database/migrations/2026_01_21_142542_create_payments_table.php`
- `database/migrations/2026_01_21_update_users_subscription.php`

## API Responses

### GET /payment/check-status/{referenceCode}
```json
{
  "status": "paid",
  "reference_code": "MIDTRANS-1-ABC123DE",
  "amount": 99000,
  "method": "midtrans",
  "created_at": "2026-01-22T10:30:00.000000Z"
}
```

## Cara Upgrade ke Payment Gateway Real

Saat ingin upgrade ke Midtrans / Stripe real:

### 1. Untuk Midtrans
```php
// Di PaymentController@midtransCheckout
use Midtrans\Config;
use Midtrans\Snap;

Config::$serverKey = env('MIDTRANS_SERVER_KEY');
Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
Config::$isProduction = env('MIDTRANS_PRODUCTION', false);

$snapToken = Snap::getSnapToken([
    'transaction_details' => [...],
    'customer_details' => [...],
    'item_details' => [...]
]);

return view('payment.midtrans', compact('snapToken'));
```

### 2. Untuk Stripe
```php
// Di PaymentController@stripeCheckout
use Stripe\Checkout\Session;

\Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

$session = Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [...],
    'mode' => 'payment',
    'success_url' => route('payment.stripe.success'),
    'cancel_url' => route('payment.upgrade')
]);

return redirect($session->url);
```

## Environment Variables (Saat Real)

```env
# Untuk Midtrans
MIDTRANS_SERVER_KEY=SB-Mid-server-xxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxx
MIDTRANS_PRODUCTION=false

# Untuk Stripe
STRIPE_SECRET_KEY=sk_test_xxx
STRIPE_PUBLIC_KEY=pk_test_xxx
```

## Troubleshooting

### Error: "Route [payment.upgrade] not found"
```bash
php artisan route:clear
php artisan cache:clear
```

### Error: "Payment table not exist"
```bash
php artisan migrate
```

### User tidak upgrade ke premium
```bash
# Check database
php artisan tinker
DB::table('payments')->where('user_id', 1)->get()
User::find(1)->is_premium  # should be 1/true
```

## Next Steps (Untuk Produksi)

- [ ] Dapatkan API keys Midtrans (https://dashboard.midtrans.com)
- [ ] Dapatkan API keys Stripe (https://dashboard.stripe.com)
- [ ] Update PaymentController dengan implementasi real gateway
- [ ] Test webhook callbacks dari payment gateway
- [ ] Setup email notifications pada payment success/failure
- [ ] Generate payment invoices sebagai PDF
- [ ] Implementasi auto-renewal subscription
- [ ] Create admin dashboard untuk payment management
- [ ] Setup refund system
- [ ] Setup payment dispute handling

---

**Created**: 22 Jan 2026
**Status**: ✅ Simulasi Siap Testing

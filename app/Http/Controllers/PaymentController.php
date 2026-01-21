<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Tampilkan halaman upgrade premium
     */
    public function showUpgrade()
    {
        // Jika user belum login, redirect ke login
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan login terlebih dahulu untuk upgrade ke premium.');
        }

        $user = Auth::user();
        
        return view('payment.upgrade', [
            'isPremium' => $user->is_premium,
            'nextBillingDate' => $user->premium_expires_at
        ]);
    }

    /**
     * SIMULASI Midtrans Checkout
     */
    public function midtransCheckout()
    {
        $user = Auth::user();
        
        $referenceCode = 'MIDTRANS-' . $user->id . '-' . Str::random(8);

        // Simpan payment record dengan status pending
        Payment::create([
            'user_id' => $user->id,
            'reference_code' => $referenceCode,
            'method' => 'midtrans',
            'amount' => 99000,
            'status' => 'pending'
        ]);

        return view('payment.simulate', [
            'referenceCode' => $referenceCode,
            'method' => 'Midtrans',
            'amount' => 99000
        ]);
    }

    /**
     * SIMULASI Stripe Checkout
     */
    public function stripeCheckout()
    {
        $user = Auth::user();
        
        $referenceCode = 'STRIPE-' . $user->id . '-' . Str::random(8);

        Payment::create([
            'user_id' => $user->id,
            'reference_code' => $referenceCode,
            'method' => 'stripe',
            'amount' => 99000,
            'status' => 'pending'
        ]);

        return view('payment.simulate', [
            'referenceCode' => $referenceCode,
            'method' => 'Stripe',
            'amount' => 99000
        ]);
    }

    /**
     * SIMULASI PayPal Checkout
     */
    public function paypalCheckout()
    {
        $user = Auth::user();
        
        $referenceCode = 'PAYPAL-' . $user->id . '-' . Str::random(8);

        Payment::create([
            'user_id' => $user->id,
            'reference_code' => $referenceCode,
            'method' => 'paypal',
            'amount' => 99000,
            'status' => 'pending'
        ]);

        return view('payment.simulate', [
            'referenceCode' => $referenceCode,
            'method' => 'PayPal',
            'amount' => 99000
        ]);
    }

    /**
     * SIMULASI Transfer Manual
     */
    public function manualCheckout()
    {
        $user = Auth::user();
        $referenceCode = 'MANUAL-' . $user->id . '-' . Str::random(8);

        Payment::create([
            'user_id' => $user->id,
            'reference_code' => $referenceCode,
            'method' => 'transfer',
            'amount' => 99000,
            'status' => 'pending'
        ]);

        return view('payment.simulate', [
            'referenceCode' => $referenceCode,
            'method' => 'Transfer Manual',
            'amount' => 99000
        ]);
    }

    /**
     * Simulasi Success - Aktivasi Premium
     */
    public function simulateSuccess(Request $request)
    {
        $referenceCode = $request->query('ref');
        
        $payment = Payment::where('reference_code', $referenceCode)
            ->where('user_id', Auth::id())
            ->first();

        if (!$payment) {
            return redirect()->route('payment.upgrade')
                ->with('error', 'Pembayaran tidak ditemukan');
        }

        // Aktivasi premium
        $this->activatePremium($payment);

        return redirect('/dashboard')
            ->with('success', 'Selamat! Akun Anda telah diupgrade ke Premium. 🎉');
    }

    /**
     * Aktivasi Premium untuk User
     */
    private function activatePremium(Payment $payment)
    {
        $user = $payment->user;

        // Update user ke premium
        $user->update([
            'is_premium' => true,
            'premium_expires_at' => Carbon::now()->addMonth(),
            'subscription_status' => 'premium'
        ]);

        // Update payment status
        $payment->update(['status' => 'paid']);

        return true;
    }

    /**
     * Check payment status
     */
    public function checkStatus($referenceCode)
    {
        $payment = Payment::where('reference_code', $referenceCode)
            ->where('user_id', Auth::id())
            ->first();

        if (!$payment) {
            return response()->json(['status' => 'not_found'], 404);
        }

        return response()->json([
            'status' => $payment->status,
            'reference_code' => $payment->reference_code,
            'amount' => $payment->amount,
            'method' => $payment->method,
            'created_at' => $payment->created_at
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;
use Illuminate\Support\Str;


class FinanceController extends Controller
{
    /**
     * Show finance/subscription page
     */
    public function index()
    {
        try {
            $user = Auth::user();
            
            return view('finance.index', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Simulasi pembayaran premium (bypass payment gateway)
     */
    public function purchasePremium(Request $request)
    {
        try {
            $user = Auth::user();

            // Cegah beli ulang
            if ($user->isPremium()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun kamu sudah Premium.',
                ], 400);
            }

            DB::beginTransaction();

            // Simpan transaksi pembayaran (SIMULASI)
            $payment = Payment::create([
                'user_id' => $user->id,
                'reference_code' => 'INV-' . strtoupper(Str::random(8)),
                'method' => 'simulasi',
                'amount' => 25000,
                'status' => 'paid', // karena simulasi
            ]);

            // Upgrade premium
            $user->upgradeToPremium();

            // Bonus XP
            $user->addXP(100);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran Berhasil (Simulasi)! Selamat datang di Premium.',
                'reference_code' => $payment->reference_code,
                'is_premium' => $user->is_premium,
                'experience' => $user->experience,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show premium features
     */
    public function features()
    {
        try {
            $features = [
                [
                    'title' => 'Akses Unlimited',
                    'description' => 'Akses semua course dan materi tanpa batas',
                    'icon' => '🔓',
                ],
                [
                    'title' => 'Video HD',
                    'description' => 'Tonton semua video dalam kualitas HD',
                    'icon' => '🎬',
                ],
                [
                    'title' => 'Sertifikat',
                    'description' => 'Dapatkan sertifikat digital untuk setiap course',
                    'icon' => '📜',
                ],
                [
                    'title' => 'Support Priority',
                    'description' => 'Dukungan prioritas dari tim kami',
                    'icon' => '⭐',
                ],
                [
                    'title' => 'Download Content',
                    'description' => 'Download materi untuk belajar offline',
                    'icon' => '💾',
                ],
                [
                    'title' => 'Forum Eksklusif',
                    'description' => 'Bergabung dengan komunitas premium',
                    'icon' => '👥',
                ],
            ];

            return view('finance.features', compact('features'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get user subscription status
     */
    public function getSubscriptionStatus()
    {
        try {
            $user = Auth::user();

            return response()->json([
                'is_premium' => $user->isPremium(),
                'experience' => $user->experience,
                'points' => $user->points,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}

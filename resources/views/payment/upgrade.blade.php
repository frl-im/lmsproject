@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-700">← Kembali</a>
        </div>

        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Upgrade ke Premium</h1>
            <p class="text-xl text-gray-600">Dapatkan akses unlimited ke semua kursus dan fitur premium</p>
        </div>

        @if ($isPremium)
            <!-- User Sudah Premium -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="text-6xl mb-4">✅</div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Anda Sudah Premium!</h2>
                <p class="text-gray-600 mb-2">Terima kasih telah menjadi member premium kami.</p>
                <p class="text-lg font-semibold text-blue-600 mb-6">
                    Berlaku sampai: <span class="text-xl">{{ $nextBillingDate?->format('d M Y') ?? 'Selamanya' }}</span>
                </p>
                <a href="{{ route('dashboard') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Kembali ke Dashboard
                </a>
            </div>
        @else
            <!-- Pilihan Metode Pembayaran -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <!-- Paket Premium Info -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">📦 Paket Premium</h3>
                    
                    <div class="text-4xl font-bold text-blue-600 mb-6">
                        Rp 99.000
                        <span class="text-lg text-gray-600">/bulan</span>
                    </div>

                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <span class="text-green-500 mr-3 text-xl">✓</span>
                            <span class="text-gray-700">Semua Kursus Unlimited</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-3 text-xl">✓</span>
                            <span class="text-gray-700">Gamifikasi Penuh</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-3 text-xl">✓</span>
                            <span class="text-gray-700">Sertifikat Digital</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-3 text-xl">✓</span>
                            <span class="text-gray-700">Support Priority via Chat</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-3 text-xl">✓</span>
                            <span class="text-gray-700">Akses ke Fitur Eksklusif</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-3 text-xl">✓</span>
                            <span class="text-gray-700">Tidak Ada Iklan</span>
                        </li>
                    </ul>

                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                        <p class="text-sm text-blue-700">
                            <strong>💡 Tip:</strong> Pembayaran bersifat one-time per bulan. Anda dapat membatalkan kapan saja.
                        </p>
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">💳 Metode Pembayaran</h3>
                    
                    <div class="space-y-3">
                        <!-- Midtrans -->
                        <form action="{{ route('payment.midtrans.checkout') }}" method="GET">
                            <button type="submit" class="w-full border-2 border-gray-200 rounded-lg p-4 hover:border-blue-600 hover:bg-blue-50 transition text-left">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="text-3xl">🏦</div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Midtrans</h4>
                                            <p class="text-sm text-gray-600">Transfer Bank, e-wallet, Kartu Kredit</p>
                                        </div>
                                    </div>
                                    <span class="text-2xl">→</span>
                                </div>
                            </button>
                        </form>

                        <!-- Stripe -->
                        <form action="{{ route('payment.stripe.checkout') }}" method="GET">
                            <button type="submit" class="w-full border-2 border-gray-200 rounded-lg p-4 hover:border-blue-600 hover:bg-blue-50 transition text-left">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="text-3xl">💳</div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Stripe</h4>
                                            <p class="text-sm text-gray-600">Kartu Kredit Internasional</p>
                                        </div>
                                    </div>
                                    <span class="text-2xl">→</span>
                                </div>
                            </button>
                        </form>

                        <!-- Transfer Manual -->
                        <form action="{{ route('payment.manual.checkout') }}" method="GET">
                            <button type="submit" class="w-full border-2 border-gray-200 rounded-lg p-4 hover:border-blue-600 hover:bg-blue-50 transition text-left">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="text-3xl">💰</div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Transfer Manual</h4>
                                            <p class="text-sm text-gray-600">Transfer ke Rekening Kami</p>
                                        </div>
                                    </div>
                                    <span class="text-2xl">→</span>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">❓ Pertanyaan Umum</h3>
                
                <div class="space-y-4">
                    <details class="border-b pb-4 cursor-pointer">
                        <summary class="font-bold text-gray-900 hover:text-blue-600">Berapa lama layanan premium berlaku?</summary>
                        <p class="mt-3 text-gray-600">Premium berlaku selama 1 bulan sejak pembayaran diterima. Setelah itu, Anda dapat memperpanjang atau tetap menggunakan akun gratis.</p>
                    </details>

                    <details class="border-b pb-4 cursor-pointer">
                        <summary class="font-bold text-gray-900 hover:text-blue-600">Apakah pembayaran berulang?</summary>
                        <p class="mt-3 text-gray-600">Tidak. Kami menggunakan sistem pembayaran one-time. Anda perlu melakukan pembayaran manual setiap bulan jika ingin melanjutkan.</p>
                    </details>

                    <details class="border-b pb-4 cursor-pointer">
                        <summary class="font-bold text-gray-900 hover:text-blue-600">Bagaimana jika pembayaran gagal?</summary>
                        <p class="mt-3 text-gray-600">Jika pembayaran gagal, Anda dapat mencoba lagi dengan metode pembayaran lain. Status pembayaran akan ditampilkan di dashboard.</p>
                    </details>

                    <details class="pb-4 cursor-pointer">
                        <summary class="font-bold text-gray-900 hover:text-blue-600">Apakah data saya aman?</summary>
                        <p class="mt-3 text-gray-600">Ya, kami menggunakan gateway pembayaran terenkripsi dan terpercaya (Midtrans & Stripe) untuk menjaga keamanan data Anda.</p>
                    </details>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

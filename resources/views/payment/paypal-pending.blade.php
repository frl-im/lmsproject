@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="text-6xl mb-4">🅿️</div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">PayPal Coming Soon</h1>
            <p class="text-gray-600 mb-8">Integrasi PayPal sedang dalam proses pengembangan.</p>

            <p class="text-gray-700 mb-8">Untuk saat ini, silakan gunakan metode pembayaran lain:</p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                <a href="{{ route('payment.upgrade') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Kembali ke Metode Pembayaran
                </a>
                <a href="https://wa.me/6281234567890?text=Saya%20ingin%20menggunakan%20PayPal%20untuk%20upgrade%20premium" 
                   target="_blank"
                   class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Hubungi Support
                </a>
            </div>

            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-700">← Kembali ke Dashboard</a>
        </div>
    </div>
</div>
@endsection

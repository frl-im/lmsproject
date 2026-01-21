@extends('layouts.app')

@section('title', 'Simulasi Pembayaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4">
    <div class="max-w-md mx-auto">
        <!-- Card Simulasi -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-white text-center">
                <div class="mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h10m4 0a1 1 0 11-2 0m2 0a1 1 0 10-2 0m-4 0a1 1 0 11-2 0m2 0a1 1 0 10-2 0M3 21h18a2 2 0 002-2V5a2 2 0 00-2-2H3a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold mb-2">Simulasi Pembayaran</h1>
                <p class="text-blue-100">{{ $method }}</p>
            </div>

            <!-- Body -->
            <div class="p-8 space-y-6">
                <!-- Reference Code -->
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Kode Referensi</label>
                    <div class="flex items-center gap-2">
                        <input 
                            type="text" 
                            value="{{ $referenceCode }}" 
                            readonly
                            class="flex-1 px-4 py-3 bg-white border border-gray-300 rounded-lg font-mono text-sm font-bold"
                        >
                        <button 
                            onclick="copyToClipboard('{{ $referenceCode }}')"
                            class="px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                        >
                            Salin
                        </button>
                    </div>
                </div>

                <!-- Amount -->
                <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Jumlah Pembayaran</label>
                    <div class="text-3xl font-bold text-blue-600">
                        Rp {{ number_format($amount, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Info -->
                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-sm text-yellow-800">
                            <strong>Ini adalah simulasi.</strong> Tekan tombol di bawah untuk melanjutkan.
                        </p>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="text-center">
                    <span class="inline-block px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                        ⏳ Menunggu Konfirmasi
                    </span>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 p-8 space-y-3 border-t border-gray-200">
                <!-- Success Button -->
                <a 
                    href="{{ route('payment.simulate-success', ['ref' => $referenceCode]) }}"
                    class="block w-full py-4 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg font-bold text-center hover:from-green-600 hover:to-green-700 transition shadow-lg hover:shadow-xl transform hover:scale-105"
                >
                    ✓ Simulasi Pembayaran Berhasil
                </a>

                <!-- Cancel Button -->
                <a 
                    href="{{ route('payment.upgrade') }}"
                    class="block w-full py-3 bg-gray-200 text-gray-700 rounded-lg font-bold text-center hover:bg-gray-300 transition"
                >
                    Batal
                </a>
            </div>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-white rounded-lg p-6 shadow-md text-sm text-gray-600">
            <h3 class="font-semibold text-gray-900 mb-2">ℹ️ Tentang Simulasi</h3>
            <ul class="space-y-2 text-xs">
                <li>• Tekan tombol "Simulasi Pembayaran Berhasil" untuk mengaktifkan akun premium</li>
                <li>• Status pembayaran akan berubah menjadi "Paid" di database</li>
                <li>• Akun Anda akan upgrade ke premium selama 1 bulan</li>
            </ul>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('✓ Kode referensi telah disalin!');
    });
}
</script>
@endsection

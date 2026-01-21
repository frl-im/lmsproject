@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">⏳</div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Pembayaran Pending</h1>
                <p class="text-gray-600">Silakan transfer ke rekening berikut untuk mengaktifkan premium</p>
            </div>

            <!-- Detail Transfer -->
            <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-8 mb-8">
                <h3 class="font-bold text-gray-900 mb-6">📋 Detail Transfer</h3>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Bank</p>
                        <p class="text-lg font-bold text-gray-900">BCA</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Nomor Rekening</p>
                        <div class="flex items-center gap-2">
                            <p class="text-lg font-bold text-gray-900" id="accountNumber">1234567890</p>
                            <button onclick="copyToClipboard('1234567890')" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">Copy</button>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Atas Nama</p>
                        <p class="text-lg font-bold text-gray-900">PT LMS EDUKASI</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Jumlah Transfer</p>
                        <div class="flex items-center gap-2">
                            <p class="text-2xl font-bold text-green-600">Rp 99.000</p>
                            <button onclick="copyToClipboard('99000')" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">Copy</button>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Kode Referensi (Gunakan sebagai Keterangan)</p>
                        <div class="flex items-center gap-2">
                            <p class="text-lg font-mono font-bold text-gray-900" id="refCode">{{ $referenceCode }}</p>
                            <button onclick="copyToClipboard('{{ $referenceCode }}')" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">Copy</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instruksi -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-r-lg p-6 mb-8">
                <h3 class="font-bold text-gray-900 mb-3">📌 Instruksi Transfer</h3>
                <ol class="list-decimal list-inside space-y-2 text-gray-700">
                    <li>Transfer ke rekening BCA di atas dengan jumlah <strong>Rp 99.000</strong></li>
                    <li>Masukkan kode referensi <strong>{{ $referenceCode }}</strong> di bagian keterangan/berita acara</li>
                    <li>Tunggu verifikasi otomatis (biasanya 5-15 menit)</li>
                    <li>Setelah terverifikasi, akun Anda akan otomatis upgrade ke Premium</li>
                    <li>Cek dashboard Anda untuk konfirmasi</li>
                </ol>
            </div>

            <!-- Status Check -->
            <div class="bg-gray-100 rounded-lg p-6 mb-8">
                <h3 class="font-bold text-gray-900 mb-4">🔍 Cek Status Pembayaran</h3>
                <button onclick="checkPaymentStatus('{{ $referenceCode }}')" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Cek Status Sekarang
                </button>
                <div id="statusResult" class="mt-4"></div>
            </div>

            <!-- Contact Support -->
            <div class="bg-green-50 border-l-4 border-green-400 rounded-r-lg p-6 mb-8">
                <h3 class="font-bold text-gray-900 mb-3">📞 Bantuan</h3>
                <p class="text-gray-700 mb-4">Jika ada masalah dengan pembayaran Anda:</p>
                <a href="https://wa.me/6281234567890?text=Halo%20saya%20sudah%20transfer%20dengan%20kode%20referensi%20{{ $referenceCode }}" 
                   target="_blank"
                   class="inline-block px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Hubungi Support via WhatsApp
                </a>
            </div>

            <a href="{{ route('dashboard') }}" class="inline-block text-blue-600 hover:text-blue-700">← Kembali ke Dashboard</a>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Berhasil disalin!');
    });
}

function checkPaymentStatus(refCode) {
    const statusDiv = document.getElementById('statusResult');
    statusDiv.innerHTML = '<p class="text-gray-600">Mengecek status...</p>';

    fetch(`/payment/check-status/${refCode}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'paid') {
                statusDiv.innerHTML = `
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded text-green-700">
                        <p class="font-bold">✅ Pembayaran Berhasil!</p>
                        <p class="text-sm">Akun Anda sudah upgrade ke Premium. Refresh halaman untuk melihat perubahan.</p>
                    </div>
                `;
                setTimeout(() => window.location.reload(), 2000);
            } else if (data.status === 'pending') {
                statusDiv.innerHTML = `
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded text-yellow-700">
                        <p class="font-bold">⏳ Pembayaran Masih Tertunda</p>
                        <p class="text-sm">Silakan pastikan transfer sudah dilakukan dengan kode referensi yang benar.</p>
                    </div>
                `;
            } else {
                statusDiv.innerHTML = `
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded text-red-700">
                        <p class="font-bold">❌ Pembayaran Gagal</p>
                        <p class="text-sm">Status: ${data.status}</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            statusDiv.innerHTML = `
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded text-red-700">
                    <p class="font-bold">⚠️ Terjadi Kesalahan</p>
                    <p class="text-sm">${error.message}</p>
                </div>
            `;
        });
}
</script>
@endsection

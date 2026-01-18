@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">💰 Finance & Subscription</h1>
            <p class="text-gray-600">Kelola langganan dan pembayaran Anda</p>
        </div>

        <!-- Current Status -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Status -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border-l-4 border-blue-600">
                    <p class="text-gray-600 text-sm font-semibold mb-2">STATUS AKUN</p>
                    <p class="text-3xl font-bold text-blue-600 mb-2">
                        @if($user->isPremium())
                            ⭐ Premium
                        @else
                            👤 Free
                        @endif
                    </p>
                    @if(!$user->isPremium())
                        <p class="text-sm text-gray-600">Upgrade untuk akses unlimited</p>
                    @else
                        <p class="text-sm text-gray-600">Enjoy semua fitur premium!</p>
                    @endif
                </div>

                <!-- XP -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border-l-4 border-green-600">
                    <p class="text-gray-600 text-sm font-semibold mb-2">TOTAL XP</p>
                    <p class="text-3xl font-bold text-green-600">{{ $user->experience ?? 0 }}</p>
                    <p class="text-sm text-gray-600">XP dari pembelajaran</p>
                </div>

                <!-- Points -->
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-6 border-l-4 border-yellow-600">
                    <p class="text-gray-600 text-sm font-semibold mb-2">TOTAL POINTS</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $user->points ?? 0 }}</p>
                    <p class="text-sm text-gray-600">Reward points</p>
                </div>
            </div>
        </div>

        <!-- Pricing Plans -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Free Plan -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden @if(!$user->isPremium()) ring-2 ring-blue-400 @endif">
                <div class="bg-gray-100 px-6 py-4 border-b-2 border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">Paket Gratis</h2>
                    <p class="text-gray-600 mt-1">Sempurna untuk pemula</p>
                </div>
                <div class="p-6">
                    <div class="mb-6">
                        <span class="text-5xl font-bold text-gray-900">Rp 0</span>
                        <span class="text-gray-600">/bulan</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">3 Kursus gratis</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Gamifikasi dasar (XP & Badge)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Quiz & Materi dasar</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-red-500 mr-3 mt-1">✗</span>
                            <span class="text-gray-700 line-through">Akses unlimited</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-red-500 mr-3 mt-1">✗</span>
                            <span class="text-gray-700 line-through">Sertifikat</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-red-500 mr-3 mt-1">✗</span>
                            <span class="text-gray-700 line-through">Support priority</span>
                        </li>
                    </ul>
                    <button class="w-full px-6 py-3 border-2 border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition" disabled>
                        ✓ Paket Aktif
                    </button>
                </div>
            </div>

            <!-- Premium Plan -->
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg shadow-2xl overflow-hidden text-white @if($user->isPremium()) ring-2 ring-yellow-400 @endif">
                <div class="bg-red-500 px-6 py-2 text-center font-bold text-sm">
                    ⭐ PAKET TERPOPULER
                </div>
                <div class="bg-blue-700 px-6 py-4 border-b-2 border-blue-600">
                    <h2 class="text-2xl font-bold">Paket Premium</h2>
                    <p class="text-blue-100 mt-1">Akses penuh ke semua fitur</p>
                </div>
                <div class="p-6">
                    <div class="mb-6">
                        <span class="text-5xl font-bold">Rp 99.000</span>
                        <span class="text-blue-100">/bulan</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <span class="text-green-300 mr-3 mt-1">✓</span>
                            <span class="text-blue-50">Semua kursus unlimited</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-300 mr-3 mt-1">✓</span>
                            <span class="text-blue-50">Gamifikasi penuh + Custom badge</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-300 mr-3 mt-1">✓</span>
                            <span class="text-blue-50">Video HD & Download content</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-300 mr-3 mt-1">✓</span>
                            <span class="text-blue-50">Sertifikat digital</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-300 mr-3 mt-1">✓</span>
                            <span class="text-blue-50">Support 24/7 priority</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-300 mr-3 mt-1">✓</span>
                            <span class="text-blue-50">Forum komunitas eksklusif</span>
                        </li>
                    </ul>
                    @if($user->isPremium())
                        <button class="w-full px-6 py-3 bg-yellow-400 text-blue-900 font-bold rounded-lg hover:bg-yellow-300 transition" disabled>
                            ✓ Paket Aktif
                        </button>
                    @else
                        <form action="{{ route('finance.purchase') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full px-6 py-3 bg-white text-blue-600 font-bold rounded-lg hover:bg-blue-50 transition">
                                🚀 Upgrade Sekarang
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Features Comparison -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b-2 border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Perbandingan Fitur</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-900">Fitur</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-900">Gratis</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-900">Premium</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">Akses Kursus</td>
                            <td class="px-6 py-4 text-center">3 Kursus</td>
                            <td class="px-6 py-4 text-center text-green-600 font-bold">Unlimited</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">Materi Video</td>
                            <td class="px-6 py-4 text-center">SD</td>
                            <td class="px-6 py-4 text-center text-green-600 font-bold">HD</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">Gamifikasi</td>
                            <td class="px-6 py-4 text-center">✓</td>
                            <td class="px-6 py-4 text-center text-green-600 font-bold">✓ Premium</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">Download Content</td>
                            <td class="px-6 py-4 text-center text-red-500">✗</td>
                            <td class="px-6 py-4 text-center text-green-600 font-bold">✓</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">Sertifikat</td>
                            <td class="px-6 py-4 text-center text-red-500">✗</td>
                            <td class="px-6 py-4 text-center text-green-600 font-bold">✓</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">Support</td>
                            <td class="px-6 py-4 text-center">Email</td>
                            <td class="px-6 py-4 text-center text-green-600 font-bold">24/7 Priority</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">Forum Komunitas</td>
                            <td class="px-6 py-4 text-center text-red-500">✗</td>
                            <td class="px-6 py-4 text-center text-green-600 font-bold">✓ Eksklusif</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-12 bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Pertanyaan Umum</h2>
            <div class="space-y-6">
                <div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">Apakah saya bisa upgrade kapan saja?</h3>
                    <p class="text-gray-600">Ya! Anda bisa upgrade ke premium kapan saja. Pembayaran akan langsung diproses dan akses premium langsung aktif.</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">Apakah ada masa trial?</h3>
                    <p class="text-gray-600">Anda bisa mencoba 3 kursus gratis terlebih dahulu sebelum upgrade ke premium.</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">Bagaimana jika ingin downgrade?</h3>
                    <p class="text-gray-600">Hubungi tim support kami dan kami akan membantu proses downgrade Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-refresh status
    setInterval(function() {
        fetch('{{ route("finance.status") }}')
            .then(response => response.json())
            .then(data => {
                // Update jika ada perubahan
                console.log('Subscription status updated', data);
            });
    }, 30000); // Update every 30 seconds
</script>
@endpush
@endsection

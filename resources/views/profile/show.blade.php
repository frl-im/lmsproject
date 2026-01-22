@if(Auth::user() && Auth::user()->is_admin)
    @extends('layouts.admin')
@else
    @extends('layouts.app')
@endif

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-black text-blue-600 dark:text-blue-400">
                    👤 Profil Saya
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola informasi akun Anda</p>
            </div>
            <a href="{{ route('profile.edit') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 hover:shadow-lg transform hover:scale-105 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Profil
            </a>
        </div>

        <!-- Profile Hero Card -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-3xl shadow-2xl overflow-hidden">
                <div class="relative px-8 py-12 sm:py-16">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-8">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            <div class="relative">
                                <div class="w-32 h-32 rounded-3xl bg-gradient-to-br from-white to-gray-100 flex items-center justify-center shadow-2xl border-4 border-white overflow-hidden">
                                    <span class="text-6xl font-black text-blue-600">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                </div>
                                @if(Auth::user()->is_premium)
                                    <div class="absolute -bottom-2 -right-2 w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg border-4 border-white">
                                        ⭐
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Hero Info -->
                        <div class="flex-grow text-white">
                            <h2 class="text-4xl font-black mb-2">{{ Auth::user()->name }}</h2>
                            <p class="text-indigo-100 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                {{ Auth::user()->email }}
                            </p>
                            
                            <div class="flex flex-wrap gap-3">
                                @if(Auth::user()->is_admin)
                                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-white bg-opacity-20 text-white rounded-full text-sm font-bold">
                                        👨‍💼 Administrator
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-white bg-opacity-20 text-white rounded-full text-sm font-bold">
                                        📚 Siswa
                                    </span>
                                @endif
                                @if(Auth::user()->is_premium)
                                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-300 bg-opacity-30 text-yellow-100 rounded-full text-sm font-bold">
                                        ⭐ Premium
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Left Column - Stats & Info -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Quick Stats -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white text-center hover:shadow-xl transition">
                        <p class="text-4xl font-black mb-1">{{ Auth::user()->experience ?? 0 }}</p>
                        <p class="text-sm font-semibold opacity-90">Total XP</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white text-center hover:shadow-xl transition">
                        <p class="text-4xl font-black mb-1">{{ Auth::user()->courses()->count() ?? 0 }}</p>
                        <p class="text-sm font-semibold opacity-90">Kursus</p>
                    </div>
                    <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl shadow-lg p-6 text-white text-center hover:shadow-xl transition">
                        <p class="text-4xl font-black mb-1">{{ Auth::user()->badges()->count() ?? 0 }}</p>
                        <p class="text-sm font-semibold opacity-90">Badge</p>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-6">
                        <h3 class="text-2xl font-bold text-white">ℹ️ Informasi Pribadi</h3>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase">Nama Lengkap</label>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ Auth::user()->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase">Email</label>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2 break-all">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase">Bergabung Sejak</label>
                                <p class="text-lg font-bold text-gray-900 dark:text-white mt-2">{{ Auth::user()->created_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase">Status</label>
                                <p class="text-lg font-bold text-green-600 dark:text-green-400 mt-2 flex items-center gap-2">
                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span> Aktif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Learning Progress -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-6">
                        <h3 class="text-2xl font-bold text-white">📊 Statistik Pembelajaran</h3>
                    </div>
                    <div class="p-8">
                        @php
                            $totalProgress = Auth::user()->userProgresses()->count();
                            $completedProgress = Auth::user()->userProgresses()->where('is_completed', true)->count();
                            $progressPercentage = $totalProgress > 0 ? ($completedProgress / $totalProgress) * 100 : 0;
                        @endphp
                        <div class="space-y-6">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Progress Keseluruhan</span>
                                    <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ round($progressPercentage) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-full rounded-full transition-all duration-500" style="width: {{ $progressPercentage }}%"></div>
                                </div>
                            </div>

                            <div class="grid grid-cols-4 gap-4">
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-2xl p-4 text-center">
                                    <p class="text-3xl font-black text-blue-600 dark:text-blue-400">{{ $totalProgress }}</p>
                                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 mt-1">Total</p>
                                </div>
                                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 rounded-2xl p-4 text-center">
                                    <p class="text-3xl font-black text-green-600 dark:text-green-400">{{ $completedProgress }}</p>
                                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 mt-1">Selesai</p>
                                </div>
                                <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/30 dark:to-orange-800/30 rounded-2xl p-4 text-center">
                                    <p class="text-3xl font-black text-orange-600 dark:text-orange-400">{{ $totalProgress - $completedProgress }}</p>
                                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 mt-1">Belajar</p>
                                </div>
                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 rounded-2xl p-4 text-center">
                                    <p class="text-3xl font-black text-purple-600 dark:text-purple-400">{{ Auth::user()->courses()->count() }}</p>
                                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 mt-1">Kursus</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-6">
                <!-- Account Status Card -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-6">
                        <h3 class="text-lg font-bold text-white">🔒 Keamanan Akun</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">Email Terverifikasi</p>
                            <div class="flex items-center gap-2 mt-2">
                                @if(Auth::user()->email_verified_at)
                                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                                    <span class="text-sm text-green-600 dark:text-green-400 font-semibold">Ya</span>
                                @else
                                    <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                                    <span class="text-sm text-yellow-600 dark:text-yellow-400 font-semibold">Belum</span>
                                @endif
                            </div>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">Kata Sandi</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Terakhir diubah {{ Auth::user()->updated_at->diffForHumans() }}</p>
                            <a href="{{ route('profile.edit') }}" class="text-sm text-blue-600 dark:text-blue-400 font-semibold hover:underline mt-2 inline-block">Ubah kata sandi</a>
                        </div>
                    </div>
                </div>

                <!-- Member Status -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-6">
                        <h3 class="text-lg font-bold text-white">⭐ Status Member</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br {{ Auth::user()->is_premium ? 'from-yellow-300 to-yellow-500' : 'from-gray-300 to-gray-500' }} flex items-center justify-center shadow-lg">
                                {{ Auth::user()->is_premium ? '⭐' : '👤' }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 dark:text-white">
                                    {{ Auth::user()->is_premium ? 'Premium' : 'Reguler' }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ Auth::user()->is_premium ? 'Akses penuh' : 'Upgrade untuk akses premium' }}
                                </p>
                            </div>
                        </div>
                        @if(!Auth::user()->is_premium)
                            <a href="{{ route('dashboard') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-bold rounded-lg hover:shadow-lg transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                Upgrade Sekarang
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('dashboard') }}" class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white font-bold py-4 px-4 rounded-2xl text-center hover:shadow-lg transition">
                        <div class="text-2xl mb-1">🏠</div>
                        <span class="text-xs">Dashboard</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="bg-gradient-to-br from-pink-500 to-rose-600 text-white font-bold py-4 px-4 rounded-2xl text-center hover:shadow-lg transition">
                        <div class="text-2xl mb-1">✏️</div>
                        <span class="text-xs">Edit Profil</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Badges Section -->
        @if(Auth::user()->badges()->exists())
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-6">
                    <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                        🏆 Pencapaian & Lencana
                    </h3>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                        @foreach(Auth::user()->badges as $badge)
                            <div class="group text-center">
                                <div class="mb-3">
                                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-yellow-300 to-yellow-500 rounded-full flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-110 transition transform">
                                        ⭐
                                    </div>
                                </div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $badge->name }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

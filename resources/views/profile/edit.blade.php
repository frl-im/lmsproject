@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-black bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    ✏️ Edit Profil
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Ubah informasi akun Anda</p>
            </div>
            <a href="{{ route('profile.show') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Edit Forms -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Edit Profile Information -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 px-8 py-6">
                        <h3 class="text-2xl font-bold text-white">👤 Informasi Pribadi</h3>
                    </div>
                    <div class="p-8">
                        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PATCH')

                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wider">Nama Lengkap</label>
                                <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" required
                                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wider">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required
                                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                                @if (Auth::user()->email_verified_at === null)
                                    <p class="text-orange-500 text-sm mt-2 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Email Anda belum terverifikasi
                                    </p>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-3 pt-4">
                                <button type="submit" class="flex-grow px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold rounded-xl hover:shadow-lg transform hover:scale-105 transition">
                                    💾 Simpan Perubahan
                                </button>
                            </div>

                            @if (session('status') === 'profile-updated')
                                <div class="mt-4 p-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-xl flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Profil berhasil diperbarui!
                                </div>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Update Password -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-8 py-6">
                        <h3 class="text-2xl font-bold text-white">🔐 Ubah Kata Sandi</h3>
                    </div>
                    <div class="p-8">
                        <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wider">Kata Sandi Saat Ini</label>
                                <input type="password" name="current_password" id="current_password" autocomplete="current-password"
                                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-800 transition">
                                @error('current_password')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wider">Kata Sandi Baru</label>
                                <input type="password" name="password" id="password" autocomplete="new-password"
                                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-800 transition">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wider">Konfirmasi Kata Sandi</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-800 transition">
                                @error('password_confirmation')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-3 pt-4">
                                <button type="submit" class="flex-grow px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-xl hover:shadow-lg transform hover:scale-105 transition">
                                    🔄 Ubah Kata Sandi
                                </button>
                            </div>

                            @if (session('status') === 'password-updated')
                                <div class="mt-4 p-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-xl flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Kata sandi berhasil diubah!
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-6">
                <!-- Account Info Card -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-6 py-6">
                        <h3 class="text-lg font-bold text-white">ℹ️ Informasi Akun</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase">Nama</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white mt-1">{{ Auth::user()->name }}</p>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase">Email</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white mt-1 break-all">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase">Member Sejak</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white mt-1">{{ Auth::user()->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase">Tipe Akun</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white mt-1 flex items-center gap-2">
                                @if(Auth::user()->is_admin)
                                    👨‍💼 Administrator
                                @else
                                    📚 Siswa
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Security Status -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-red-500 to-pink-500 px-6 py-6">
                        <h3 class="text-lg font-bold text-white">🔒 Keamanan</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Email Terverifikasi</span>
                            @if(Auth::user()->email_verified_at)
                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 rounded-full text-xs font-bold">✓ Ya</span>
                            @else
                                <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 rounded-full text-xs font-bold">⚠ Belum</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">2FA (Two-Factor Auth)</span>
                            <span class="px-3 py-1 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-300 rounded-full text-xs font-bold">Belum Aktif</span>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden border-2 border-red-200 dark:border-red-800">
                    <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-6">
                        <h3 class="text-lg font-bold text-white">⚠️ Zona Bahaya</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Tindakan berikut tidak dapat dibatalkan. Harap berhati-hati.</p>
                        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            
                            <div class="mb-4">
                                <label for="password_delete" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Konfirmasi dengan Kata Sandi</label>
                                <input type="password" name="password" id="password_delete" placeholder="Masukkan kata sandi Anda"
                                       class="w-full px-4 py-3 rounded-xl border-2 border-red-300 dark:border-red-800 dark:bg-gray-700 dark:text-white focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-800 transition">
                            </div>

                            <button type="submit" class="w-full px-4 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl transition">
                                🗑️ Hapus Akun Permanen
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Help Card -->
                <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/30 dark:to-purple-900/30 rounded-3xl border-2 border-blue-200 dark:border-blue-800 p-6">
                    <h4 class="font-bold text-gray-900 dark:text-white mb-3">💡 Butuh Bantuan?</h4>
                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">Jika Anda memiliki pertanyaan tentang akun Anda atau memerlukan bantuan, jangan ragu untuk menghubungi kami.</p>
                    <a href="#" class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                        Hubungi Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

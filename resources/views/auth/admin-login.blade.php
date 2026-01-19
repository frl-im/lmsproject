<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-gray-900 to-black dark:from-slate-950 dark:via-black dark:to-black flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Header Section -->
            <div class="text-center mb-8">
                <div class="mb-4">
                    <span class="text-5xl md:text-6xl">🔐</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-amber-400 to-orange-400 bg-clip-text text-transparent mb-2">
                    Admin Panel
                </h1>
                <p class="text-gray-300 text-base md:text-lg">
                    ⚙️ Area Administrasi LMS
                </p>
                <p class="text-gray-500 text-sm mt-2">
                    Kelola kursus dan pantau siswa
                </p>
            </div>

            <!-- Quick Access Menu -->
            <div class="bg-gradient-to-r from-amber-900/30 to-orange-900/30 border border-amber-700/50 rounded-xl p-4 mb-6">
                <div class="grid grid-cols-3 gap-3 text-center text-xs">
                    <div>
                        <div class="text-2xl mb-1">📊</div>
                        <p class="font-semibold text-gray-300">Dashboard</p>
                    </div>
                    <div>
                        <div class="text-2xl mb-1">📚</div>
                        <p class="font-semibold text-gray-300">Kursus</p>
                    </div>
                    <div>
                        <div class="text-2xl mb-1">👥</div>
                        <p class="font-semibold text-gray-300">Siswa</p>
                    </div>
                </div>
            </div>

            <!-- Card Form -->
            <div class="bg-gradient-to-b from-gray-800 to-gray-900 dark:from-gray-900 dark:to-black rounded-2xl shadow-2xl overflow-hidden border border-gray-700">
                <div class="px-6 py-8 sm:px-8">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-6" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-200 mb-2">
                                📧 Email Admin
                            </label>
                            <x-text-input 
                                id="email" 
                                class="block w-full px-4 py-3 border-2 border-gray-600 rounded-lg bg-gray-800 text-white placeholder-gray-500 focus:border-amber-500 focus:ring-2 focus:ring-amber-400 transition" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autofocus 
                                autocomplete="username"
                                placeholder="admin@example.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-200 mb-2">
                                🔑 Password
                            </label>
                            <x-text-input 
                                id="password" 
                                class="block w-full px-4 py-3 border-2 border-gray-600 rounded-lg bg-gray-800 text-white placeholder-gray-500 focus:border-amber-500 focus:ring-2 focus:ring-amber-400 transition"
                                type="password"
                                name="password"
                                required 
                                autocomplete="current-password"
                                placeholder="Masukkan password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Warning Box with Gradient -->
                        <div class="bg-gradient-to-r from-amber-900/40 to-orange-900/40 border-l-4 border-amber-500 p-4 rounded-lg backdrop-blur">
                            <p class="text-sm text-amber-100 flex items-center gap-2">
                                <span class="text-lg">⚠️</span>
                                <span><strong>Akses Terbatas:</strong> Hanya admin terdaftar yang boleh login di sini.</span>
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-amber-600 via-orange-600 to-amber-600 hover:from-amber-700 hover:via-orange-700 hover:to-amber-700 text-white font-bold py-3 px-4 rounded-lg transition-all transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-amber-400 dark:focus:ring-amber-600 shadow-lg">
                            🚀 Login Admin
                        </button>

                        <!-- Links Section -->
                        <div class="space-y-2 text-center">
                            @if (Route::has('password.request'))
                                <a class="block text-sm text-amber-300 hover:text-amber-200 font-semibold transition duration-200" href="{{ route('password.request') }}">
                                    🔑 Lupa Password?
                                </a>
                            @endif

                            <div class="pt-3 border-t border-gray-600">
                                <p class="text-gray-400 text-sm mb-2">
                                    Bukan admin?
                                </p>
                                <a href="{{ route('login') }}" class="inline-block text-blue-400 hover:text-blue-300 font-bold transition duration-200">
                                    👨‍🎓 Login sebagai Siswa →
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer with Quick Links -->
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-5 sm:px-8 border-t border-gray-600">
                    <div class="space-y-3">
                        <p class="text-center text-sm font-semibold text-gray-300">
                            📋 Quick Admin Actions
                        </p>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <a href="#" class="block text-center bg-gray-600 hover:bg-gray-500 text-gray-200 py-2 px-3 rounded transition duration-200">
                                📊 Dashboard
                            </a>
                            <a href="#" class="block text-center bg-gray-600 hover:bg-gray-500 text-gray-200 py-2 px-3 rounded transition duration-200">
                                👥 Kelola Siswa
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Features Info -->
            <div class="mt-8 space-y-4">
                <div class="bg-gray-800/50 dark:bg-gray-900/50 backdrop-blur rounded-lg p-4 border border-gray-700">
                    <h3 class="text-amber-300 font-bold mb-3 text-sm flex items-center gap-2">
                        <span>✨</span> Fitur Admin
                    </h3>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li class="flex items-center gap-2">
                            <span class="text-amber-400">•</span>
                            <span>Kelola kursus, modul, dan pelajaran</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-amber-400">•</span>
                            <span>Monitor progress dan statistik siswa</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-amber-400">•</span>
                            <span>Kelola badge, poin, dan leaderboard</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-amber-400">•</span>
                            <span>Generate laporan dan analitik</span>
                        </li>
                    </ul>
                </div>

                <!-- Home Link -->
                <div class="text-center">
                    <a href="/" class="text-gray-500 hover:text-gray-400 text-sm font-semibold transition duration-200">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
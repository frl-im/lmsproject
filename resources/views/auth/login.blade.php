<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 dark:from-gray-900 dark:via-purple-900 dark:to-gray-800 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Header Section -->
            <div class="text-center mb-8">
                <div class="mb-4">
                    <span class="text-5xl md:text-6xl">👨‍🎓</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 bg-clip-text text-transparent mb-2">
                    Login Siswa
                </h1>
                <p class="text-gray-600 dark:text-gray-300 text-base md:text-lg">
                    ✨ Mulai Petualangan Belajar Anda!
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                    Akses kursus, kuis, dan raih poin
                </p>
            </div>

            <!-- Quick Stats/Features Menu -->
            <div class="bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-xl p-4 mb-6 border border-blue-200 dark:border-blue-800/50">
                <div class="grid grid-cols-3 gap-3 text-center">
                    <div>
                        <div class="text-2xl mb-1">🏆</div>
                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">Poin & Badge</p>
                    </div>
                    <div>
                        <div class="text-2xl mb-1">📚</div>
                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">Ribuan Kursus</p>
                    </div>
                    <div>
                        <div class="text-2xl mb-1">📊</div>
                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">Track Progress</p>
                    </div>
                </div>
            </div>

            <!-- Card Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-8 sm:px-8">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-6" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                📧 Email
                            </label>
                            <x-text-input 
                                id="email" 
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-600 transition" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autofocus 
                                autocomplete="username"
                                placeholder="nama@example.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                🔐 Password
                            </label>
                            <x-text-input 
                                id="password" 
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-600 transition"
                                type="password"
                                name="password"
                                required 
                                autocomplete="current-password"
                                placeholder="Masukkan password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 cursor-pointer" 
                                name="remember">
                            <label for="remember_me" class="ms-2 text-sm text-gray-600 dark:text-gray-400 cursor-pointer">
                                {{ __('Ingat saya') }}
                            </label>
                        </div>

                        <!-- Submit Button with Icon -->
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 hover:from-blue-600 hover:via-purple-600 hover:to-pink-600 text-white font-bold py-3 px-4 rounded-lg transition-all transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-purple-600 shadow-lg flex items-center justify-center gap-2">
                            ✨ Masuk Sekarang
                        </button>

                        <!-- Links Section -->
                        <div class="space-y-2 text-center">
                            @if (Route::has('password.request'))
                                <a class="block text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold transition duration-200" href="{{ route('password.request') }}">
                                    🔑 Lupa Password?
                                </a>
                            @endif

                            <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                    Belum punya akun?
                                </p>
                                <a href="{{ route('register') }}" class="inline-block text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-bold transition duration-200">
                                    📝 Daftar di sini →
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer with Navigation -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-700 dark:to-gray-800 px-6 py-5 sm:px-8 border-t border-gray-200 dark:border-gray-600">
                    <div class="space-y-3">
                        <p class="text-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                            🔐 Atau Akses sebagai Admin
                        </p>
                        <a href="{{ route('admin.login') }}" class="block text-center w-full bg-white dark:bg-gray-600 hover:bg-gray-100 dark:hover:bg-gray-500 text-gray-800 dark:text-white font-semibold py-2 px-4 rounded-lg transition duration-200 border border-gray-300 dark:border-gray-500">
                            Admin Login →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 space-y-4">
                <!-- Feature Highlights -->
                <div class="bg-white/50 dark:bg-gray-800/50 backdrop-blur rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                    <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                        <p class="flex items-center gap-2">
                            <span class="text-lg">🎓</span>
                            <span>Pembelajaran interaktif dengan berbagai metode</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <span class="text-lg">🏅</span>
                            <span>Kumpulkan poin, badge, dan naik leaderboard</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <span class="text-lg">📱</span>
                            <span>Akses dari desktop, tablet, atau smartphone</span>
                        </p>
                    </div>
                </div>

                <!-- Home Link -->
                <div class="text-center">
                    <a href="/" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-sm font-semibold transition duration-200">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

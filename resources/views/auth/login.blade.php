<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-white to-blue-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-sm">
            <!-- Header Section -->
            <div class="text-center mb-10">
                <div class="mb-4">
                    <span class="text-6xl md:text-7xl inline-block">👨‍🎓</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-blue-600 mb-3">
                    Masuk Siswa
                </h1>
                <p class="text-gray-600 text-base font-semibold">
                    ✨ Mulai Petualangan Belajar Anda
                </p>
            </div>

            <!-- Quick Stats Menu -->
            <div class="bg-blue-50 rounded-xl p-4 mb-8 border-2 border-blue-200">
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <div class="text-3xl mb-2">🏆</div>
                        <p class="text-xs font-bold text-gray-800">Poin & Badge</p>
                    </div>
                    <div>
                        <div class="text-3xl mb-2">📚</div>
                        <p class="text-xs font-bold text-gray-800">Ribuan Kursus</p>
                    </div>
                    <div>
                        <div class="text-3xl mb-2">📊</div>
                        <p class="text-xs font-bold text-gray-800">Track Progress</p>
                    </div>
                </div>
            </div>

            <!-- Main Card Form -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-gray-300">
                <!-- Form Section -->
                <div class="px-8 py-10">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-6" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-800 mb-3">
                                📧 Alamat Email
                            </label>
                            <x-text-input 
                                id="email" 
                                class="block w-full px-4 py-3 border-2 border-gray-400 rounded-lg bg-white text-gray-900 placeholder-gray-500 font-semibold focus:border-blue-600 focus:ring-2 focus:ring-blue-300 transition" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autofocus 
                                autocomplete="username"
                                placeholder="nama@example.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 font-semibold text-red-600" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-800 mb-3">
                                🔐 Kata Sandi
                            </label>
                            <x-text-input 
                                id="password" 
                                class="block w-full px-4 py-3 border-2 border-gray-400 rounded-lg bg-white text-gray-900 placeholder-gray-500 font-semibold focus:border-blue-600 focus:ring-2 focus:ring-blue-300 transition"
                                type="password"
                                name="password"
                                required 
                                autocomplete="current-password"
                                placeholder="Masukkan kata sandi" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 font-semibold text-red-600" />
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer">
                                <input 
                                    id="remember_me" 
                                    type="checkbox" 
                                    class="w-5 h-5 text-blue-600 border-2 border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-300 cursor-pointer" 
                                    name="remember">
                                <span class="ms-3 text-sm font-semibold text-gray-800">
                                    Ingat saya
                                </span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-black font-bold py-4 px-4 rounded-xl transition-all transform hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-400 shadow-lg text-base">
                            ✨ Masuk Sekarang
                        </button>

                        <!-- Register Link -->
                        <div class="text-center pt-4 border-t-2 border-gray-300">
                            <p class="text-sm font-semibold text-gray-700 mb-3">
                                Belum punya akun?
                            </p>
                            <a href="{{ route('register') }}" class="inline-block text-sm font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 px-6 py-2 rounded-lg transition">
                                📝 Daftar Sekarang
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Admin Link Section -->
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-8 py-6 border-t-2 border-gray-300">
                    <p class="text-center text-sm font-bold text-gray-800 mb-3">
                        🔐 Adalah Admin?
                    </p>
                    <a href="{{ route('admin.login') }}" class="block text-center w-full bg-white hover:bg-gray-100 text-gray-800 font-bold py-3 px-4 rounded-xl transition border-2 border-gray-400">
                        Login Admin →
                    </a>
                </div>
            </div>

            <!-- Feature Highlights -->
            <div class="mt-10">
                <div class="bg-white rounded-xl shadow-md border-2 border-gray-300 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">✨ Keuntungan Belajar di Sini</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-3">
                            <span class="text-2xl flex-shrink-0">🎓</span>
                            <span class="font-semibold text-gray-800">Pembelajaran interaktif dengan berbagai metode menarik</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-2xl flex-shrink-0">🏅</span>
                            <span class="font-semibold text-gray-800">Kumpulkan poin, badge, dan naik di leaderboard</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-2xl flex-shrink-0">📱</span>
                            <span class="font-semibold text-gray-800">Akses dari desktop, tablet, atau smartphone</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Home Link -->
            <div class="text-center mt-8">
                <a href="/" class="text-gray-700 hover:text-blue-600 font-bold transition text-sm">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>

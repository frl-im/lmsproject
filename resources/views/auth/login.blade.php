<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-blue-600 dark:text-blue-400 mb-2">
                    🚀 LMS Gamifikasi
                </h1>
                <p class="text-gray-600 dark:text-gray-300 text-lg">
                    Login Siswa - Mulai Petualangan Belajar!
                </p>
            </div>

            <!-- Card Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden">
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

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-3 px-4 rounded-lg transition-all transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-600 shadow-lg">
                            ✨ Masuk Sekarang
                        </button>

                        <!-- Links -->
                        <div class="space-y-3 text-center">
                            @if (Route::has('password.request'))
                                <a class="block text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold" href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif

                            <div class="pt-2">
                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                    Belum punya akun? 
                                    <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-bold">
                                        Daftar di sini
                                    </a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Admin Login Link -->
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 sm:px-8 border-t border-gray-200 dark:border-gray-600">
                    <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                        Admin? 
                        <a href="{{ route('admin.login') }}" class="text-gray-800 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white font-bold">
                            Login di sini
                        </a>
                    </p>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="mt-8 text-center">
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Platform pembelajaran gamifikasi yang seru dan interaktif
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>

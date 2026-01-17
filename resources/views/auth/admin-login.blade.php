<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-800 to-gray-900 dark:from-gray-950 dark:to-black flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-100 mb-2">
                    🔐 Admin Panel
                </h1>
                <p class="text-gray-400 text-lg">
                    LMS Gamifikasi - Area Administrasi
                </p>
            </div>

            <!-- Card Form -->
            <div class="bg-gray-700 dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-600">
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

                        <!-- Warning Box -->
                        <div class="bg-amber-900 border-l-4 border-amber-500 p-4 rounded">
                            <p class="text-sm text-amber-100">
                                ⚠️ <strong>Akses Terbatas:</strong> Hanya admin terdaftar yang boleh login di sini.
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-bold py-3 px-4 rounded-lg transition-all transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-amber-400 dark:focus:ring-amber-600 shadow-lg">
                            🚀 Login Admin
                        </button>

                        <!-- Links -->
                        <div class="space-y-3 text-center">
                            @if (Route::has('password.request'))
                                <a class="block text-sm text-amber-300 hover:text-amber-200 font-semibold" href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif

                            <div class="pt-2 border-t border-gray-600">
                                <p class="text-gray-400 text-sm">
                                    Bukan admin? 
                                    <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-bold">
                                        Login sebagai Siswa
                                    </a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Back Link -->
            <div class="mt-8 text-center">
                <a href="/" class="text-gray-400 hover:text-gray-200 text-sm font-semibold">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
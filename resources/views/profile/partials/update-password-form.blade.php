<section>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
            <svg class="w-7 h-7 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
            </svg>
            Keamanan Akun
        </h2>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Pastikan akun Anda dilindungi dengan kata sandi yang kuat dan aman
        </p>
    </div>

    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18.243 3.579A2 2 0 0016.738 3H3.262a2 2 0 00-1.505.579A2 2 0 001 5.952V5a2 2 0 012-2h14a2 2 0 012 2v.952a2 2 0 00-.757-1.373zM16.738 5a.938.938 0 01-.764.36H4.026a.938.938 0 01-.764-.36m0 0A2 2 0 003.262 5h13.476a2 2 0 00-1.505.579zM18 7v10a2 2 0 01-2 2H4a2 2 0 01-2-2V7m16 0H2" clip-rule="evenodd"></path>
            </svg>
            <div>
                <p class="text-sm font-medium text-blue-800 dark:text-blue-200">
                    Gunakan kata sandi minimal 8 karakter dengan kombinasi huruf besar, kecil, angka, dan simbol
                </p>
            </div>
        </div>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Kata Sandi Saat Ini -->
        <div class="group">
            <label for="update_password_current_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                    </svg>
                    Kata Sandi Saat Ini
                </span>
            </label>
            <input id="update_password_current_password" name="current_password" type="password" 
                   class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900 transition group-hover:border-gray-300 dark:group-hover:border-gray-500" 
                   autocomplete="current-password" placeholder="Masukkan kata sandi Anda saat ini" />
            @if ($errors->updatePassword->has('current_password'))
                <div class="mt-2 flex items-center gap-2 text-red-600 dark:text-red-400 text-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 14.586 7.314 11.9a1 1 0 10-1.414 1.414l3.182 3.182a1 1 0 001.414 0l8.02-8.02z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $errors->updatePassword->first('current_password') }}
                </div>
            @endif
        </div>

        <!-- Kata Sandi Baru -->
        <div class="group">
            <label for="update_password_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
                    </svg>
                    Kata Sandi Baru
                </span>
            </label>
            <input id="update_password_password" name="password" type="password" 
                   class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900 transition group-hover:border-gray-300 dark:group-hover:border-gray-500" 
                   autocomplete="new-password" placeholder="Masukkan kata sandi baru" />
            @if ($errors->updatePassword->has('password'))
                <div class="mt-2 flex items-center gap-2 text-red-600 dark:text-red-400 text-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 14.586 7.314 11.9a1 1 0 10-1.414 1.414l3.182 3.182a1 1 0 001.414 0l8.02-8.02z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $errors->updatePassword->first('password') }}
                </div>
            @endif
        </div>

        <!-- Konfirmasi Kata Sandi Baru -->
        <div class="group">
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Konfirmasi Kata Sandi
                </span>
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                   class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-900 transition group-hover:border-gray-300 dark:group-hover:border-gray-500" 
                   autocomplete="new-password" placeholder="Ulangi kata sandi baru" />
            @if ($errors->updatePassword->has('password_confirmation'))
                <div class="mt-2 flex items-center gap-2 text-red-600 dark:text-red-400 text-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 14.586 7.314 11.9a1 1 0 10-1.414 1.414l3.182 3.182a1 1 0 001.414 0l8.02-8.02z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $errors->updatePassword->first('password_confirmation') }}
                </div>
            @endif
        </div>

        <!-- Tombol Simpan -->
        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5 13a3 3 0 105.119-6H9a3 3 0 01.5 0m.5-3a3 3 0 01.5 0H14a3 3 0 10-1.5 2.5M9 19h6a2 2 0 002-2V7a2 2 0 00-2-2h-6a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Ubah Kata Sandi
            </button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="flex items-center gap-2 text-green-600 dark:text-green-400 font-medium">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Kata sandi berhasil diubah!
                </div>
            @endif
        </div>
    </form>
</section>

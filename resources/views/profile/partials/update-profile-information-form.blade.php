<section>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
            <svg class="w-7 h-7 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
            </svg>
            Informasi Dasar
        </h2>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Kelola informasi profil dan email Anda
        </p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Nama Lengkap -->
        <div class="group">
            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                    </svg>
                    Nama Lengkap
                </span>
            </label>
            <input id="name" name="name" type="text" 
                   class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-900 transition group-hover:border-gray-300 dark:group-hover:border-gray-500" 
                   value="{{ old('name', $user->name) }}" 
                   required autofocus autocomplete="name" placeholder="Masukkan nama lengkap Anda" />
            @if ($errors->has('name'))
                <div class="mt-2 flex items-center gap-2 text-red-600 dark:text-red-400 text-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 14.586 7.314 11.9a1 1 0 10-1.414 1.414l3.182 3.182a1 1 0 001.414 0l8.02-8.02z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $errors->first('name') }}
                </div>
            @endif
        </div>

        <!-- Email -->
        <div class="group">
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </svg>
                    Alamat Email
                </span>
            </label>
            <input id="email" name="email" type="email" 
                   class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-900 transition group-hover:border-gray-300 dark:group-hover:border-gray-500" 
                   value="{{ old('email', $user->email) }}" 
                   required autocomplete="username" placeholder="example@lms.com" />
            @if ($errors->has('email'))
                <div class="mt-2 flex items-center gap-2 text-red-600 dark:text-red-400 text-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 14.586 7.314 11.9a1 1 0 10-1.414 1.414l3.182 3.182a1 1 0 001.414 0l8.02-8.02z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $errors->first('email') }}
                </div>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border-2 border-yellow-200 dark:border-yellow-700 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                Email Anda belum diverifikasi
                            </p>
                            <button form="send-verification" class="mt-2 text-sm font-semibold text-yellow-700 dark:text-yellow-300 hover:text-yellow-900 dark:hover:text-yellow-100 underline transition">
                                Kirim ulang link verifikasi
                            </button>
                        </div>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded">
                            <p class="text-sm font-medium text-green-700 dark:text-green-300">
                                Link verifikasi telah dikirim ke email Anda
                            </p>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Tombol Simpan -->
        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5 13a3 3 0 105.119-6H9a3 3 0 01.5 0m.5-3a3 3 0 01.5 0H14a3 3 0 10-1.5 2.5M9 19h6a2 2 0 002-2V7a2 2 0 00-2-2h-6a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="flex items-center gap-2 text-green-600 dark:text-green-400 font-medium">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Profil berhasil diperbarui!
                </div>
            @endif
        </div>
    </form>
</section>

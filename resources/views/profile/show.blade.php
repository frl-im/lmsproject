<x-app-layout>
    @php
        $user = $user ?? auth()->user();
    @endphp
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Profil Saya') }}
            </h2>
            <a href="{{ route('profile.edit') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                </svg>
                Edit Profil
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Profile Hero Card -->
            <div class="mb-8">
                <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-3xl shadow-2xl overflow-hidden">
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full -mr-48 -mt-48"></div>
                        <div class="absolute bottom-0 left-0 w-80 h-80 bg-white rounded-full -ml-40 -mb-40"></div>
                    </div>
                    
                    <div class="relative z-10 px-8 py-12 sm:py-16">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-8">
                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                <div class="relative">
                                    <div class="w-32 h-32 rounded-3xl bg-gradient-to-br from-white to-gray-100 flex items-center justify-center shadow-2xl border-4 border-white overflow-hidden">
                                        <span class="text-6xl font-black text-transparent bg-gradient-to-br from-indigo-600 to-pink-600 bg-clip-text">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    @if($user->is_premium)
                                        <div class="absolute -bottom-2 -right-2 w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg border-4 border-white">
                                            <svg class="w-6 h-6 text-yellow-700" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- User Info -->
                            <div class="flex-grow">
                                <h1 class="text-4xl sm:text-5xl font-black text-white mb-3 leading-tight">
                                    {{ $user->name }}
                                </h1>
                                <p class="text-xl text-indigo-100 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                    {{ $user->email }}
                                </p>
                                
                                <div class="flex flex-wrap gap-3 mb-4">
                                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-white bg-opacity-20 text-white rounded-full text-sm font-bold backdrop-blur-sm border border-white border-opacity-30">
                                        @if($user->is_admin)
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5.951-1.429 5.951 1.429a1 1 0 001.169-1.409l-7-14z"></path>
                                            </svg>
                                            Administratur
                                        @else
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                            </svg>
                                            Siswa
                                        @endif
                                    </span>
                                    @if($user->is_premium)
                                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-300 bg-opacity-30 text-yellow-100 rounded-full text-sm font-bold backdrop-blur-sm border border-yellow-300 border-opacity-50">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            Premium
                                        </span>
                                    @endif
                                </div>

                                <!-- Member Since -->
                                <p class="text-indigo-100 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v2H4a2 2 0 00-2 2v2h16V7a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v2H7V3a1 1 0 00-1-1zm0 5a2 2 0 002 2h8a2 2 0 002-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Bergabung sejak {{ $user->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Left Column - Stats -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-indigo-500 hover:shadow-xl transition">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Poin Pengalaman</p>
                                    <p class="text-4xl font-black text-indigo-600 dark:text-indigo-400 mt-2">{{ $user->points ?? 0 }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">Total pengalaman</p>
                                </div>
                                <div class="w-14 h-14 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Kursus Diambil</p>
                                    <p class="text-4xl font-black text-purple-600 dark:text-purple-400 mt-2">{{ $user->courses()->count() ?? 0 }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">Aktif sedang belajar</p>
                                </div>
                                <div class="w-14 h-14 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-7 h-7 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-pink-500 hover:shadow-xl transition">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Pencapaian</p>
                                    <p class="text-4xl font-black text-pink-600 dark:text-pink-400 mt-2">{{ $user->badges()->count() ?? 0 }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">Lencana diperoleh</p>
                                </div>
                                <div class="w-14 h-14 bg-pink-100 dark:bg-pink-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-7 h-7 text-pink-600 dark:text-pink-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6 4a2 2 0 012-2h4a1 1 0 100-2H8a4 4 0 00-4 4v12a4 4 0 004 4h4a4 4 0 004-4V7a1 1 0 100 2h1a1 1 0 102-2h-1V4a2 2 0 00-2-2h-1a1 1 0 100 2h1v1a1 1 0 100 2H8a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-cyan-500 px-8 py-6">
                            <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                </svg>
                                Informasi Pribadi
                            </h3>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Nama Lengkap -->
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Nama Lengkap</p>
                                    <p class="text-xl font-bold text-gray-900 dark:text-white mt-2">{{ $user->name }}</p>
                                </div>

                                <!-- Email -->
                                <div class="border-l-4 border-cyan-500 pl-4">
                                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Email</p>
                                    <p class="text-xl font-bold text-gray-900 dark:text-white mt-2 break-all">{{ $user->email }}</p>
                                </div>

                                <!-- Member Since -->
                                <div class="border-l-4 border-green-500 pl-4">
                                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Bergabung Sejak</p>
                                    <p class="text-xl font-bold text-gray-900 dark:text-white mt-2">{{ $user->created_at->format('d M Y') }}</p>
                                </div>

                                <!-- Account Status -->
                                <div class="border-l-4 border-purple-500 pl-4">
                                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Status Akun</p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                                        <span class="text-lg font-bold text-green-600 dark:text-green-400">Aktif</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Learning Statistics -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-8 py-6">
                            <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                                </svg>
                                Statistik Pembelajaran
                            </h3>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <!-- Total Lessons -->
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-2xl p-6 text-center hover:shadow-lg transition">
                                    <div class="w-12 h-12 mx-auto bg-blue-500 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 100-2 4 4 0 00-4 4v10a4 4 0 004 4h12a4 4 0 004-4V5a4 4 0 00-4-4 1 1 0 100 2 2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <p class="text-3xl font-black text-blue-600 dark:text-blue-400">{{ $user->userProgresses()->count() ?? 0 }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 font-semibold mt-2">Total Pelajaran</p>
                                </div>

                                <!-- Completed -->
                                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 rounded-2xl p-6 text-center hover:shadow-lg transition">
                                    <div class="w-12 h-12 mx-auto bg-green-500 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <p class="text-3xl font-black text-green-600 dark:text-green-400">{{ $user->userProgresses()->where('is_completed', true)->count() ?? 0 }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 font-semibold mt-2">Selesai</p>
                                </div>

                                <!-- In Progress -->
                                <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/30 dark:to-orange-800/30 rounded-2xl p-6 text-center hover:shadow-lg transition">
                                    <div class="w-12 h-12 mx-auto bg-orange-500 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm0-10a1 1 0 01.001 2H10a1 1 0 010-2h.001zm4.238-2.773a1 1 0 00-1.414 1.414A4 4 0 1110 2a1 1 0 100 2 2 2 0 110 4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <p class="text-3xl font-black text-orange-600 dark:text-orange-400">{{ $user->userProgresses()->where('is_completed', false)->count() ?? 0 }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 font-semibold mt-2">Sedang Belajar</p>
                                </div>

                                <!-- Courses -->
                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 rounded-2xl p-6 text-center hover:shadow-lg transition">
                                    <div class="w-12 h-12 mx-auto bg-purple-500 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-3xl font-black text-purple-600 dark:text-purple-400">{{ $user->courses()->count() ?? 0 }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 font-semibold mt-2">Kursus Aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Badges & Achievements -->
                    @if($user->badges()->exists())
                        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                            <div class="bg-gradient-to-r from-pink-500 to-rose-500 px-8 py-6">
                                <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    Pencapaian & Lencana
                                </h3>
                            </div>
                            <div class="p-8">
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                                    @foreach($user->badges as $badge)
                                        <div class="group text-center">
                                            <div class="mb-3 relative">
                                                <div class="w-16 h-16 mx-auto bg-gradient-to-br from-yellow-300 to-yellow-500 rounded-full flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-110 transition transform">
                                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-white text-center">{{ $badge->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $badge->description ?? 'Prestasi' }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                            <div class="bg-gradient-to-r from-gray-400 to-gray-500 px-8 py-6">
                                <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    Pencapaian & Lencana
                                </h3>
                            </div>
                            <div class="p-8 text-center">
                                <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <p class="text-gray-600 dark:text-gray-400 font-semibold mb-2">Belum ada pencapaian</p>
                                <p class="text-sm text-gray-500 dark:text-gray-500">Mulai belajar untuk mendapatkan lencana dan pencapaian</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column - Sidebar -->
                <div class="space-y-6">
                    <!-- Learning Progress -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-cyan-500 px-6 py-6">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Tingkat Kemajuan
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            @php
                                $totalProgress = $user->userProgresses()->count();
                                $completedProgress = $user->userProgresses()->where('is_completed', true)->count();
                                $progressPercentage = $totalProgress > 0 ? ($completedProgress / $totalProgress) * 100 : 0;
                            @endphp
                            
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Progres Keseluruhan</span>
                                    <span class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ round($progressPercentage) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-full rounded-full transition-all duration-500" style="width: {{ $progressPercentage }}%"></div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3 pt-2">
                                <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-3 text-center">
                                    <p class="text-2xl font-black text-blue-600 dark:text-blue-400">{{ $completedProgress }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold">Selesai</p>
                                </div>
                                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 text-center">
                                    <p class="text-2xl font-black text-gray-600 dark:text-gray-400">{{ $totalProgress }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold">Total</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Status -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-6 py-6">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Status Akun
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Status</span>
                                <span class="inline-block px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 rounded-full text-xs font-bold">
                                    Aktif
                                </span>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Email Terverifikasi</span>
                                <div class="flex items-center gap-2 mt-2">
                                    @if($user->email_verified_at)
                                        <div class="flex-shrink-0 w-2 h-2 bg-green-500 rounded-full"></div>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Ya</span>
                                    @else
                                        <div class="flex-shrink-0 w-2 h-2 bg-yellow-500 rounded-full"></div>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Belum</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('dashboard') }}" class="bg-gradient-to-br from-indigo-500 to-purple-600 hover:shadow-lg text-white font-bold py-4 px-4 rounded-2xl text-center transition shadow-md">
                            <svg class="w-6 h-6 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            <span class="text-sm">Dashboard</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="bg-gradient-to-br from-pink-500 to-rose-600 hover:shadow-lg text-white font-bold py-4 px-4 rounded-2xl text-center transition shadow-md">
                            <svg class="w-6 h-6 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                            </svg>
                            <span class="text-sm">Edit Profil</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity (Optional) -->
            @if($user->userProgresses()->exists())
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 to-red-500 px-8 py-6">
                        <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.5 1.5H19a1 1 0 011 1v1a1 1 0 01-1 1h-.757l.808 10.027a2 2 0 01-1.992 2.147H5.941a2 2 0 01-1.992-2.147L4.757 4.5H4a1 1 0 01-1-1v-1a1 1 0 011-1h8.5m0 0V1a1 1 0 10-2 0v.5m0 0H8a1 1 0 100 2h4.5a1 1 0 100-2H10.5z"></path>
                            </svg>
                            Aktivitas Terbaru
                        </h3>
                    </div>
                    <div class="p-8">
                        <div class="space-y-4">
                            @foreach($user->userProgresses()->latest()->take(5) as $progress)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:shadow-md transition">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 100-2 4 4 0 00-4 4v10a4 4 0 004 4h12a4 4 0 004-4V5a4 4 0 00-4-4 1 1 0 100 2 2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5z" clip-rule="evenodd"></path>
                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $progress->lesson->title ?? 'Pelajaran' }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $progress->updated_at->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if($progress->is_completed)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">
                                                <svg class="w-4 h-4 mr-1 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"></path>
                                                </svg>
                                                Sedang Belajar
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Additional Information Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Email Verification & Security -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-red-500 to-pink-500 px-8 py-6">
                        <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            Keamanan & Verifikasi
                        </h3>
                    </div>
                    <div class="p-8 space-y-5">
                        <!-- Email Status -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">Email Terverifikasi</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Status verifikasi email</p>
                                </div>
                            </div>
                            @if($user->email_verified_at)
                                <span class="inline-flex items-center px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 rounded-full font-semibold text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Terverifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 rounded-full font-semibold text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Belum Verifikasi
                                </span>
                            @endif
                        </div>

                        <!-- 2FA Status -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zm-11-7a1 1 0 11-2 0 1 1 0 012 0zM3 8a2 2 0 11-4 0 2 2 0 014 0zm-1 9a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2zm4 0a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">Keamanan Dua Faktor</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Perlindungan akun tambahan</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-full font-semibold text-sm">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Belum Aktif
                            </span>
                        </div>

                        <!-- Password Status -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">Kata Sandi</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Terakhir diubah {{ $user->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-400 rounded-full font-semibold text-sm hover:shadow-md transition">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                </svg>
                                Ubah
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Account Tier & Membership -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-8 py-6">
                        <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Member & Tier
                        </h3>
                    </div>
                    <div class="p-8 space-y-6">
                        <!-- Tier Info -->
                        <div>
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-3">Status Member</p>
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    @if($user->is_premium)
                                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-300 to-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 bg-gradient-to-br from-gray-300 to-gray-500 rounded-full flex items-center justify-center shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <p class="text-xl font-bold text-gray-900 dark:text-white">
                                        @if($user->is_premium)
                                            Member Premium
                                        @else
                                            Member Reguler
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        @if($user->is_premium)
                                            Dapatkan akses eksklusif ke semua konten premium
                                        @else
                                            Upgrade untuk akses premium dan fitur eksklusif
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Tier Benefits -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-3">Keuntungan</p>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Akses ke semua kursus dasar</span>
                                </div>
                                @if($user->is_premium)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Akses ke kursus premium eksklusif</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Sertifikat resmi untuk setiap kursus</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Konsultasi dengan mentor dedicated</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Akses ke kursus premium eksklusif</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

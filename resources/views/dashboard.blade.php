<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-black text-3xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    ⚡ {{ __('Selamat Datang, ' . Auth::user()->name) }}!
                </h2>
                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Lanjutkan petualangan belajarmu hari ini</p>
            </div>
            <div class="flex items-center space-x-6">
                <div class="text-right">
                    <p class="text-xs text-gray-600 dark:text-gray-400 uppercase font-bold">Total XP</p>
                    <p class="text-2xl font-black text-yellow-500">{{ Auth::user()->experience ?? 0 }}</p>
                </div>
                <div class="w-1 h-10 bg-gradient-to-b from-blue-500 to-purple-500 rounded-full"></div>
                <div class="text-right">
                    <p class="text-xs text-gray-600 dark:text-gray-400 uppercase font-bold">Points</p>
                    <p class="text-2xl font-black text-green-500">{{ Auth::user()->points ?? 0 }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Daily Quest Section -->
            <div class="mb-8">
                <div class="bg-gradient-to-r from-amber-400 via-orange-400 to-red-400 rounded-2xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                    <div class="relative p-8 text-white">
                        <!-- Decorative elements -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-16 -mt-16"></div>
                        <div class="absolute bottom-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -ml-20 -mb-20"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-3xl font-black mb-1">🎯 Misi Hari Ini</h3>
                                    <p class="text-sm opacity-90">Selesaikan untuk mendapat reward bonus!</p>
                                </div>
                                <span class="bg-white/30 backdrop-blur-md px-4 py-2 rounded-full text-sm font-bold">50 XP + Bonus</span>
                            </div>
                            
                            <div class="grid grid-cols-3 gap-4 mt-6">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 border border-white/30">
                                    <div class="text-2xl mb-2">✓</div>
                                    <p class="text-xs font-semibold opacity-90">Selesaikan 1 Materi</p>
                                </div>
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 border border-white/30">
                                    <div class="text-2xl mb-2">📝</div>
                                    <p class="text-xs font-semibold opacity-90">Ikuti 1 Quiz</p>
                                </div>
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 border border-white/30">
                                    <div class="text-2xl mb-2">🔥</div>
                                    <p class="text-xs font-semibold opacity-90">Pertahankan Streak</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-gradient-to-br from-blue-500/80 to-blue-600 rounded-xl p-6 text-white shadow-lg backdrop-blur-sm border border-blue-400/30">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-80 font-bold">Level</p>
                            <p class="text-3xl font-black mt-2">{{ floor((Auth::user()->experience ?? 0) / 100) + 1 }}</p>
                        </div>
                        <div class="text-5xl opacity-30">📊</div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-green-500/80 to-emerald-600 rounded-xl p-6 text-white shadow-lg backdrop-blur-sm border border-green-400/30">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-80 font-bold">Kursus Selesai</p>
                            <p class="text-3xl font-black mt-2">{{ Auth::user()->courses_completed ?? 0 }}</p>
                        </div>
                        <div class="text-5xl opacity-30">✅</div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-purple-500/80 to-violet-600 rounded-xl p-6 text-white shadow-lg backdrop-blur-sm border border-purple-400/30">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-80 font-bold">Badges</p>
                            <p class="text-3xl font-black mt-2">{{ Auth::user()->badges_count ?? 0 }}</p>
                        </div>
                        <div class="text-5xl opacity-30">🏆</div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-pink-500/80 to-rose-600 rounded-xl p-6 text-white shadow-lg backdrop-blur-sm border border-pink-400/30">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-80 font-bold">Streak</p>
                            <p class="text-3xl font-black mt-2">{{ Auth::user()->streak_days ?? 0 }}🔥</p>
                        </div>
                        <div class="text-5xl opacity-30">⚡</div>
                    </div>
                </div>
            </div>

            <!-- Courses Section -->
            <div class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-6">
                    🚀 Petualanganku
                </h2>

                @if($courses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($courses as $course)
                            <a href="{{ route('courses.show', $course) }}" class="group relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity duration-300"></div>
                                
                                <div class="relative bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden transform group-hover:-translate-y-2 transition-all duration-300 border border-gray-200/50 dark:border-slate-700">
                                    <!-- Course Header with Thumbnail -->
                                    <div class="h-32 bg-gradient-to-br from-blue-400 to-purple-500 p-4 flex items-end relative overflow-hidden">
                                        <div class="absolute inset-0 opacity-20">
                                            <svg class="w-full h-full" viewBox="0 0 100 100">
                                                <circle cx="50" cy="50" r="30" fill="white" opacity="0.1"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-black text-white relative z-10 line-clamp-2">{{ $course->title }}</h3>
                                    </div>

                                    <!-- Course Content -->
                                    <div class="p-6">
                                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-2">
                                            {{ $course->description }}
                                        </p>

                                        <!-- Progress Bar -->
                                        <div class="mb-4">
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-xs font-bold text-gray-600 dark:text-gray-400">Progress</span>
                                                <span class="text-xs font-bold text-blue-600 dark:text-blue-400">{{ $course->progress ?? 0 }}%</span>
                                            </div>
                                            <div class="h-3 bg-gray-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-blue-500 to-purple-500 rounded-full transition-all duration-500" style="width: {{ $course->progress ?? 0 }}%"></div>
                                            </div>
                                        </div>

                                        <!-- Course Stats -->
                                        <div class="grid grid-cols-3 gap-2 mb-4 text-center">
                                            <div class="bg-blue-50 dark:bg-slate-700/50 rounded-lg py-2">
                                                <p class="text-xs font-bold text-gray-600 dark:text-gray-400">Materi</p>
                                                <p class="text-lg font-black text-blue-600 dark:text-blue-400">{{ $course->modules_count ?? 0 }}</p>
                                            </div>
                                            <div class="bg-green-50 dark:bg-slate-700/50 rounded-lg py-2">
                                                <p class="text-xs font-bold text-gray-600 dark:text-gray-400">Quiz</p>
                                                <p class="text-lg font-black text-green-600 dark:text-green-400">{{ $course->questions_count ?? 0 }}</p>
                                            </div>
                                            <div class="bg-yellow-50 dark:bg-slate-700/50 rounded-lg py-2">
                                                <p class="text-xs font-bold text-gray-600 dark:text-gray-400">XP</p>
                                                <p class="text-lg font-black text-yellow-600 dark:text-yellow-400">{{ $course->xp_reward ?? 0 }}</p>
                                            </div>
                                        </div>

                                        <!-- CTA Button -->
                                        <button class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform group-hover:scale-105">
                                            {{ $course->progress > 0 ? 'Lanjutkan ➜' : 'Mulai Belajar ➜' }}
                                        </button>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-slate-800 dark:to-slate-900 rounded-2xl border-2 border-dashed border-gray-300 dark:border-slate-600">
                        <p class="text-4xl mb-4">📚</p>
                        <p class="text-lg font-bold text-gray-700 dark:text-gray-300">Waaah, belum ada petualangan yang tersedia.</p>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">Cek lagi nanti atau hubungi instruktur kamu!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

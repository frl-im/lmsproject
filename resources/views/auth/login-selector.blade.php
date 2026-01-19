<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-b from-slate-900 via-purple-900 to-slate-900 dark:from-slate-950 dark:via-purple-950 dark:to-slate-950 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-6xl">
            <!-- Header Section -->
            <div class="text-center mb-16">
                <div class="inline-block mb-6">
                    <div class="text-6xl md:text-7xl font-bold bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent mb-2">
                        🚀 LMS Gamifikasi
                    </div>
                </div>
                <p class="text-xl md:text-2xl text-slate-300 mb-2 font-light">
                    Platform Pembelajaran Interaktif dengan Sistem Gamifikasi
                </p>
                <p class="text-slate-400 text-sm md:text-base">
                    Pilih peran Anda untuk melanjutkan
                </p>
            </div>

            <!-- Login Options Grid -->
            <div class="grid md:grid-cols-2 gap-8 md:gap-12 max-w-4xl mx-auto mb-12">
                
                <!-- Siswa Login Card -->
                <div class="group relative">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-3xl blur-2xl opacity-0 group-hover:opacity-75 transition duration-300"></div>
                    
                    <!-- Card Content -->
                    <a href="{{ route('login') }}" class="relative block bg-gradient-to-br from-slate-800 to-slate-900 dark:from-slate-900 dark:to-slate-950 rounded-2xl p-8 md:p-10 border border-slate-700 hover:border-blue-500 transition-all duration-300 h-full">
                        <div class="text-center">
                            <!-- Icon -->
                            <div class="mb-6 inline-block">
                                <div class="w-20 h-20 md:w-24 md:h-24 bg-gradient-to-br from-blue-400 to-cyan-400 rounded-2xl flex items-center justify-center text-4xl md:text-5xl shadow-lg group-hover:shadow-cyan-500/50 transition-all duration-300 transform group-hover:scale-110">
                                    👨‍🎓
                                </div>
                            </div>
                            
                            <!-- Title -->
                            <h2 class="text-2xl md:text-3xl font-bold text-white mb-3 group-hover:text-blue-300 transition duration-300">
                                Login Siswa
                            </h2>
                            
                            <!-- Description -->
                            <p class="text-slate-400 mb-4 text-sm md:text-base leading-relaxed">
                                Akses kursus pembelajaran, kuis interaktif, dan raih poin untuk naik di leaderboard
                            </p>
                            
                            <!-- Features -->
                            <ul class="text-left text-sm text-slate-300 space-y-2 mb-6">
                                <li class="flex items-center"><span class="text-blue-400 mr-2">✓</span> Pembelajaran Interaktif</li>
                                <li class="flex items-center"><span class="text-blue-400 mr-2">✓</span> Sistem Gamifikasi</li>
                                <li class="flex items-center"><span class="text-blue-400 mr-2">✓</span> Leaderboard & Badge</li>
                                <li class="flex items-center"><span class="text-blue-400 mr-2">✓</span> Track Progress Belajar</li>
                            </ul>
                            
                            <!-- Button -->
                            <button class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-bold py-3 px-6 rounded-lg transition-all transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300/50 shadow-lg">
                                Masuk sebagai Siswa →
                            </button>
                        </div>
                    </a>
                </div>

                <!-- Admin Login Card -->
                <div class="group relative">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-amber-500 to-orange-500 rounded-3xl blur-2xl opacity-0 group-hover:opacity-75 transition duration-300"></div>
                    
                    <!-- Card Content -->
                    <a href="{{ route('admin.login') }}" class="relative block bg-gradient-to-br from-slate-800 to-slate-900 dark:from-slate-900 dark:to-slate-950 rounded-2xl p-8 md:p-10 border border-slate-700 hover:border-amber-500 transition-all duration-300 h-full">
                        <div class="text-center">
                            <!-- Icon -->
                            <div class="mb-6 inline-block">
                                <div class="w-20 h-20 md:w-24 md:h-24 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center text-4xl md:text-5xl shadow-lg group-hover:shadow-amber-500/50 transition-all duration-300 transform group-hover:scale-110">
                                    🔐
                                </div>
                            </div>
                            
                            <!-- Title -->
                            <h2 class="text-2xl md:text-3xl font-bold text-white mb-3 group-hover:text-amber-300 transition duration-300">
                                Login Admin
                            </h2>
                            
                            <!-- Description -->
                            <p class="text-slate-400 mb-4 text-sm md:text-base leading-relaxed">
                                Kelola kursus, monitor siswa, dan kelola konten pembelajaran dengan dashboard lengkap
                            </p>
                            
                            <!-- Features -->
                            <ul class="text-left text-sm text-slate-300 space-y-2 mb-6">
                                <li class="flex items-center"><span class="text-amber-400 mr-2">✓</span> Kelola Kursus & Modul</li>
                                <li class="flex items-center"><span class="text-amber-400 mr-2">✓</span> Monitor Siswa</li>
                                <li class="flex items-center"><span class="text-amber-400 mr-2">✓</span> Statistik & Laporan</li>
                                <li class="flex items-center"><span class="text-amber-400 mr-2">✓</span> Kelola Konten</li>
                            </ul>
                            
                            <!-- Button -->
                            <button class="w-full bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-bold py-3 px-6 rounded-lg transition-all transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-amber-300/50 shadow-lg">
                                Masuk sebagai Admin →
                            </button>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Info Section -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-slate-800/50 dark:bg-slate-900/50 border border-slate-700 rounded-2xl p-6 md:p-8 backdrop-blur-sm">
                    <div class="grid md:grid-cols-3 gap-6">
                        <!-- Info Item 1 -->
                        <div class="text-center">
                            <div class="text-3xl mb-2">📚</div>
                            <h3 class="text-white font-semibold mb-1">Ribuan Kursus</h3>
                            <p class="text-slate-400 text-sm">Materi pembelajaran berkualitas tinggi</p>
                        </div>
                        <!-- Info Item 2 -->
                        <div class="text-center">
                            <div class="text-3xl mb-2">🏆</div>
                            <h3 class="text-white font-semibold mb-1">Sistem Gamifikasi</h3>
                            <p class="text-slate-400 text-sm">Raih badge dan kompetisi sehat</p>
                        </div>
                        <!-- Info Item 3 -->
                        <div class="text-center">
                            <div class="text-3xl mb-2">📊</div>
                            <h3 class="text-white font-semibold mb-1">Progress Tracking</h3>
                            <p class="text-slate-400 text-sm">Pantau perkembangan belajar Anda</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Belum punya akun? -->
            <div class="text-center mt-12">
                <p class="text-slate-400 text-sm md:text-base">
                    Belum memiliki akun? 
                    <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-bold transition duration-300">
                        Daftar di sini
                    </a>
                </p>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="/" class="text-slate-500 hover:text-slate-400 text-sm transition duration-300">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>

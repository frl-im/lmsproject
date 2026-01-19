<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-b from-white to-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-2xl">
            <!-- Header Section -->
            <div class="text-center mb-10">
                <div class="inline-block mb-4">
                    <div class="text-5xl md:text-6xl font-bold text-blue-600 mb-2">
                        🚀 LMS Gamifikasi
                    </div>
                </div>
                <p class="text-lg md:text-xl text-gray-700 mb-2 font-light">
                    Platform Pembelajaran Interaktif dengan Sistem Gamifikasi
                </p>
                <p class="text-gray-600 text-sm md:text-base">
                    Pilih peran Anda untuk melanjutkan
                </p>
            </div>

            <!-- Login Options Grid -->
            <div class="grid md:grid-cols-2 gap-6 md:gap-8 mb-10">
                
                <!-- Siswa Login Card -->
                <div class="group relative">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-200 to-blue-300 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    
                    <!-- Card Content -->
                    <a href="{{ route('login') }}" class="relative block bg-white rounded-xl p-5 md:p-6 border-2 border-gray-200 hover:border-blue-500 transition-all duration-300 h-full shadow-md">
                        <div class="text-center">
                            <!-- Icon -->
                            <div class="mb-4 inline-block">
                                <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center text-3xl md:text-4xl shadow-sm group-hover:shadow-md transition-all duration-300 transform group-hover:scale-110">
                                    👨‍🎓
                                </div>
                            </div>
                            
                            <!-- Title -->
                            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition duration-300">
                                Login Siswa
                            </h2>
                            
                            <!-- Description -->
                            <p class="text-gray-600 mb-3 text-xs md:text-sm leading-relaxed">
                                Akses kursus pembelajaran, kuis interaktif, dan raih poin untuk naik di leaderboard
                            </p>
                            
                            <!-- Features -->
                            <ul class="text-left text-xs text-gray-600 space-y-1 mb-4">
                                <li class="flex items-center"><span class="text-blue-500 mr-2 text-sm">✓</span> Pembelajaran Interaktif</li>
                                <li class="flex items-center"><span class="text-blue-500 mr-2 text-sm">✓</span> Sistem Gamifikasi</li>
                                <li class="flex items-center"><span class="text-blue-500 mr-2 text-sm">✓</span> Leaderboard & Badge</li>
                                <li class="flex items-center"><span class="text-blue-500 mr-2 text-sm">✓</span> Track Progress Belajar</li>
                            </ul>
                            
                            <!-- Button -->
                            <button class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-black font-bold py-2 px-4 rounded-lg transition-all transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-sm text-sm">
                                Masuk sebagai Siswa →
                            </button>
                        </div>
                    </a>
                </div>

                <!-- Admin Login Card -->
                <div class="group relative">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-orange-200 to-amber-200 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    
                    <!-- Card Content -->
                    <a href="{{ route('admin.login') }}" class="relative block bg-white rounded-xl p-5 md:p-6 border-2 border-gray-200 hover:border-amber-500 transition-all duration-300 h-full shadow-md">
                        <div class="text-center">
                            <!-- Icon -->
                            <div class="mb-4 inline-block">
                                <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-amber-100 to-orange-200 rounded-xl flex items-center justify-center text-3xl md:text-4xl shadow-sm group-hover:shadow-md transition-all duration-300 transform group-hover:scale-110">
                                    🔐
                                </div>
                            </div>
                            
                            <!-- Title -->
                            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-2 group-hover:text-amber-600 transition duration-300">
                                Login Admin
                            </h2>
                            
                            <!-- Description -->
                            <p class="text-gray-600 mb-3 text-xs md:text-sm leading-relaxed">
                                Kelola kursus, monitor siswa, dan kelola konten pembelajaran dengan dashboard lengkap
                            </p>
                            
                            <!-- Features -->
                            <ul class="text-left text-xs text-gray-600 space-y-1 mb-4">
                                <li class="flex items-center"><span class="text-amber-500 mr-2 text-sm">✓</span> Kelola Kursus & Modul</li>
                                <li class="flex items-center"><span class="text-amber-500 mr-2 text-sm">✓</span> Monitor Siswa</li>
                                <li class="flex items-center"><span class="text-amber-500 mr-2 text-sm">✓</span> Statistik & Laporan</li>
                                <li class="flex items-center"><span class="text-amber-500 mr-2 text-sm">✓</span> Kelola Konten</li>
                            </ul>
                            
                            <!-- Button -->
                            <button class="w-full bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-black font-bold py-2 px-4 rounded-lg transition-all transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-amber-300 shadow-sm text-sm">
                                Masuk sebagai Admin →
                            </button>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Info Section -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-md mb-10">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6">
                        <!-- Info Item 1 -->
                        <div class="text-center">
                            <div class="text-3xl mb-2">📚</div>
                            <h3 class="text-gray-800 font-semibold mb-1">Ribuan Kursus</h3>
                            <p class="text-gray-600 text-sm">Materi pembelajaran berkualitas tinggi</p>
                        </div>
                        <!-- Info Item 2 -->
                        <div class="text-center">
                            <div class="text-3xl mb-2">🏆</div>
                            <h3 class="text-gray-800 font-semibold mb-1">Sistem Gamifikasi</h3>
                            <p class="text-gray-600 text-sm">Raih badge dan kompetisi sehat</p>
                        </div>
                        <!-- Info Item 3 -->
                        <div class="text-center">
                            <div class="text-3xl mb-2">📊</div>
                            <h3 class="text-gray-800 font-semibold mb-1">Progress Tracking</h3>
                            <p class="text-gray-600 text-sm">Pantau perkembangan belajar Anda</p>
                        </div>
                </div>
            </div>

            <!-- Belum punya akun? -->
            <div class="text-center mb-6">
                <p class="text-gray-700 text-sm md:text-base">
                    Belum memiliki akun? 
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-bold transition duration-300">
                        Daftar di sini
                    </a>
                </p>
            </div>

            <!-- Back to Home -->
            <div class="text-center">
                <a href="/" class="text-gray-600 hover:text-gray-800 text-sm transition duration-300">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>

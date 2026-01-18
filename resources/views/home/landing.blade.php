@extends('layouts.app')

@section('content')
<!-- Navigation Bar -->
<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                    📚 LMS Pro
                </a>
            </div>

            <!-- Center Menu -->
            <div class="hidden md:flex space-x-8">
                <a href="#features" class="text-gray-700 hover:text-blue-600 transition">Fitur</a>
                <a href="#courses" class="text-gray-700 hover:text-blue-600 transition">Kursus</a>
                <a href="#pricing" class="text-gray-700 hover:text-blue-600 transition">Harga</a>
                <a href="#contact" class="text-gray-700 hover:text-blue-600 transition">Hubungi</a>
            </div>

            <!-- Right Side: Language Dropdown & Login -->
            <div class="flex items-center space-x-4">
                <!-- Language Dropdown -->
                <div class="relative group">
                    <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600">
                        <span class="text-xl">🌐</span>
                        <span class="hidden sm:inline">ID</span>
                    </button>
                    <div class="absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition">
                        <a href="#" class="block px-4 py-2 hover:bg-blue-50">🇮🇩 Indonesia</a>
                        <a href="#" class="block px-4 py-2 hover:bg-blue-50">🇬🇧 English</a>
                    </div>
                </div>

                @if(Auth::check())
                    <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Login
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl md:text-6xl font-bold mb-6">
            Belajar Jadi Lebih Seru 🚀
        </h1>
        <p class="text-xl md:text-2xl mb-8 text-blue-100">
            Platform pembelajaran interaktif dengan gamifikasi penuh, kuis menarik, dan tracking progress real-time
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            @if(!Auth::check())
                <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-blue-600 font-bold rounded-lg hover:bg-blue-50 transition">
                    Daftar Gratis
                </a>
            @endif
            <a href="#courses" class="px-8 py-3 border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-blue-600 transition">
                Lihat Kursus
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-16">Fitur Unggulan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition">
                <div class="text-4xl mb-4">🎮</div>
                <h3 class="text-2xl font-bold mb-4">Gamifikasi Penuh</h3>
                <p class="text-gray-600">Dapatkan XP, poin, badge, dan naik leaderboard saat belajar</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition">
                <div class="text-4xl mb-4">📊</div>
                <h3 class="text-2xl font-bold mb-4">Progress Tracking</h3>
                <p class="text-gray-600">Pantau perkembangan belajar dengan dashboard interaktif</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition">
                <div class="text-4xl mb-4">🎯</div>
                <h3 class="text-2xl font-bold mb-4">Kuis Interaktif</h3>
                <p class="text-gray-600">Kuis dengan sistem penilaian otomatis dan feedback real-time</p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition">
                <div class="text-4xl mb-4">💬</div>
                <h3 class="text-2xl font-bold mb-4">Konsultasi</h3>
                <p class="text-gray-600">Chat dengan mentor dan dapatkan bantuan belajar</p>
            </div>

            <!-- Feature 5 -->
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition">
                <div class="text-4xl mb-4">📱</div>
                <h3 class="text-2xl font-bold mb-4">Responsive Design</h3>
                <p class="text-gray-600">Belajar di desktop, tablet, atau smartphone kapan saja</p>
            </div>

            <!-- Feature 6 -->
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition">
                <div class="text-4xl mb-4">🎓</div>
                <h3 class="text-2xl font-bold mb-4">Sertifikat</h3>
                <p class="text-gray-600">Dapatkan sertifikat digital setelah menyelesaikan kursus</p>
            </div>
        </div>
    </div>
</section>

<!-- Courses Preview Section -->
<section id="courses" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-16">Kursus Tersedia</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $course)
                <div class="bg-gray-50 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition cursor-pointer group" 
                     onclick="viewCourse({{ $course->id }})">
                    <div class="h-40 bg-gradient-to-r from-blue-400 to-blue-600 group-hover:from-blue-500 group-hover:to-blue-700 transition"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">{{ $course->title }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-3">{{ $course->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-blue-600 font-semibold">
                                {{ $course->modules_count ?? 0 }} Module
                            </span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm">
                                @if(!Auth::check())
                                    Preview
                                @else
                                    Mulai
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada kursus. Silakan kembali nanti.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Teaser/Preview Modal -->
<div id="teaserModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-96 overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold">Preview Kursus</h3>
                <button onclick="closeTeaserModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <div id="teaserContent" class="text-gray-700">
                <!-- Content akan diisi via JS -->
            </div>
            @if(!Auth::check())
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <p class="text-gray-700 mb-4">💡 Untuk akses penuh ke semua materi, silakan login atau daftar sekarang.</p>
                    <div class="flex gap-2">
                        <a href="{{ route('login') }}" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-center transition">
                            Daftar
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section id="pricing" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-16">Pilih Paket Anda</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <!-- Free Plan -->
            <div class="bg-white rounded-lg shadow-lg p-8 border-2 border-gray-200">
                <h3 class="text-2xl font-bold mb-4">Gratis</h3>
                <p class="text-gray-600 mb-6">Sempurna untuk mencoba</p>
                <div class="text-4xl font-bold mb-6">Rp 0<span class="text-lg">/bulan</span></div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center"><span class="text-green-500 mr-3">✓</span> 3 Kursus Gratis</li>
                    <li class="flex items-center"><span class="text-green-500 mr-3">✓</span> Gamifikasi Dasar</li>
                    <li class="flex items-center"><span class="text-gray-400 mr-3">✗</span> Akses Unlimited</li>
                    <li class="flex items-center"><span class="text-gray-400 mr-3">✗</span> Sertifikat</li>
                </ul>
                <button class="w-full px-6 py-2 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition">
                    Mulai Gratis
                </button>
            </div>

            <!-- Premium Plan -->
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg shadow-lg p-8 text-white border-2 border-blue-600 relative">
                <div class="absolute top-0 right-0 bg-red-500 text-white px-4 py-1 rounded-bl-lg font-bold">
                    POPULER
                </div>
                <h3 class="text-2xl font-bold mb-4">Premium</h3>
                <p class="text-blue-100 mb-6">Akses penuh ke semua fitur</p>
                <div class="text-4xl font-bold mb-6">Rp 99.000<span class="text-lg">/bulan</span></div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center"><span class="text-green-300 mr-3">✓</span> Semua Kursus Unlimited</li>
                    <li class="flex items-center"><span class="text-green-300 mr-3">✓</span> Gamifikasi Penuh</li>
                    <li class="flex items-center"><span class="text-green-300 mr-3">✓</span> Sertifikat Digital</li>
                    <li class="flex items-center"><span class="text-green-300 mr-3">✓</span> Support Priority</li>
                </ul>
                @if(Auth::check())
                    <form action="{{ route('finance.purchase') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-6 py-2 bg-white text-blue-600 font-bold rounded-lg hover:bg-blue-50 transition">
                            Upgrade Sekarang
                        </button>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="block w-full px-6 py-2 bg-white text-blue-600 font-bold rounded-lg hover:bg-blue-50 text-center transition">
                        Daftar & Upgrade
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-blue-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap untuk Memulai Perjalanan Belajarmu?</h2>
        <p class="text-xl mb-8">Ribuan siswa sudah belajar dengan platform kami. Bergabunglah sekarang juga!</p>
        <div class="flex flex-wrap justify-center gap-4">
            @if(!Auth::check())
                <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-blue-600 font-bold rounded-lg hover:bg-blue-50 transition">
                    Daftar Gratis
                </a>
            @endif
            <a href="#courses" class="px-8 py-3 border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-blue-600 transition">
                Jelajahi Kursus
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-400 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div>
                <h4 class="text-white font-bold mb-4">LMS Pro</h4>
                <p>Platform pembelajaran terpadu dengan gamifikasi penuh</p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Produk</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-white transition">Kursus</a></li>
                    <li><a href="#" class="hover:text-white transition">Harga</a></li>
                    <li><a href="#" class="hover:text-white transition">Features</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Perusahaan</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-white transition">Tentang</a></li>
                    <li><a href="#" class="hover:text-white transition">Blog</a></li>
                    <li><a href="#" class="hover:text-white transition">Karir</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Legal</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-white transition">Privacy</a></li>
                    <li><a href="#" class="hover:text-white transition">Terms</a></li>
                    <li><a href="#" class="hover:text-white transition">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-8 text-center">
            <p>&copy; 2025 LMS Pro. All rights reserved. | Made with ❤️ for Education</p>
        </div>
    </div>
</footer>

<script>
function viewCourse(courseId) {
    @if(!Auth::check())
    document.getElementById('teaserModal').classList.remove('hidden');
    document.getElementById('teaserContent').innerHTML = `
        <div class="text-center py-8">
            <div class="text-6xl mb-4">📚</div>
            <h4 class="text-xl font-bold mb-2">Preview Kursus</h4>
            <p class="text-gray-600">Ini adalah preview dari kursus. Untuk melihat materi lengkap, silakan login terlebih dahulu.</p>
        </div>
    `;
    @else
    window.location.href = '/courses/' + courseId;
    @endif
}

function closeTeaserModal() {
    document.getElementById('teaserModal').classList.add('hidden');
}

document.addEventListener('click', function(event) {
    const modal = document.getElementById('teaserModal');
    if (event.target === modal) {
        closeTeaserModal();
    }
});
</script>
@endsection

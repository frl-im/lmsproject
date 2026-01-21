@extends('layouts.app')

@section('content')
<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                    📚 LMS Pro
                </a>
            </div>

            <div class="hidden md:flex space-x-8">
                <a href="#features" class="text-gray-700 hover:text-blue-600 transition">Fitur</a>
                <a href="#courses" class="text-gray-700 hover:text-blue-600 transition">Kursus</a>
                <a href="#pricing" class="text-gray-700 hover:text-blue-600 transition">Harga</a>
                <a href="https://wa.me/6281234567890" target="_blank" class="text-gray-700 hover:text-blue-600 transition">Hubungi</a>
            </div>

            <div class="flex items-center space-x-4">
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

<section id="features" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-16">Fitur Unggulan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition">
                <div class="text-4xl mb-4">🎮</div>
                <h3 class="text-2xl font-bold mb-4">Gamifikasi Penuh</h3>
                <p class="text-gray-600">Dapatkan XP, poin, badge, dan naik leaderboard saat belajar</p>
            </div>

            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition">
                <div class="text-4xl mb-4">📊</div>
                <h3 class="text-2xl font-bold mb-4">Progress Tracking</h3>
                <p class="text-gray-600">Pantau perkembangan belajar dengan dashboard interaktif</p>
            </div>

            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition">
                <div class="text-4xl mb-4">🎯</div>
                <h3 class="text-2xl font-bold mb-4">Kuis Interaktif</h3>
                <p class="text-gray-600">Kuis dengan sistem penilaian otomatis dan feedback real-time</p>
            </div>

            <a href="https://wa.me/6281234567890" target="_blank" class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition block cursor-pointer border-2 border-transparent hover:border-green-500 group">
                <div class="text-4xl mb-4">💬</div>
                <h3 class="text-2xl font-bold mb-4 group-hover:text-green-600">Konsultasi</h3>
                <p class="text-gray-600">Chat dengan mentor via WhatsApp dan dapatkan bantuan belajar</p>
            </a>

            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition">
                <div class="text-4xl mb-4">📱</div>
                <h3 class="text-2xl font-bold mb-4">Responsive Design</h3>
                <p class="text-gray-600">Belajar di desktop, tablet, atau smartphone kapan saja</p>
            </div>

            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition">
                <div class="text-4xl mb-4">🎓</div>
                <h3 class="text-2xl font-bold mb-4">Sertifikat</h3>
                <p class="text-gray-600">Dapatkan sertifikat digital setelah menyelesaikan kursus</p>
            </div>
        </div>
    </div>
</section>

<section id="courses" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-16">Kursus Tersedia</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $course)
                <div class="bg-gray-50 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition cursor-pointer group" 
                     onclick="viewCourse(this)"
                     data-id="{{ $course->id }}"
                     data-title="{{ $course->title }}"
                     data-description="{{ $course->description }}"
                     data-modules="{{ $course->modules_count ?? 0 }}">
                    
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

<div id="teaserModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-96 overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold">Preview Kursus</h3>
                <button onclick="closeTeaserModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <div id="teaserContent" class="text-gray-700">
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
</div>

<section id="pricing" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-16">Pilih Paket Anda</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
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
                @if(Auth::check() && Auth::user()->is_premium)
                    <button class="block w-full px-6 py-2 bg-white text-blue-600 font-bold rounded-lg opacity-75 cursor-default" disabled>
                        Sudah Premium ✓
                    </button>
                @else
                    <a href="{{ route('payment.upgrade') }}"
                        class="block w-full px-6 py-2 bg-white text-blue-600 font-bold rounded-lg hover:bg-blue-50 text-center transition">
                            Upgrade Sekarang
                    </a>
                @endif


            </div>
        </div>
    </div>
</section>

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

<a href="https://wa.me/6281234567890?text=Halo%20Admin%20LMS%2C%20saya%20ingin%20bertanya..." 
   target="_blank"
   class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-2xl transition transform hover:scale-110 flex items-center justify-center group">
    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.008-.57-.008-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
    </svg>
    <span class="absolute right-full mr-3 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
        Hubungi Mentor
    </span>
</a>

<script>
function viewCourse(element) {
    // 1. Ambil data dari elemen yang diklik
    const courseId = element.getAttribute('data-id');
    const title = element.getAttribute('data-title');
    const description = element.getAttribute('data-description');
    const modules = element.getAttribute('data-modules');

    @if(!Auth::check())
        // 2. Tampilkan Modal untuk Tamu (Belum Login)
        const modal = document.getElementById('teaserModal');
        const content = document.getElementById('teaserContent');
        
        modal.classList.remove('hidden');
        
        // 3. Masukkan Konten HTML yang Rapi
        content.innerHTML = `
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl shadow-sm">
                    🔒
                </div>
                
                <h4 class="text-2xl font-bold text-gray-900 mb-2 font-heading">${title}</h4>
                
                <span class="inline-block px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-xs font-bold mb-4 uppercase tracking-wide">
                    ${modules} Modul
                </span>
                
                <div class="text-left bg-gray-50 p-5 rounded-xl border border-gray-200 mb-6">
                    <p class="text-gray-600 leading-relaxed text-sm">
                        ${description}
                    </p>
                </div>

                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 text-left rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            ⚠️
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <span class="font-bold">Mode Preview:</span> 
                                Silakan login atau daftar untuk mengakses materi lengkap dan kuis interaktif.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        `;
    @else
        // 4. Jika User Sudah Login, Langsung Buka Halaman Kursus
        window.location.href = '/courses/' + courseId;
    @endif
}

function closeTeaserModal() {
    document.getElementById('teaserModal').classList.add('hidden');
}

// Tutup modal jika klik di area gelap (luar modal)
document.addEventListener('click', function(event) {
    const modal = document.getElementById('teaserModal');
    if (event.target === modal) {
        closeTeaserModal();
    }
});
</script>
@endsection
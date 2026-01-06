<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard Siswa') }}
            </h2>
            <div class="flex items-center space-x-4">
                <span class="text-lg font-bold text-yellow-500">{{ Auth::user()->experience ?? 0 }} XP</span>
                <span class="text-lg font-bold text-green-500">{{ Auth::user()->points ?? 0 }} Points</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Misi Hari Ini Banner -->
            <div class="bg-blue-500 dark:bg-blue-700 text-white shadow-lg rounded-lg p-6 mb-8">
                <h3 class="text-2xl font-bold mb-2">🚀 Misi Hari Ini!</h3>
                <p>Selesaikan 1 materi dan 1 kuis untuk mendapatkan bonus 50 XP. Ayo, semangat!</p>
            </div>

            <!-- Pilih Petualanganmu Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-6">Pilih Petualanganmu!</h3>
                    @if($courses->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($courses as $course)
                                <a href="{{ route('courses.show', $course) }}" class="block group">
                                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                                        <div class="p-6">
                                            <h4 class="text-xl font-bold text-gray-800 dark:text-white mb-2">{{ $course->title }}</h4>
                                            <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $course->description }}</p>
                                            <div class="flex justify-end">
                                                <span class="bg-blue-500 text-white text-sm font-semibold px-3 py-1 rounded-full">Mulai Belajar</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p>Waaah, belum ada petualangan yang tersedia. Coba cek lagi nanti ya!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

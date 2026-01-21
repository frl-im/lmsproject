@extends('layouts.app')

@section('content')

<div class="py-12 px-4">

    {{-- HEADER DASHBOARD --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="font-black text-3xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                ⚡ {{ __('Selamat Datang, ' . Auth::user()->name) }}!
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                Lanjutkan petualangan belajarmu hari ini
            </p>
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

    <div class="max-w-7xl mx-auto">

        {{-- DAILY QUEST --}}
        <div class="mb-8">
            <div class="bg-gradient-to-r from-amber-400 via-orange-400 to-red-400 rounded-2xl shadow-lg overflow-hidden">
                <div class="relative p-8 text-white">
                    <h3 class="text-3xl font-black mb-2">🎯 Misi Hari Ini</h3>
                    <p class="text-sm opacity-90 mb-6">Selesaikan untuk mendapat reward bonus!</p>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-white/20 rounded-xl p-4 text-center">
                            ✓
                            <p class="text-xs font-semibold">Selesaikan 1 Materi</p>
                        </div>
                        <div class="bg-white/20 rounded-xl p-4 text-center">
                            📝
                            <p class="text-xs font-semibold">Ikuti 1 Quiz</p>
                        </div>
                        <div class="bg-white/20 rounded-xl p-4 text-center">
                            🔥
                            <p class="text-xs font-semibold">Pertahankan Streak</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-blue-600 rounded-xl p-6 text-white">
                <p class="text-sm font-bold">Level</p>
                <p class="text-3xl font-black">
                    {{ floor((Auth::user()->experience ?? 0) / 100) + 1 }}
                </p>
            </div>

            <div class="bg-green-600 rounded-xl p-6 text-white">
                <p class="text-sm font-bold">Kursus Selesai</p>
                <p class="text-3xl font-black">{{ Auth::user()->courses_completed ?? 0 }}</p>
            </div>

            <div class="bg-purple-600 rounded-xl p-6 text-white">
                <p class="text-sm font-bold">Badges</p>
                <p class="text-3xl font-black">{{ Auth::user()->badges_count ?? 0 }}</p>
            </div>

            <div class="bg-pink-600 rounded-xl p-6 text-white">
                <p class="text-sm font-bold">Streak</p>
                <p class="text-3xl font-black">{{ Auth::user()->streak_days ?? 0 }}🔥</p>
            </div>
        </div>

        {{-- COURSES --}}
        <h2 class="text-2xl font-black mb-6">🚀 Petualanganku</h2>

        @if($courses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($courses as $course)
                    <a href="{{ route('courses.show', $course) }}" class="block bg-white dark:bg-slate-800 rounded-xl shadow p-6">
                        <h3 class="font-black text-lg mb-2">{{ $course->title }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            {{ $course->description }}
                        </p>

                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden mb-3">
                            <div class="h-full bg-blue-500" style="width: {{ $course->progress ?? 0 }}%"></div>
                        </div>

                        <p class="text-xs font-bold">
                            Progress: {{ $course->progress ?? 0 }}%
                        </p>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 text-gray-500">
                📚 Belum ada kursus tersedia
            </div>
        @endif

    </div>
</div>

@endsection

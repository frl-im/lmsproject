<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LMS Gamification</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-gradient-to-b from-blue-600 to-purple-700 text-white hidden md:flex flex-col">
        <div class="px-6 py-6 text-2xl font-black">
            🎮 LMS Quest
        </div>

        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl hover:bg-white/20 font-bold">
                🏠 Dashboard
            </a>
            <a href="{{ route('leaderboard.index') }}" class="block px-4 py-3 rounded-xl hover:bg-white/20 font-bold">
                🏆 Ranking
            </a>
            <a href="{{ route('courses.show', 1) }}" class="block px-4 py-3 rounded-xl hover:bg-white/20 font-bold">
                📚 Kursus
            </a>
            <a href="#" class="block px-4 py-3 rounded-xl hover:bg-white/20 font-bold">
                🎯 Quest
            </a>
        </nav>

        <div class="p-4 text-sm opacity-80">
            Level {{ floor((Auth::user()->experience ?? 0) / 100) + 1 }}
        </div>
    </aside>

    {{-- MAIN AREA --}}
    <div class="flex-1 flex flex-col">

        {{-- TOP BAR --}}
        <header class="bg-white dark:bg-slate-800 shadow px-6 py-4 flex justify-between items-center">
            <div>
                {{ $header ?? '' }}
            </div>

            <div class="flex items-center gap-6">
                <div class="text-right">
                    <p class="text-xs text-gray-500">XP</p>
                    <p class="font-black text-yellow-500">{{ Auth::user()->experience ?? 0 }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500">Points</p>
                    <p class="font-black text-green-500">{{ Auth::user()->points ?? 0 }}</p>
                </div>

                <div class="font-bold">
                    {{ Auth::user()->name }}
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>

    </div>
</div>

</body>
</html>

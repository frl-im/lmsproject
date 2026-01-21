@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                📊 Pantau Progress User
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Lihat kemajuan belajar setiap pengguna</p>
        </div>

        <!-- Filter & Search -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <input type="text" name="search" placeholder="Cari nama atau email..." 
                        value="{{ request('search') }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Sort -->
                <select name="sort" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="experience" {{ request('sort') === 'experience' ? 'selected' : '' }}>XP (Tertinggi)</option>
                    <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                    <option value="points" {{ request('sort') === 'points' ? 'selected' : '' }}>Poin (Tertinggi)</option>
                </select>

                <!-- Buttons -->
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    🔍 Cari
                </button>
                <a href="{{ route('admin.users.progress.index') }}" class="px-6 py-2 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white rounded-lg hover:bg-gray-400">
                    ↺ Reset
                </a>
            </form>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <a href="{{ route('admin.rankings') }}" class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg p-6 text-white hover:shadow-lg transition">
                <div class="text-2xl font-bold">🏆</div>
                <h3 class="font-bold mt-2">Lihat Ranking</h3>
                <p class="text-sm opacity-90">Global, Monthly, Per Course</p>
            </a>

            <a href="{{ route('admin.dashboard') }}" class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-lg p-6 text-white hover:shadow-lg transition">
                <div class="text-2xl font-bold">📈</div>
                <h3 class="font-bold mt-2">Dashboard Admin</h3>
                <p class="text-sm opacity-90">Statistik keseluruhan</p>
            </a>

            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg p-6 text-white">
                <div class="text-2xl font-bold">👥</div>
                <h3 class="font-bold mt-2">Total User</h3>
                <p class="text-sm opacity-90">{{ $users->total() }} pengguna</p>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-900 dark:text-white">#</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-900 dark:text-white">Nama</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-900 dark:text-white">Email</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-900 dark:text-white">XP</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-900 dark:text-white">Progress</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-900 dark:text-white">Quiz</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-900 dark:text-white">Sertifikat</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-900 dark:text-white">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 text-gray-900 dark:text-white">
                                {{ $users->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 px-3 py-1 rounded-full text-sm font-bold">
                                    ⭐ {{ $user->progress['xp'] ?? 0 }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $user->progress['progress_percentage'] ?? 0 }}%"></div>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">
                                        {{ $user->progress['progress_percentage'] ?? 0 }}%
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $user->progress['completed_lessons'] ?? 0 }}/{{ $user->progress['total_lessons'] ?? 0 }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block text-sm">
                                    <span class="font-bold text-green-600">{{ $user->progress['quizzes_passed'] ?? 0 }}</span>/
                                    <span class="text-gray-600 dark:text-gray-400">{{ $user->progress['quiz_attempts'] ?? 0 }}</span>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-3 py-1 rounded-full text-sm font-bold">
                                    🎖️ {{ $user->progress['certificates'] ?? 0 }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.users.progress.show', $user) }}" 
                                    class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-bold transition">
                                    👁️ Lihat
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data pengguna
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Dark mode improvements */
    @media (prefers-color-scheme: dark) {
        input, select {
            background-color: rgb(55 65 81);
            color: white;
        }
    }
</style>
@endsection

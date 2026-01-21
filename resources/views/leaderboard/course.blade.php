@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl shadow-lg p-8 text-white">
                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('courses.show', $course) }}" class="text-purple-100 hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <div>
                        <p class="text-sm text-purple-100 mb-1">Ranking Kursus</p>
                        <h1 class="text-4xl font-bold">🎯 {{ $course->name }}</h1>
                    </div>
                    <div class="w-6"></div>
                </div>
                <p class="text-purple-100 text-lg">Ranking berdasarkan nilai kuis di kursus ini</p>
            </div>
        </div>

        <!-- Current User Rank -->
        @if($currentUser)
            <div class="mb-8 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/30 dark:to-pink-900/30 border-2 border-purple-300 dark:border-purple-700 rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Posisi Anda di Kursus Ini</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                            @if($currentUserRank)
                                #{{ $currentUserRank }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">Total Score</p>
                        <p class="text-4xl font-bold text-purple-600 dark:text-purple-400">
                            {{ $currentUserScore ?? 0 }}
                        </p>
                    </div>
                    <div class="text-5xl">
                        @if($currentUserRank && $currentUserRank <= 3)
                            @if($currentUserRank == 1) 🥇 @elseif($currentUserRank == 2) 🥈 @else 🥉 @endif
                        @else
                            ⭐
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Course Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Total Peserta</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $users->total() }}</p>
                    </div>
                    <div class="text-4xl">👥</div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Rata-rata Score</p>
                        <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-1">
                            {{ $averageScore ?? '-' }}
                        </p>
                    </div>
                    <div class="text-4xl">📊</div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Highest Score</p>
                        <p class="text-3xl font-bold text-pink-600 dark:text-pink-400 mt-1">
                            {{ $highestScore ?? '-' }}
                        </p>
                    </div>
                    <div class="text-4xl">🎯</div>
                </div>
            </div>
        </div>

        <!-- Leaderboard Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-300">Rank</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-300">Player</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 dark:text-gray-300">Quizzes</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 dark:text-gray-300">Avg Score</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-700 dark:text-gray-300">Total Score</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($users as $index => $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors {{ $currentUser && $user->id === $currentUser->id ? 'bg-purple-50 dark:bg-purple-900/30' : '' }}">
                                <td class="px-6 py-4 text-center">
                                    <div class="text-2xl font-bold">
                                        @if(($users->currentPage() - 1) * $users->perPage() + $index + 1 == 1)
                                            🥇
                                        @elseif(($users->currentPage() - 1) * $users->perPage() + $index + 1 == 2)
                                            🥈
                                        @elseif(($users->currentPage() - 1) * $users->perPage() + $index + 1 == 3)
                                            🥉
                                        @else
                                            <span class="text-gray-600 dark:text-gray-400 font-semibold">#{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-bold text-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200">
                                        {{ $user->quiz_count ?? 0 }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $user->quiz_count && $user->quiz_count > 0 ? round($user->total_score / $user->quiz_count, 1) : '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                                        {{ $user->total_score ?? 0 }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <svg class="h-12 w-12 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    Belum ada peserta dalam kursus ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('courses.show', $course) }}" class="inline-flex items-center px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Kursus
            </a>
        </div>
    </div>
</div>
@endsection

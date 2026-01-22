@extends('layouts.app')

@section('content')

{{-- DASHBOARD HERO HEADER --}}
<div class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-700 dark:to-blue-900 text-white py-12 px-4 mb-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-black mb-2">⚡ Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="text-blue-100 text-lg">Lanjutkan petualangan belajarmu hari ini</p>
    </div>
</div>

<div class="py-8 px-4">
    <div class="max-w-7xl mx-auto">
        
        {{-- USER STATS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="text-center">
                <p class="text-xs text-gray-600 dark:text-gray-400 uppercase font-bold mb-1">Total XP</p>
                <p class="text-3xl font-black text-yellow-500" id="header-xp" data-user-xp="{{ Auth::user()->experience ?? 0 }}">{{ Auth::user()->experience ?? 0 }}</p>
            </div>

            <div class="text-center">
                <p class="text-xs text-gray-600 dark:text-gray-400 uppercase font-bold mb-1">Level</p>
                <p class="text-3xl font-black text-blue-600 dark:text-blue-400">{{ floor((Auth::user()->experience ?? 0) / 100) + 1 }}</p>
            </div>

            <div class="text-center">
                <p class="text-xs text-gray-600 dark:text-gray-400 uppercase font-bold mb-1">Points</p>
                <p class="text-3xl font-black text-green-500" id="header-points" data-user-points="{{ Auth::user()->points ?? 0 }}">{{ Auth::user()->points ?? 0 }}</p>
            </div>

            <div class="text-center">
                <p class="text-xs text-gray-600 dark:text-gray-400 uppercase font-bold mb-1">Badges</p>
                <p class="text-3xl font-black text-purple-500">{{ Auth::user()->badges_count ?? 0 }}</p>
            </div>
        </div>

        {{-- DAILY QUEST --}}
        <div class="mb-8">
            <h2 class="text-2xl font-black mb-4 text-gray-900 dark:text-white">🎯 Misi Hari Ini</h2>
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg overflow-hidden">
                <div class="relative p-8 text-white">
                    <p class="text-sm opacity-90 mb-6">Selesaikan untuk mendapat reward bonus!</p>

                    <div class="grid grid-cols-3 gap-4" id="missions-container">
                        @forelse($dailyMissions as $mission)
                            <div class="mission-card bg-white/20 hover:bg-white/30 rounded-xl p-4 text-center cursor-pointer transition-all transform hover:scale-105 {{ $mission->is_completed ? 'opacity-60 completed' : '' }}" 
                                 data-mission-id="{{ $mission->id }}"
                                 data-mission-type="{{ $mission->mission_type }}"
                                 data-is-completed="{{ $mission->is_completed ? 'true' : 'false' }}">
                                <div class="text-2xl mb-2">
                                    @if($mission->mission_type === 'lesson_complete')
                                        ✓
                                    @elseif($mission->mission_type === 'quiz_complete')
                                        📝
                                    @else
                                        🔥
                                    @endif
                                </div>
                                <p class="text-xs font-semibold mb-2">
                                    @if($mission->mission_type === 'lesson_complete')
                                        Selesaikan 1 Materi
                                    @elseif($mission->mission_type === 'quiz_complete')
                                        Ikuti 1 Quiz
                                    @else
                                        Pertahankan Streak
                                    @endif
                                </p>
                                <div class="flex justify-between items-center text-xs mb-2">
                                    <span class="progress-text">{{ $mission->progress }}/{{ $mission->target }}</span>
                                    @if($mission->is_completed)
                                        <span class="bg-green-400 px-2 py-1 rounded text-xs font-bold">✓ DONE</span>
                                    @endif
                                </div>
                                <div class="mt-2 bg-white/20 rounded-full h-1.5">
                                    <div class="progress-bar bg-white rounded-full h-full transition-all" style="width: {{ $mission->getProgressPercentage() }}%"></div>
                                </div>
                                <div class="reward-info text-xs mt-2 opacity-90">
                                    <span>+{{ $mission->reward_xp }} XP</span> • <span>+{{ $mission->reward_points }} Pts</span>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center text-white opacity-75">
                                Tidak ada misi untuk hari ini
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- STATS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden border-l-4 border-blue-600 p-6">
                <p class="text-sm font-bold text-gray-600 dark:text-gray-400">Kursus Selesai</p>
                <p class="text-3xl font-black text-gray-900 dark:text-white mt-2">{{ Auth::user()->courses_completed ?? 0 }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden border-l-4 border-green-600 p-6">
                <p class="text-sm font-bold text-gray-600 dark:text-gray-400">Materi Selesai</p>
                <p class="text-3xl font-black text-gray-900 dark:text-white mt-2">0</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden border-l-4 border-purple-600 p-6">
                <p class="text-sm font-bold text-gray-600 dark:text-gray-400">Badges Terkumpul</p>
                <p class="text-3xl font-black text-gray-900 dark:text-white mt-2">{{ Auth::user()->badges_count ?? 0 }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden border-l-4 border-pink-600 p-6">
                <p class="text-sm font-bold text-gray-600 dark:text-gray-400">Streak</p>
                <p class="text-3xl font-black text-gray-900 dark:text-white mt-2">{{ Auth::user()->streak_days ?? 0 }}🔥</p>
            </div>
        </div>

        {{-- LEADERBOARD SHORTCUT --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <a href="{{ route('leaderboard.index') }}" class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-lg shadow-lg overflow-hidden p-6 text-white hover:shadow-xl transition-all transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold opacity-90">📊 Global Leaderboard</p>
                        <p class="text-2xl font-black mt-2">Lihat Ranking Global</p>
                    </div>
                    <svg class="w-12 h-12 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8 8 0 1010.586 10.586z"></path>
                    </svg>
                </div>
            </a>
            
            <a href="{{ route('leaderboard.monthly') }}" class="bg-gradient-to-br from-yellow-500 to-orange-600 rounded-lg shadow-lg overflow-hidden p-6 text-white hover:shadow-xl transition-all transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold opacity-90">📅 Ranking Bulanan</p>
                        <p class="text-2xl font-black mt-2">Lihat Score Bulan Ini</p>
                    </div>
                    <svg class="w-12 h-12 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </a>
        </div>

        {{-- COURSES --}}
        <h2 class="text-2xl font-black mb-6 text-gray-900 dark:text-white">🚀 Petualanganku</h2>

        @if($courses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($courses as $course)
                    <a href="{{ route('courses.show', $course) }}" class="group bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all transform hover:scale-105">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-24 group-hover:from-blue-600 group-hover:to-purple-700 transition-all"></div>
                        <div class="p-6">
                            <h3 class="font-black text-lg text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $course->title }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                {{ $course->description }}
                            </p>

                            <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden mb-3">
                                <div class="h-full bg-blue-600 dark:bg-blue-500 transition-all" style="width: {{ $course->progress ?? 0 }}%"></div>
                            </div>

                            <p class="text-xs font-bold text-gray-700 dark:text-gray-300">
                                Progress: {{ $course->progress ?? 0 }}%
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-12 text-center">
                <p class="text-gray-500 dark:text-gray-400 text-lg">📚 Belum ada kursus tersedia</p>
            </div>
        @endif

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const missionCards = document.querySelectorAll('.mission-card');
        
        missionCards.forEach(card => {
            card.addEventListener('click', async function() {
                const missionId = this.dataset.missionId;
                const isCompleted = this.dataset.isCompleted === 'true';
                
                // Jangan klik jika sudah selesai
                if (isCompleted) {
                    showNotification('Misi sudah selesai! ✓', 'success');
                    return;
                }

                try {
                    // Show loading state
                    this.style.opacity = '0.5';
                    this.style.pointerEvents = 'none';

                    // Call API to complete mission
                    const response = await fetch(`/api/daily-missions/${missionId}/complete`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Mark as completed
                        this.classList.add('completed');
                        this.dataset.isCompleted = 'true';
                        
                        // Update UI
                        const progressText = this.querySelector('.progress-text');
                        const progressBar = this.querySelector('.progress-bar');
                        
                        progressText.textContent = '1/1';
                        progressBar.style.width = '100%';
                        
                        // Add done badge if not exists
                        if (!this.querySelector('.bg-green-400')) {
                            const badge = document.createElement('span');
                            badge.className = 'bg-green-400 px-2 py-1 rounded text-xs font-bold';
                            badge.textContent = '✓ DONE';
                            this.querySelector('.flex').appendChild(badge);
                        }

                        // Update user XP and Points
                        updateUserStats(data.user_xp, data.user_points);

                        // Show success notification with animation
                        showRewardNotification(data.reward_xp, data.reward_points);
                    } else {
                        showNotification(data.message || 'Gagal menyelesaikan misi', 'error');
                        this.style.opacity = '1';
                        this.style.pointerEvents = 'auto';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan: ' + error.message, 'error');
                    this.style.opacity = '1';
                    this.style.pointerEvents = 'auto';
                }
            });
        });

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white font-semibold shadow-lg z-50 animate-pulse ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 
                'bg-blue-500'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                notification.style.transition = 'opacity 0.3s ease';
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        function showRewardNotification(xp, points) {
            // Create reward notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-gradient-to-br from-yellow-400 to-orange-500 text-white px-8 py-6 rounded-2xl shadow-2xl z-50 animate-bounce text-center';
            notification.innerHTML = `
                <div class="text-4xl font-black mb-2">🎉</div>
                <p class="text-lg font-bold mb-3">Misi Selesai!</p>
                <div class="flex justify-center gap-4 text-2xl font-black">
                    <span>⭐ +${xp} XP</span>
                    <span>💎 +${points} Pts</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 2.5 seconds
            setTimeout(() => {
                notification.style.transition = 'all 0.4s ease';
                notification.style.opacity = '0';
                notification.style.transform = 'translate(-50%, -50%) scale(0.8)';
                setTimeout(() => notification.remove(), 400);
            }, 2500);
        }

        function updateUserStats(xp, points) {
            // Update XP display in header
            const xpElement = document.getElementById('header-xp');
            if (xpElement) {
                // Animate number change
                animateNumberChange(xpElement, parseInt(xpElement.textContent), xp);
                xpElement.textContent = xp;
            }
            
            // Update Points display in header
            const pointsElement = document.getElementById('header-points');
            if (pointsElement) {
                // Animate number change
                animateNumberChange(pointsElement, parseInt(pointsElement.textContent), points);
                pointsElement.textContent = points;
            }
        }

        function animateNumberChange(element, fromValue, toValue) {
            const duration = 600;
            const steps = 30;
            const stepDuration = duration / steps;
            const increment = (toValue - fromValue) / steps;
            let current = fromValue;
            let step = 0;

            const interval = setInterval(() => {
                step++;
                current += increment;
                
                if (step >= steps) {
                    element.textContent = toValue;
                    clearInterval(interval);
                } else {
                    element.textContent = Math.round(current);
                }
            }, stepDuration);
        }
    });
</script>

@endsection

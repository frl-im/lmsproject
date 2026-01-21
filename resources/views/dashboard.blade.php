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
                <p class="text-2xl font-black text-yellow-500" id="header-xp" data-user-xp="{{ Auth::user()->experience ?? 0 }}">{{ Auth::user()->experience ?? 0 }}</p>
            </div>

            <div class="w-1 h-10 bg-gradient-to-b from-blue-500 to-purple-500 rounded-full"></div>

            <div class="text-right">
                <p class="text-xs text-gray-600 dark:text-gray-400 uppercase font-bold">Points</p>
                <p class="text-2xl font-black text-green-500" id="header-points" data-user-points="{{ Auth::user()->points ?? 0 }}">{{ Auth::user()->points ?? 0 }}</p>
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

@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert Kuis (Tetap sama) --}}
            @if(session('quiz_result'))
                {{-- ... kode alert kuis Anda ... --}}
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white">{{ $lesson->title }}</h1>
                    <p class="text-blue-100">{{ $lesson->module->title }}</p>
                </div>

                <div class="p-8 md:p-12 prose dark:prose-invert max-w-none">
                    {!! $lesson->content !!}
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mb-8">
                @if ($lesson->type === 'materi')
                    @php
                        $isCompleted = auth()->user()->lessons()->where('lesson_id', $lesson->id)->exists();
                        $quizForThisLesson = $lesson->questions()->exists();
                    @endphp

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button id="complete-lesson-btn"
                                class="flex-1 font-bold py-4 px-8 rounded-lg text-lg transition-all shadow-lg flex items-center justify-center space-x-2 {{ $isCompleted ? 'bg-gray-400 cursor-not-allowed' : 'bg-gradient-to-r from-green-500 to-emerald-600 text-white hover:scale-105' }}"
                                data-lesson-id="{{ $lesson->id }}"
                                data-xp="{{ $lesson->xp_reward ?? 10 }}"
                                {{ $isCompleted ? 'disabled' : '' }}>
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $isCompleted ? '✓ Sudah Selesai' : 'Tandai Selesai & Klaim XP' }}</span>
                        </button>
                        
                        @if($quizForThisLesson)
                            <a href="{{ route('quiz.show', ['course' => $lesson->module->course_id, 'lesson' => $lesson->id]) }}" class="flex-1 inline-block bg-purple-600 text-white font-bold py-4 px-8 rounded-lg text-center hover:bg-purple-700 transition-all shadow-lg flex items-center justify-center space-x-2">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>🎯 Mulai Kuis</span>
                            </a>
                        @endif
                    </div>
                @elseif ($lesson->type === 'kuis')
                    <a href="{{ route('quiz.show', ['course' => $lesson->module->course_id, 'lesson' => $lesson->id]) }}" class="w-full inline-block bg-purple-600 text-white font-bold py-4 px-8 rounded-lg text-center hover:bg-purple-700 transition-all shadow-lg">🎯 Mulai Kuis</a>
                @endif
            </div>

          {{-- Navigasi (Perbaikan Logika) --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow flex justify-between items-center">
                @php
                    // Ambil semua lesson di modul ini, urutkan berdasarkan ID
                    $allLessonsInModule = $lesson->module->lessons->sortBy('id')->values(); 
                    
                    // Cari lesson sebelumnya
                    $prev = $allLessonsInModule->where('id', '<', $lesson->id)->last();
                    
                    // Cari lesson selanjutnya
                    $next = $allLessonsInModule->where('id', '>', $lesson->id)->first();
                    
                    // Hitung nomor urut saat ini (Index + 1)
                    // KITA GUNAKAN $lesson->id (TUNGGAL), BUKAN $lessons->id (JAMAK)
                    $currentNumber = $allLessonsInModule->search(fn($l) => $l->id === $lesson->id) + 1;
                @endphp

                @if($prev)
                    {{-- Perbaikan route: parameter harus array [$courseId, $lessonId] --}}
                    <a href="{{ route('lessons.show', [$lesson->module->course_id, $prev->id]) }}" class="text-blue-600 hover:underline">← Sebelumnya</a>
                @else
                    <span class="text-gray-400">← Sebelumnya</span>
                @endif

                <span class="text-gray-500 text-sm">Materi {{ $currentNumber }} dari {{ $allLessonsInModule->count() }}</span>

                @if($next)
                    {{-- Perbaikan route: parameter harus array [$courseId, $lessonId] --}}
                    <a href="{{ route('lessons.show', [$lesson->module->course_id, $next->id]) }}" class="text-blue-600 hover:underline">Selanjutnya →</a>
                @else
                    <span class="text-gray-400">Selanjutnya →</span>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('complete-lesson-btn')?.addEventListener('click', function() {
            const btn = this;
            const lessonId = btn.dataset.lessonId;
            const xp = btn.dataset.xp;
            const lessonTitle = document.querySelector('h1')?.textContent || 'Materi';

            btn.disabled = true;
            btn.classList.add('opacity-50');

            fetch(`/lessons/${lessonId}/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    // Sweet Alert Notification
                    Swal.fire({
                        title: '🎉 Selamat!',
                        html: `
                            <p class="text-lg font-semibold mb-3">Materi Selesai!</p>
                            <div class="bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 rounded-lg p-4 mb-4">
                                <p class="text-3xl font-bold text-green-600">+${xp} XP</p>
                                <p class="text-gray-600 dark:text-gray-300 mt-2">"${lessonTitle}"</p>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">Lanjutkan dengan mengerjakan kuis untuk XP tambahan! 🚀</p>
                        `,
                        icon: 'success',
                        confirmButtonText: 'Lanjutkan',
                        confirmButtonColor: '#10b981',
                        allowOutsideClick: false
                    });

                    // Update button
                    btn.innerHTML = '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span>✓ Sudah Selesai</span>';
                    btn.className = "flex-1 bg-gray-400 text-white font-bold py-4 px-8 rounded-lg cursor-not-allowed flex items-center justify-center space-x-2";
                    
                    // Add to notification dropdown
                    addNotificationToDropdown(`✅ "${lessonTitle}" selesai! +${xp} XP`);
                    
                    // Update notification dot
                    const notificationDot = document.getElementById('notificationDot');
                    if (notificationDot) {
                        notificationDot.classList.remove('hidden');
                    }
                }
            })
            .catch((err) => {
                Swal.fire({
                    title: '❌ Error',
                    text: 'Gagal menyimpan progress materi. Silakan coba lagi.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
                btn.disabled = false;
                btn.classList.remove('opacity-50');
            });
        });
        
        function addNotificationToDropdown(message) {
            const notificationList = document.getElementById('notificationList');
            if (!notificationList) return;
            
            const emptyMessage = notificationList.querySelector('p');
            if (emptyMessage) {
                emptyMessage.remove();
            }
            
            const notifItem = document.createElement('div');
            notifItem.className = 'bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 p-3 rounded mb-2';
            notifItem.innerHTML = `
                <div class="flex items-start gap-2">
                    <span class="text-green-500 flex-shrink-0">✓</span>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">${message}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Baru saja</p>
                    </div>
                </div>
            `;
            
            notificationList.insertBefore(notifItem, notificationList.firstChild);
        }
    </script>
    @endpush
</div>
@endsection
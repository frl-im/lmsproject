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
                    @endphp

                    <button id="complete-lesson-btn"
                            class="w-full font-bold py-4 px-8 rounded-lg text-lg transition-all shadow-lg flex items-center justify-center space-x-2 {{ $isCompleted ? 'bg-gray-400 cursor-not-allowed' : 'bg-gradient-to-r from-green-500 to-emerald-600 text-white hover:scale-105' }}"
                            data-lesson-id="{{ $lesson->id }}"
                            data-xp="{{ $lesson->xp_reward ?? 10 }}"
                            {{ $isCompleted ? 'disabled' : '' }}>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $isCompleted ? 'Sudah Selesai' : 'Tandai Selesai & Klaim XP' }}</span>
                    </button>
                @elseif ($lesson->type === 'kuis')
                    <a href="{{ route('quiz.show', $lesson) }}" class="w-full inline-block bg-purple-600 text-white font-bold py-4 px-8 rounded-lg text-center hover:bg-purple-700">Mulai Kuis</a>
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
    <script>
        document.getElementById('complete-lesson-btn')?.addEventListener('click', function() {
            const btn = this;
            const lessonId = btn.dataset.lessonId;
            const xp = btn.dataset.xp;

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
                    showNotification(`✨ Selamat! +${xp} XP`, 'success');
                    btn.innerHTML = '<span>✓ Selesai</span>';
                    btn.className = "w-full bg-gray-400 text-white font-bold py-4 px-8 rounded-lg cursor-not-allowed flex items-center justify-center";
                }
            })
            .catch(() => {
                showNotification('Gagal menyimpan progress', 'error');
                btn.disabled = false;
                btn.classList.remove('opacity-50');
            });
        });

        function showNotification(msg, type) {
            const el = document.createElement('div');
            el.className = `fixed bottom-4 right-4 px-6 py-3 rounded shadow-lg text-white ${type==='success'?'bg-green-500':'bg-red-500'}`;
            el.innerText = msg;
            document.body.appendChild(el);
            setTimeout(() => el.remove(), 3000);
        }
    </script>
    @endpush
</div>
@endsection
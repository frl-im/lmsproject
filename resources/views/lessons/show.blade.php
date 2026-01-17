<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $lesson->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Alert untuk hasil quiz -->
            @if(session('quiz_result'))
                <div class="mb-6">
                    @if(session('passed'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-6 rounded">
                            <h3 class="text-lg font-bold mb-2">🎉 Selamat! Kamu Lulus Kuis!</h3>
                            <p class="mb-2">
                                Skor: <strong>{{ session('percentage') }}%</strong> 
                                ({{ session('correct_count') }}/{{ session('total_questions') }} Benar)
                            </p>
                            <p class="mb-2">
                                Nilai Akhir: <strong>{{ session('score') }}</strong> poin
                            </p>
                            <p class="text-green-600">
                                ✨ Kamu mendapatkan <strong>{{ session('xp_reward') }} XP</strong>!
                            </p>
                        </div>
                    @else
                        <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-6 rounded">
                            <h3 class="text-lg font-bold mb-2">Oops! Skor Kurang</h3>
                            <p class="mb-2">
                                Skor: <strong>{{ session('percentage') }}%</strong> 
                                ({{ session('correct_count') }}/{{ session('total_questions') }} Benar)
                            </p>
                            <p class="text-orange-600">
                                Untuk lulus, kamu butuh minimal 70% jawaban benar.
                            </p>
                        </div>
                    @endif
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    
                    <div class="prose dark:prose-invert max-w-none mb-8">
                        {!! $lesson->content !!}
                    </div>

                </div>
            </div>

            <!-- Tombol Aksi -->
            @if ($lesson->type === 'materi')
                <div class="mt-8 flex justify-center">
                    <button id="complete-lesson-btn"
                            class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg text-lg transition-transform transform hover:scale-105"
                            data-lesson-id="{{ $lesson->id }}"
                            data-xp="{{ $lesson->xp_reward }}">
                        Tandai Selesai & Klaim XP
                    </button>
                </div>
            @elseif ($lesson->type === 'kuis')
                <div class="mt-8 flex justify-center">
                    <a href="{{ route('quiz.show', $lesson) }}"
                       class="inline-block bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 px-8 rounded-lg text-lg transition-transform transform hover:scale-105">
                        Mulai Mengerjakan Kuis →
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const completeButton = document.getElementById('complete-lesson-btn');
            if (completeButton) {
                completeButton.addEventListener('click', function () {
                    const lessonId = this.dataset.lessonId;
                    const xp = this.dataset.xp;
                    
                    fetch(`/lessons/${lessonId}/complete`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content,
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(`Selamat! Kamu mendapatkan ${xp} XP!`);
                            this.disabled = true;
                            this.innerText = '✓ Selesai';
                            this.classList.remove('bg-green-500', 'hover:bg-green-600');
                            this.classList.add('bg-gray-400', 'cursor-not-allowed');
                        } else {
                            alert(data.message || 'Terjadi kesalahan');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengirim data');
                    });
                });
            }
        });
    </script>
    @endpush

</x-app-layout>
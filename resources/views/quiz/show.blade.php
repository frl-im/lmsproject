@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Alert untuk hasil quiz -->
            @if(session('quiz_result'))
                <div class="mb-6" id="quiz-alert">
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
                            <p class="text-orange-600 mb-4">
                                Untuk lulus, kamu butuh minimal 70% jawaban benar.
                            </p>
                            <form action="{{ route('quiz.submit', $lesson) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg transition">
                                    Coba Lagi
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                @if(session('passed'))
                    <div class="mb-6">
                        <a href="{{ route('lessons.show', ['course' => $lesson->module->course_id, 'lesson' => $lesson->id]) }}" class="text-blue-500 hover:text-blue-700 font-semibold">
                            ← Kembali ke Lesson
                        </a>
                    </div>
                @endif
            @endif

            <!-- Jika sudah lulus, tampilkan hasil -->
            @if($previousAttempt && $previousAttempt->completed_at)
                <div class="mb-6 bg-blue-50 dark:bg-blue-900 border border-blue-300 dark:border-blue-700 p-6 rounded-lg">
                    <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-2">
                        ✓ Kuis Sudah Diselesaikan
                    </h3>
                    <p class="text-blue-800 dark:text-blue-200 mb-4">
                        Skor Akhir: <strong>{{ $previousAttempt->quiz_score }}%</strong> 
                        | Attempts: {{ $previousAttempt->quiz_attempts ?? 1 }}
                    </p>
                    <a href="{{ route('lessons.show', ['course' => $lesson->module->course_id, 'lesson' => $lesson->id]) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition">
                        Kembali ke Lesson
                    </a>
                </div>
            @else
                <!-- Form Kuis -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        
                        <div class="mb-8 p-4 bg-purple-50 dark:bg-purple-900 rounded-lg border border-purple-200 dark:border-purple-700">
                            <p class="text-purple-800 dark:text-purple-200">
                                📋 Kerjakan {{ $questions->count() }} soal di bawah ini. 
                                Minimal <strong>70%</strong> jawaban benar untuk lulus.
                            </p>
                        </div>

                        <form action="{{ route('quiz.submit', $lesson) }}" method="POST" id="quiz-form">
                            @csrf

                            @forelse($questions as $question)
                                <div class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                                    <!-- Nomor & Pertanyaan -->
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
                                        <span class="inline-block w-8 h-8 bg-blue-500 text-white rounded-full text-center leading-8 mr-2">
                                            {{ $loop->iteration }}
                                        </span>
                                        {{ $question->question }}
                                    </h3>

                                    <!-- Opsi Jawaban -->
                                    <div class="space-y-3 ml-10">
                                        @php $options = ['A' => 'option_a', 'B' => 'option_b', 'C' => 'option_c', 'D' => 'option_d']; @endphp
                                        
                                        @foreach($options as $label => $field)
                                            <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $label }}"
                                                    class="w-4 h-4 text-blue-500 cursor-pointer"
                                                    @required(true)>
                                                <span class="ml-3 text-gray-900 dark:text-gray-100 font-semibold">
                                                    <strong>{{ $label }}.</strong> {{ $question->$field }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>

                                    @error("answers.{$question->id}")
                                        <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            @empty
                                <div class="p-6 bg-red-100 border border-red-400 text-red-700 rounded">
                                    Tidak ada soal untuk kuis ini.
                                </div>
                            @endforelse

                            @if($questions->count() > 0)
                                <!-- Submit Button -->
                                <div class="flex gap-4 pt-6">
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg transition transform hover:scale-105">
                                        Kirim Jawaban
                                    </button>
                                    <a href="{{ route('lessons.show', ['course' => $lesson->module->course_id, 'lesson' => $lesson->id]) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-lg transition">
                                        Batal
                                    </a>
                                </div>

                                @if($errors->any())
                                    <div class="mt-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                        <ul class="list-disc list-inside">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endif
                        </form>

                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tampilkan Sweet Alert jika ada hasil quiz
        const quizAlert = document.getElementById('quiz-alert');
        if (quizAlert) {
            const isPassed = quizAlert.querySelector('.bg-green-100') !== null;
            const isOrange = quizAlert.querySelector('.bg-orange-100') !== null;
            
            if (isPassed) {
                const percentage = quizAlert.textContent.match(/(\d+)%/)[1];
                const correctCount = quizAlert.textContent.match(/(\d+)\/(\d+)/)[1];
                const totalQuestions = quizAlert.textContent.match(/(\d+)\/(\d+)/)[2];
                const score = quizAlert.textContent.match(/poin/i) ? 
                    quizAlert.textContent.split('poin')[0].trim().split(' ').pop() : '0';
                const xpReward = quizAlert.textContent.match(/(\d+)\s*XP/)[1];
                
                Swal.fire({
                    title: '🎉 Selamat!',
                    html: `
                        <p class="text-lg font-semibold mb-4">Kamu Lulus Kuis!</p>
                        <div class="bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 rounded-lg p-6 mb-4">
                            <div class="mb-3">
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Skor</p>
                                <p class="text-4xl font-bold text-green-600">${percentage}%</p>
                            </div>
                            <div class="text-sm text-gray-700 dark:text-gray-200 mb-3">
                                <p>${correctCount} dari ${totalQuestions} jawaban benar</p>
                            </div>
                            <div class="border-t border-green-300 dark:border-green-700 pt-3">
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Reward</p>
                                <p class="text-3xl font-bold text-yellow-600">+${xpReward} XP</p>
                            </div>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300">Lanjutkan ke materi berikutnya! 🚀</p>
                    `,
                    icon: 'success',
                    confirmButtonText: 'Kembali ke Materi',
                    confirmButtonColor: '#10b981',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("lessons.show", ["course" => $lesson->module->course_id, "lesson" => $lesson->id]) }}';
                    }
                });
            } else if (isOrange) {
                const percentage = quizAlert.textContent.match(/(\d+)%/)[1];
                const correctCount = quizAlert.textContent.match(/(\d+)\/(\d+)/)[1];
                const totalQuestions = quizAlert.textContent.match(/(\d+)\/(\d+)/)[2];
                
                Swal.fire({
                    title: '⚠️ Oops!',
                    html: `
                        <p class="text-lg font-semibold mb-4">Skor Kurang</p>
                        <div class="bg-gradient-to-r from-orange-100 to-yellow-100 dark:from-orange-900/30 dark:to-yellow-900/30 rounded-lg p-6 mb-4">
                            <div class="mb-3">
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Skor Anda</p>
                                <p class="text-4xl font-bold text-orange-600">${percentage}%</p>
                            </div>
                            <div class="text-sm text-gray-700 dark:text-gray-200">
                                <p>${correctCount} dari ${totalQuestions} jawaban benar</p>
                            </div>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 mb-3">Untuk lulus, kamu butuh minimal <strong>70%</strong> jawaban benar.</p>
                        <p class="text-gray-600 dark:text-gray-400">Jangan putus asa! Coba lagi dan pelajari kembali materinya. 💪</p>
                    `,
                    icon: 'warning',
                    confirmButtonText: 'Coba Lagi',
                    confirmButtonColor: '#f97316',
                    showCancelButton: true,
                    cancelButtonText: 'Kembali ke Materi',
                    cancelButtonColor: '#6b7280'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    } else if (result.dismiss) {
                        window.location.href = '{{ route("lessons.show", ["course" => $lesson->module->course_id, "lesson" => $lesson->id]) }}';
                    }
                });
            }
        }
        
        // Handle quiz form submission
        const quizForm = document.getElementById('quiz-form');
        if (quizForm) {
            quizForm.addEventListener('submit', function(e) {
                // Show loading alert
                Swal.fire({
                    title: '⏳ Mengirim Jawaban...',
                    html: 'Mohon tunggu sebentar.',
                    icon: 'info',
                    allowOutsideClick: false,
                    didOpen: (modal) => {
                        Swal.showLoading();
                    }
                });
            });
        }
    });
</script>
@endpush
@endsection

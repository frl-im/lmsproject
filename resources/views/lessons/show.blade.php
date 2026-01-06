<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $lesson->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    
                    <div class="prose dark:prose-invert max-w-none">
                        {!! $lesson->content !!}
                    </div>

                </div>
            </div>

            @if ($lesson->type == 'materi')
                <div class="mt-8 flex justify-center">
                    <button id="complete-lesson-btn"
                            class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg text-lg transition-transform transform hover:scale-105"
                            data-xp="{{ $lesson->xp_reward }}">
                        Tandai Selesai & Klaim XP
                    </button>
                </div>
            @elseif ($lesson->type == 'kuis')
                <div class="mt-8 text-center p-6 bg-purple-100 dark:bg-purple-900 rounded-lg">
                    <h3 class="text-xl font-bold text-purple-800 dark:text-purple-200">Ini adalah Kuis!</h3>
                    <p class="text-purple-700 dark:text-purple-300 mt-2">Fitur pengerjaan kuis akan segera hadir. Kerjakan materinya dulu ya!</p>
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
                    const xp = this.dataset.xp;
                    // Di proyek nyata, ini akan menjadi panggilan AJAX ke server
                    // fetch('{{-- route('lessons.complete', $lesson) --}}', { method: 'POST', ... })
                    
                    // Untuk demo, kita hanya tampilkan alert sederhana
                    alert(`Selamat! Kamu mendapatkan ${xp} XP!`);
                    
                    // Menonaktifkan tombol setelah diklik
                    this.disabled = true;
                    this.innerText = 'Selesai';
                    this.classList.remove('bg-green-500', 'hover:bg-green-600');
                    this.classList.add('bg-gray-400', 'cursor-not-allowed');
                });
            }
        });
    </script>
    @endpush

</x-app-layout>
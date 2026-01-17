<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Tambah Soal Kuis: {{ $lesson->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.quiz.store', $lesson) }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Pertanyaan -->
                        <div>
                            <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Pertanyaan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="question" name="question" rows="4" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Tuliskan pertanyaan kuis..." required>{{ old('question') }}</textarea>
                            @error('question')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Opsi Jawaban -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @php $options = ['A' => 'option_a', 'B' => 'option_b', 'C' => 'option_c', 'D' => 'option_d']; @endphp
                            
                            @foreach($options as $label => $field)
                                <div>
                                    <label for="{{ $field }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Opsi {{ $label }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="{{ $field }}" name="{{ $field }}"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Jawaban {{ $label }}..." required value="{{ old($field) }}">
                                    @error($field)
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <!-- Jawaban Benar & Poin -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="correct_answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jawaban Benar <span class="text-red-500">*</span>
                                </label>
                                <select id="correct_answer" name="correct_answer"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                    <option value="">-- Pilih Jawaban --</option>
                                    <option value="A" @selected(old('correct_answer') == 'A')>A</option>
                                    <option value="B" @selected(old('correct_answer') == 'B')>B</option>
                                    <option value="C" @selected(old('correct_answer') == 'C')>C</option>
                                    <option value="D" @selected(old('correct_answer') == 'D')>D</option>
                                </select>
                                @error('correct_answer')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="point" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Poin (Opsional)
                                </label>
                                <input type="number" id="point" name="point" min="1" value="{{ old('point', 10) }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-4 pt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition">
                                Simpan Soal
                            </button>
                            <a href="{{ route('admin.quiz.index', $lesson) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
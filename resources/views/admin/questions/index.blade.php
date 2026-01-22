<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Bank Soal: {{ $lesson->title }}
            </h2>
            <a href="{{ route('admin.questions.create', $lesson) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition">
                + Tambah Soal
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if($questions->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">No</th>
                                    <th class="px-6 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Pertanyaan</th>
                                    <th class="px-6 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Jawaban Benar</th>
                                    <th class="px-6 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Poin</th>
                                    <th class="px-6 py-3 text-center text-gray-700 dark:text-gray-300 font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($questions as $question)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                            <span class="truncate block max-w-xs">{{ $question->question }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100 font-semibold text-blue-600">
                                            {{ $question->correct_answer }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                            {{ $question->point ?? 10 }} poin
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex gap-2 justify-center">
                                                <a href="{{ route('admin.quiz.edit', $question) }}" class="text-blue-500 hover:text-blue-700 font-semibold">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.quiz.destroy', $question) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus soal ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-blue-50 dark:bg-blue-900 border-l-4 border-blue-500 p-6 rounded">
                    <p class="text-blue-800 dark:text-blue-200">
                        Belum ada soal kuis. <a href="{{ route('admin.quiz.create', $lesson) }}" class="font-bold underline">Tambah soal sekarang</a>
                    </p>
                </div>
            @endif

            <div class="mt-8">
                <a href="{{ route('admin.lessons.show', $lesson) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200">
                    ← Kembali ke Lesson
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

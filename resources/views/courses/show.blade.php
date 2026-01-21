<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $course->title }}</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $course->description }}</p>
                    </div>

                    <div class="space-y-8">
                        @forelse ($course->modules as $module)
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-lg shadow">
                                <h4 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">{{ $module->title }}</h4>
                                <ul class="space-y-3">
                                    @forelse ($module->lessons as $lesson)
                                        <li>
                                            {{-- PERBAIKAN: Hapus [$course, $lesson], cukup $lesson saja --}}
                                            <a href="{{ route('lessons.show', $lesson) }}" class="flex items-center justify-between p-4 rounded-md bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 shadow-sm transition-colors duration-200">
                                                <div class="flex items-center">
                                                    @if ($lesson->type == 'kuis')
                                                        <svg class="h-6 w-6 text-purple-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    @else
                                                        <svg class="h-6 w-6 text-blue-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18"></path></svg>
                                                    @endif
                                                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $lesson->title }}</span>
                                                </div>
                                                <span class="text-sm font-semibold text-white px-3 py-1 rounded-full {{ $lesson->type == 'kuis' ? 'bg-purple-500' : 'bg-blue-500' }}">
                                                    Lihat
                                                </span>
                                            </a>
                                        </li>
                                    @empty
                                        <li class="text-gray-500 dark:text-gray-400">Belum ada materi atau kuis di bab ini.</li>
                                    @endforelse
                                </ul>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <p class="text-gray-500 dark:text-gray-400 text-lg">Materi untuk petualangan ini sedang disiapkan. Cek lagi nanti ya!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
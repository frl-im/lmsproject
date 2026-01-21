@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header Course -->
            <div class="mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 dark:from-blue-700 dark:to-purple-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-8 md:p-12 text-white">
                        <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $course->title }}</h1>
                        <p class="text-lg text-blue-100 mb-6">{{ $course->description }}</p>
                        
                        <!-- Progress Stats -->
                        @if (Auth::user())
                            <div class="grid grid-cols-3 gap-4 mt-8 pt-8 border-t border-blue-400">
                                <div class="text-center">
                                    <div class="text-3xl font-bold">{{ $course->modules->count() }}</div>
                                    <div class="text-blue-100 text-sm">Bab/Module</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold">{{ $course->modules->sum(fn($m) => $m->lessons->count()) }}</div>
                                    <div class="text-blue-100 text-sm">Materi Total</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold">0%</div>
                                    <div class="text-blue-100 text-sm">Progres</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Course Content -->
            <div class="space-y-6">
                @forelse ($course->modules as $moduleIndex => $module)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                        <!-- Module Header -->
                        <div class="bg-gradient-to-r from-gray-100 to-gray-50 dark:from-gray-700 dark:to-gray-800 px-8 py-6 border-l-4 border-blue-500">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-blue-500 text-white h-10 w-10 rounded-full flex items-center justify-center font-bold">
                                        {{ $moduleIndex + 1 }}
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $module->title }}</h3>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">{{ $module->lessons->count() }} materi</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lessons List -->
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($module->lessons as $lessonIndex => $lesson)
                                <a href="{{ route('lessons.show', [$course, $lesson]) }}" 
                                   class="group px-8 py-5 hover:bg-blue-50 dark:hover:bg-gray-700/50 transition-colors duration-200 flex items-center justify-between">
                                    
                                    <!-- Lesson Info -->
                                    <div class="flex items-center space-x-5 flex-1">
                                        <div class="flex items-center justify-center h-12 w-12 rounded-full {{ $lesson->type == 'kuis' ? 'bg-purple-100 dark:bg-purple-900' : 'bg-blue-100 dark:bg-blue-900' }}">
                                            @if ($lesson->type == 'kuis')
                                                <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.248 6.253 2 10.501 2 15.5S6.248 24.747 12 24.747s10-4.248 10-9.247S17.752 6.253 12 6.253z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                                {{ $lesson->title }}
                                            </h4>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                                                Materi {{ $lessonIndex + 1 }} dari {{ $module->lessons->count() }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Lesson Type Badge & Arrow -->
                                    <div class="flex items-center space-x-3 ml-4">
                                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $lesson->type == 'kuis' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-200' : 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200' }}">
                                            {{ $lesson->type == 'kuis' ? '🎯 Kuis' : '📖 Materi' }}
                                        </span>
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            @empty
                                <div class="px-8 py-12 text-center">
                                    <svg class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400">Belum ada materi di bab ini</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-12 text-center">
                        <svg class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Materi Sedang Disiapkan</h3>
                        <p class="text-gray-600 dark:text-gray-400">Kursus ini belum memiliki modul atau materi. Cek lagi nanti ya!</p>
                    </div>
                @endforelse
            </div>

            <!-- Bottom Action -->
            @if (Auth::user())
                <div class="mt-12 text-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
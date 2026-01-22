@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-8">Semua Kursus</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $course)
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition overflow-hidden group">
                    <div class="h-32 bg-gradient-to-r from-blue-500 to-purple-600 group-hover:from-blue-600 group-hover:to-purple-700 transition"></div>
                    <div class="p-6">
                        <h2 class="text-xl font-bold mb-2 text-gray-900 group-hover:text-blue-600">{{ $course->title }}</h2>
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $course->description }}</p>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full">{{ $course->modules_count }} Modul</span>
                            @if(Auth::check() && Auth::user()->isPremium())
                                <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full">Akses Terbuka</span>
                            @else
                                <span class="text-xs bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">Premium</span>
                            @endif
                        </div>
                        <a href="{{ route('courses.show', $course) }}" class="mt-4 inline-block w-full text-center bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 transition">Lihat Kursus</a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada kursus tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

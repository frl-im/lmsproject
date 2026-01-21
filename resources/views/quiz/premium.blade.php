@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">🧠 Quiz Premium</h1>

    <p class="mb-6 text-gray-600">
        Akses quiz eksklusif untuk pengguna Premium.
    </p>

    @forelse ($lessons as $lesson)
        <div class="mb-4 p-4 border rounded-lg">
            <h2 class="font-semibold text-lg">{{ $lesson->title }}</h2>
            <p class="text-sm text-gray-600">
                Course: {{ $lesson->module->course->title ?? '-' }}
            </p>

            <a href="{{ route('quiz.show', $lesson) }}"
               class="inline-block mt-2 text-blue-600 underline">
                Mulai Quiz
            </a>
        </div>
    @empty
        <p>Belum ada quiz premium.</p>
    @endforelse
</div>
@endsection

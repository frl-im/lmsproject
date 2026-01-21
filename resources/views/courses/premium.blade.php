@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">🚀 Kursus Premium</h1>

    <p class="mb-6 text-gray-600">
        Halaman ini hanya bisa diakses oleh pengguna Premium.
    </p>

    @forelse ($courses as $course)
        <div class="mb-4 p-4 border rounded-lg">
            <h2 class="font-semibold text-lg">{{ $course->title }}</h2>
            <p class="text-sm text-gray-600">{{ $course->description }}</p>
        </div>
    @empty
        <p>Belum ada kursus premium.</p>
    @endforelse
</div>
@endsection

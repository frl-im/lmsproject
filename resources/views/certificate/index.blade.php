@extends('layouts.app')

@section('content')
<div class="p-8 flex justify-center">
    <div class="max-w-2xl w-full border-4 border-gray-800 p-8 text-center bg-white">

        <h1 class="text-3xl font-extrabold mb-6">🎓 CERTIFICATE</h1>

        <p class="mb-4">This certificate is proudly presented to</p>

        <h2 class="text-2xl font-bold mb-4">{{ $user->name }}</h2>

        <p class="mb-6">
            For successfully participating in the <strong>LMS Gamification Premium Program</strong>
        </p>

        <p class="text-sm text-gray-600">
            Issued on {{ now()->format('d F Y') }}
        </p>

    </div>
</div>
@endsection

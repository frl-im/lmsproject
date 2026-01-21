@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin Dashboard') }}
    </h2>
@endsection

@section('content')
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Stat Card: Users -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Siswa</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['users'] }}</p>
                        <div class="mt-4">
                            {{-- <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Lihat Siswa &rarr;</a> --}}
                        </div>
                    </div>
                </div>

                <!-- Stat Card: Courses -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Kursus</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['courses'] }}</p>
                        <div class="mt-4">
                            <a href="{{ route('admin.courses.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Kelola Kursus &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Stat Card: Lessons -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Materi/Kuis</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['lessons'] }}</p>
                        <div class="mt-4">
                            <a href="{{ route('admin.lessons.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Kelola Materi &rarr;</a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg">Akses Cepat</h3>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.courses.create') }}" class="p-4 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 font-medium">
                            + Tambah Kursus Baru
                        </a>
                        <a href="{{ route('admin.modules.create') }}" class="p-4 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 font-medium">
                            + Tambah Modul Baru
                        </a>
                        <a href="{{ route('admin.lessons.create') }}" class="p-4 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 font-medium">
                            + Tambah Materi/Kuis Baru
                        </a>
                        <a href="{{ route('admin.lessons.index') }}" class="p-4 bg-cyan-50 text-cyan-700 rounded-lg hover:bg-cyan-100 font-medium">
                            📝 Kelola Soal Kuis
                        </a>
                        <a href="{{ route('admin.users.progress.index') }}" class="p-4 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 font-medium">
                            📊 Pantau Progress User
                        </a>
                        <a href="{{ route('admin.rankings') }}" class="p-4 bg-yellow-50 text-yellow-700 rounded-lg hover:bg-yellow-100 font-medium">
                            🏆 Lihat Ranking
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

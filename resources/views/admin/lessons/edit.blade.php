@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Edit Materi/Kuis: ') . $lesson->title }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.lessons.update', $lesson) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Module -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="module_id" :value="__('Pilih Modul')" />
                                <select name="module_id" id="module_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="">-- Pilih Modul --</option>
                                    @foreach($modules as $module)
                                        <option value="{{ $module->id }}" {{ old('module_id', $lesson->module_id) == $module->id ? 'selected' : '' }}>
                                            {{ $module->title }} ({{ $module->course->title }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('module_id')" class="mt-2" />
                            </div>

                            <!-- Title -->
                            <div>
                                <x-input-label for="title" :value="__('Judul Materi/Kuis')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $lesson->title)" required />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                        </div>


                        <!-- Content -->
                        <div class="mt-4">
                            <x-input-label for="content" :value="__('Konten (Bisa berisi HTML)')" />
                            <textarea id="content" name="content" rows="10" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('content', $lesson->content) }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <!-- Type -->
                            <div>
                                <x-input-label for="type" :value="__('Tipe')" />
                                <select name="type" id="type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="materi" {{ old('type', $lesson->type) == 'materi' ? 'selected' : '' }}>Materi</option>
                                    <option value="kuis" {{ old('type', $lesson->type) == 'kuis' ? 'selected' : '' }}>Kuis</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <!-- XP Reward -->
                            <div>
                                <x-input-label for="xp_reward" :value="__('XP Reward')" />
                                <x-text-input id="xp_reward" class="block mt-1 w-full" type="number" name="xp_reward" :value="old('xp_reward', $lesson->xp_reward)" required />
                                <x-input-error :messages="$errors->get('xp_reward')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                             <a href="{{ route('admin.lessons.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                Batal
                            </a>
                            <x-primary-button class="ml-4">
                                {{ __('Perbarui') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

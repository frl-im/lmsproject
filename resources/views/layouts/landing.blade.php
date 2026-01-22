<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LMS Gamifikasi') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-poppins antialiased bg-white">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                        📚 LMS Pro
                    </a>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#features" class="text-gray-700 hover:text-blue-600 transition">Fitur</a>
                    <a href="#courses" class="text-gray-700 hover:text-blue-600 transition">Kursus</a>
                    <a href="#pricing" class="text-gray-700 hover:text-blue-600 transition">Harga</a>
                    <a href="https://wa.me/6281234567890" target="_blank" class="text-gray-700 hover:text-blue-600 transition">Hubungi</a>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600">
                            <span class="text-xl">🌐</span>
                            <span class="hidden sm:inline">ID</span>
                        </button>
                        <div class="absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition">
                            <a href="#" class="block px-4 py-2 hover:bg-blue-50">🇮🇩 Indonesia</a>
                            <a href="#" class="block px-4 py-2 hover:bg-blue-50">🇬🇧 English</a>
                        </div>
                    </div>
                    @if(Auth::check())
                        <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Login
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    <main>
        @yield('content')
    </main>
    <!-- Footer -->
    <footer class="bg-white border-t mt-16 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} LMS Pro. All rights reserved.
        </div>
    </footer>
    @stack('scripts')
</body>
</html>

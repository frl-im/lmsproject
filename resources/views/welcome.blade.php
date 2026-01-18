<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LMS Gamifikasi - Belajar Jadi Seru!</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col items-center justify-center">
        <div class="text-center p-6 max-w-2xl mx-auto">
            <h1 class="text-5xl md:text-6xl font-bold text-gray-800 dark:text-white leading-tight">
                Selamat Datang di <span class="text-blue-500">LMS Gamifikasi</span>
            </h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                Platform belajar Calistung (Baca, Tulis, Hitung) dan Logika yang membuat proses belajar menjadi petualangan yang seru dan menyenangkan!
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg text-lg transition-transform transform hover:scale-105">
                            Masuk ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg text-lg transition-transform transform hover:scale-105">
                            Login Siswa
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg text-lg transition-transform transform hover:scale-105">
                                Daftar Baru
                            </a>
                        @endif
                    @endauth
                @endif
                 <a href="{{ route('admin.login') }}" class="inline-block bg-gray-700 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-lg text-lg transition-transform transform hover:scale-105">
                    Login Admin
                </a>
            </div>
        </div>

        <footer class="mt-16 text-center text-sm text-gray-500 dark:text-gray-400">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
    </div>
</body>
</html>
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
    <body class="font-poppins antialiased bg-gray-50 dark:bg-gray-900">
        <div class="flex min-h-screen flex-col">
            <!-- NAVBAR -->
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <!-- KIRI -->
                <div class="text-lg font-bold text-gray-800 dark:text-white">
                    {{ config('app.name', 'LMS') }}
                </div>

                <!-- KANAN -->
                @auth
                <div class="relative">
                    <button id="userMenuButton"
                    class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-200 focus:outline-none">

                    <div class="w-8 h-8 min-w-[2rem] min-h-[2rem] rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold leading-none shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>

                    <span>{{ Auth::user()->name }}</span>

                    <svg id="dropdownArrow"
                        class="w-4 h-4 transform transition-transform duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>


                </button>


                    <!-- DROPDOWN -->
                    <div id="userMenu"
                        class="absolute right-0 mt-3 w-44 origin-top-right
                            opacity-0 scale-95 pointer-events-none
                            bg-white dark:bg-gray-700 rounded-xl shadow-lg z-50
                            transform transition-all duration-200 ease-out">
          
                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                            Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </header>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col">
                <!-- Page Content -->
                <main class="flex-1 overflow-auto">
                    @yield('content')
                </main>
            </div>
        </div>

        @stack('scripts')

        <!-- SCRIPT DROPDOWN -->
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('userMenuButton');
            const menu = document.getElementById('userMenu');
            const arrow = document.getElementById('dropdownArrow');

            if (!btn || !menu || !arrow) return;

            btn.addEventListener('click', function (e) {
                e.stopPropagation();

                const isOpen = menu.classList.contains('opacity-100');

                if (isOpen) {
                    // tutup dropdown
                    menu.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
                    menu.classList.add('opacity-0', 'scale-95', 'pointer-events-none');

                    arrow.classList.remove('rotate-180');
                } else {
                    // buka dropdown
                    menu.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                    menu.classList.add('opacity-100', 'scale-100', 'pointer-events-auto');

                    arrow.classList.add('rotate-180');
                }
            });

            // klik di luar → tutup
            document.addEventListener('click', function () {
                menu.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
                menu.classList.add('opacity-0', 'scale-95', 'pointer-events-none');

                arrow.classList.remove('rotate-180');
            });
        });
        </script>

    </body>
</html>

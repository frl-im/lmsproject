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
        <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <!-- KIRI -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                        📚 LMS Pro
                    </a>
                    
                    @auth
                    <nav class="flex items-center gap-6 text-sm font-medium">
                        <a href="{{ route('dashboard') }}" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                            📚 Pelajaran
                        </a>
                        <a href="{{ route('leaderboard.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-yellow-500 dark:hover:text-yellow-400 transition-colors flex items-center gap-1">
                            🏆 Leaderboard
                        </a>
                    </nav>
                    @endauth
                </div>

                <!-- KANAN -->
                @auth
                <div class="flex items-center gap-4">
                    <!-- Notification Bell -->
                    <div class="relative">
                        <button id="notificationBell" class="relative p-2 text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span id="notificationDot" class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full hidden"></span>
                        </button>
                        
                        <!-- Notification Dropdown -->
                        <div id="notificationDropdown" class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-700 rounded-xl shadow-lg z-50 hidden max-h-96 overflow-y-auto">
                            <div class="p-4 border-b border-gray-200 dark:border-gray-600">
                                <h3 class="font-bold text-gray-800 dark:text-white">Notifikasi</h3>
                            </div>
                            <div id="notificationList" class="p-4">
                                <p class="text-gray-500 dark:text-gray-400 text-sm text-center">Tidak ada notifikasi</p>
                            </div>
                        </div>
                    </div>
                    
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
                        class="absolute right-0 mt-3 w-48 origin-top-right
                            opacity-0 scale-95 pointer-events-none
                            bg-white dark:bg-gray-700 rounded-xl shadow-lg z-50
                            transform transition-all duration-200 ease-out">
          
                        <a href="{{ route('profile.show') }}"
                           class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 border-b border-gray-100 dark:border-gray-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                            Lihat Profil
                        </a>

                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 border-b border-gray-100 dark:border-gray-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                            </svg>
                            Edit Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
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
            
            // Notification Bell
            const notificationBell = document.getElementById('notificationBell');
            const notificationDropdown = document.getElementById('notificationDropdown');
            
            if (notificationBell && notificationDropdown) {
                notificationBell.addEventListener('click', function (e) {
                    e.stopPropagation();
                    notificationDropdown.classList.toggle('hidden');
                });
                
                document.addEventListener('click', function (e) {
                    if (!notificationBell.contains(e.target) && !notificationDropdown.contains(e.target)) {
                        notificationDropdown.classList.add('hidden');
                    }
                });
            }
        });
        </script>

    </body>
</html>

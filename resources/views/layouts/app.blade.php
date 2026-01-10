<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'primary': '#5E72E4',
                            'primary-light': '#E7EFFF',
                            'success': '#10B981',
                            'warning': '#F59E0B',
                            'danger': '#EF4444',
                            'duolingo-green': '#1CB687',
                            'duolingo-blue': '#1F9EDD',
                            'duolingo-orange': '#FFAB40',
                        },
                        fontFamily: {
                            'poppins': ['Poppins', 'sans-serif'],
                        }
                    }
                }
            }
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    </head>
    <body class="font-poppins antialiased bg-gray-50 dark:bg-gray-900">
        <div class="flex min-h-screen">
            <!-- Sidebar Navigation -->
            @include('layouts.sidebar-navigation')

            <!-- Main Content -->
            <div class="flex-1 flex flex-col">
                <!-- Top Bar -->
                @include('layouts.top-bar')

                <!-- Page Content -->
                <main class="flex-1 overflow-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>

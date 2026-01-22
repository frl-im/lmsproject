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
<body class="font-poppins antialiased bg-gray-50">
    <div class="flex min-h-screen">
        @if(!Auth::user() || !Auth::user()->is_admin)
            <!-- Sidebar User -->
            <aside class="w-64 h-screen fixed top-0 left-0 bg-white border-r border-gray-100 flex flex-col shadow-sm z-30">
                <div class="h-20 flex items-center justify-center border-b border-gray-100">
                    <span class="text-2xl font-bold text-gray-800">LMS Pro</span>
                </div>
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl font-medium {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('courses.show', 1) }}" class="block px-4 py-3 rounded-xl font-medium {{ request()->is('courses*') ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                        Semua Kursus
                    </a>
                    <a href="{{ route('finance.index') }}" class="block px-4 py-3 rounded-xl font-medium {{ request()->is('finance*') ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                        Finance <span class="text-xs text-gray-400">(Langganan)</span>
                    </a>
                    <a href="{{ route('leaderboard.index') }}" class="block px-4 py-3 rounded-xl font-medium {{ request()->routeIs('leaderboard.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                        Peringkat
                    </a>
                </nav>
                <div class="p-4 border-t border-gray-100">
                    <div class="flex items-center gap-3">
                        <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=E5E7EB&color=374151&size=96' }}" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover border border-gray-300">
                        <div>
                            <div class="font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                            @if(!Auth::user()->is_admin)
                                <a href="{{ route('profile.show') }}" class="text-xs text-gray-500 hover:underline">Profile</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                @csrf
                                <button type="submit" class="text-xs text-red-500 hover:underline font-bold">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>
            <!-- Main Content User -->
            <main class="flex-1 ml-64 p-8">
                @yield('content')
            </main>
        @else
            <!-- Main Content Admin (tanpa sidebar user)-->
            <main class="flex-1 p-8">
                @yield('content')
            </main>
        @endif
    </div>
    @stack('scripts')
</body>
</html>

<!-- Sidebar -->
<aside class="w-64 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 shadow-2xl fixed left-0 top-0 h-screen overflow-y-auto hidden md:flex flex-col border-r border-slate-700">
    <!-- Logo Section with Animation -->
    <div class="p-6 bg-gradient-to-r from-blue-600 to-purple-600 border-b border-purple-500">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                <span class="text-lg font-black bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">⚡</span>
            </div>
            <div class="flex-1">
                <h1 class="text-xl font-black text-white">LMS Learn</h1>
                <p class="text-xs text-blue-200 font-semibold">Gamifikasi Belajar</p>
            </div>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-3 py-6 space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" 
           class="nav-link group flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/50' : 'text-gray-300 hover:bg-slate-700/50 hover:text-blue-300' }}">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- My Courses -->
        <a href="{{ route('courses.index') }}" 
           class="nav-link group flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->routeIs('courses.*') ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-lg shadow-green-500/50' : 'text-gray-300 hover:bg-slate-700/50 hover:text-green-300' }}">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                <path d="M5 3a2 2 0 00-2 2v6h6V5a2 2 0 00-2-2H5z"></path>
                <path fill-rule="evenodd" d="M15 3a2 2 0 012 2v6h-6V5a2 2 0 012-2h2zm-2 8h6v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" clip-rule="evenodd"></path>
                <path d="M5 13H3a2 2 0 00-2 2v2a2 2 0 002 2h2v-4z"></path>
            </svg>
            <span>Kursus Saya</span>
        </a>

        <!-- Leaderboard -->
        <a href="#" 
           class="nav-link group flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 text-gray-300 hover:bg-slate-700/50 hover:text-yellow-300 cursor-not-allowed opacity-75">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <span>Leaderboard</span>
            <span class="ml-auto bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold px-2 py-1 rounded-full animate-pulse">Soon</span>
        </a>

        <!-- Achievements -->
        <a href="#" 
           class="nav-link group flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 text-gray-300 hover:bg-slate-700/50 hover:text-purple-300">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
            </svg>
            <span>Pencapaian</span>
        </a>

        <!-- Profile -->
        <a href="{{ route('profile.edit') }}" 
           class="nav-link group flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->routeIs('profile.*') ? 'bg-gradient-to-r from-pink-500 to-rose-600 text-white shadow-lg shadow-pink-500/50' : 'text-gray-300 hover:bg-slate-700/50 hover:text-pink-300' }}">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
            </svg>
            <span>Profil</span>
        </a>
    </nav>

    <!-- Divider -->
    <div class="h-px bg-gradient-to-r from-transparent via-slate-600 to-transparent mx-4"></div>

    <!-- Stats Section -->
    <div class="p-4 space-y-3">
        <!-- Total XP Card -->
        <div class="bg-gradient-to-br from-blue-500/80 to-blue-600/80 backdrop-blur-md rounded-xl p-4 text-white border border-blue-400/30 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-bold opacity-90 uppercase tracking-wider">⚡ Total XP</p>
                <span class="text-xs bg-blue-400/50 px-2 py-1 rounded-full">Level {{ floor((Auth::user()->experience ?? 0) / 100) + 1 }}</span>
            </div>
            <p class="text-3xl font-black">{{ Auth::user()->experience ?? 0 }}</p>
            <div class="mt-2 h-1 bg-blue-400/30 rounded-full overflow-hidden">
                <div class="h-full bg-white rounded-full" style="width: {{ ((Auth::user()->experience ?? 0) % 100) }}%"></div>
            </div>
        </div>

        <!-- Points Card -->
        <div class="bg-gradient-to-br from-amber-500/80 to-orange-500/80 backdrop-blur-md rounded-xl p-4 text-white border border-amber-400/30 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-bold opacity-90 uppercase tracking-wider">💎 Points</p>
                <span class="text-xs bg-amber-400/50 px-2 py-1 rounded-full">{{ Auth::user()->badges_count ?? 0 }} Badges</span>
            </div>
            <p class="text-3xl font-black">{{ Auth::user()->points ?? 0 }}</p>
        </div>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="pt-2">
            @csrf
            <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold py-2 px-4 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg text-sm transform hover:scale-105">
                🚪 Logout
            </button>
        </form>
    </div>
</aside>

<!-- Mobile Menu Button -->
<div class="md:hidden fixed top-4 left-4 z-50" x-data="{ open: false }">
    <button @click="open = !open" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
    <!-- Mobile Sidebar -->
    <div x-show="open" @click.outside="open = false" class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm">
        <aside class="w-64 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 h-screen overflow-y-auto shadow-2xl border-r border-slate-700">
            <!-- Logo Section -->
            <div class="p-6 bg-gradient-to-r from-blue-600 to-purple-600 border-b border-purple-500">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-lg font-black bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">⚡</span>
                    </div>
                    <div class="flex-1">
                        <h1 class="text-xl font-black text-white">LMS Learn</h1>
                        <p class="text-xs text-blue-200 font-semibold">Gamifikasi</p>
                    </div>
                </a>
            </div>

            <!-- Mobile Navigation -->
            <nav class="px-3 py-6 space-y-2">
                <a href="{{ route('dashboard') }}" @click="open = false"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white' : 'text-gray-300 hover:bg-slate-700/50' }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('courses.index') }}" @click="open = false"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->routeIs('courses.*') ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white' : 'text-gray-300 hover:bg-slate-700/50' }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v6h6V5a2 2 0 00-2-2H5z"></path>
                        <path fill-rule="evenodd" d="M15 3a2 2 0 012 2v6h-6V5a2 2 0 012-2h2zm-2 8h6v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" clip-rule="evenodd"></path>
                        <path d="M5 13H3a2 2 0 00-2 2v2a2 2 0 002 2h2v-4z"></path>
                    </svg>
                    <span>Kursus Saya</span>
                </a>
                <a href="{{ route('profile.edit') }}" @click="open = false"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->routeIs('profile.*') ? 'bg-gradient-to-r from-pink-500 to-rose-600 text-white' : 'text-gray-300 hover:bg-slate-700/50' }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Profil</span>
                </a>
            </nav>

            <!-- Mobile Stats -->
            <div class="p-4 space-y-3">
                <div class="bg-gradient-to-br from-blue-500/80 to-blue-600/80 rounded-xl p-4 text-white">
                    <p class="text-xs font-bold opacity-90">⚡ Total XP</p>
                    <p class="text-2xl font-black">{{ Auth::user()->experience ?? 0 }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="pt-2">
                    @csrf
                    <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white font-bold py-2 px-4 rounded-xl text-sm">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </aside>
    </div>
</div>

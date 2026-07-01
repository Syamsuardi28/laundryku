<!-- Topbar -->
<header class="sticky top-0 z-30 flex items-center justify-between px-4 py-3 bg-navbar/80 dark:bg-navbar-dark/80 backdrop-blur-xl border-b border-slate-200/50 dark:border-slate-800 sm:px-6 lg:px-8 shadow-[0_4px_24px_rgba(0,0,0,0.02)]">
    <!-- Left Section -->
    <div class="flex items-center gap-4">
        <!-- Sidebar Toggle (Mobile) -->
        <button @click="sidebarOpen = true" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors lg:hidden rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Search Bar -->
        <form action="{{ route('search.index') }}" method="GET" class="hidden sm:block relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="q" value="{{ request('q') }}" class="w-64 focus:w-80 pl-10 pr-4 py-2 text-sm bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary dark:text-slate-200 transition-all duration-page ease-out placeholder-slate-400" placeholder="Cari pelanggan, transaksi...">
        </form>
    </div>

    <!-- Right Section -->
    <div class="flex items-center gap-2 sm:gap-4">
        <!-- Dark Mode Toggle -->
        <button type="button" @click="$store.theme.toggle()" class="p-2 text-slate-400 hover:text-primary dark:hover:text-secondary hover:bg-primary-50 dark:hover:bg-slate-700 rounded-xl transition-colors">
            <svg class="w-5 h-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <svg class="w-5 h-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>

        <!-- Notifications -->
        <button class="relative p-2 text-slate-400 hover:text-primary dark:hover:text-secondary hover:bg-primary-50 dark:hover:bg-slate-700 rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 rounded-full bg-danger border-2 border-white dark:border-slate-800 animate-bounce"></span>
        </button>

        <div class="h-6 w-px bg-slate-200 dark:bg-slate-700 hidden sm:block"></div>

        <!-- Profile Dropdown -->
        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" class="flex items-center gap-2 p-1 pr-2 rounded-full hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors group">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold text-sm transition-transform duration-hover group-hover:rotate-[5deg] group-hover:scale-105">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="dropdownOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-elevated border border-slate-100 dark:border-slate-700 py-1 z-50"
                 style="display: none;">
                
                <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-700">
                    <p class="text-sm font-semibold text-slate-800 dark:text-white">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                </div>
                
                <a href="{{ route('settings.index') }}" class="block px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-primary dark:hover:text-secondary transition-colors">
                    Pengaturan Akun
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-danger hover:bg-danger-50 dark:hover:bg-danger-500/10 transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

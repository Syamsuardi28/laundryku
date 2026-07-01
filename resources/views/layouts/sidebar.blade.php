<!-- Sidebar Backdrop -->
<div 
    x-show="sidebarOpen" 
    @click="sidebarOpen = false"
    class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden"
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
></div>

<!-- Sidebar -->
<aside 
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-[280px] bg-sidebar/95 dark:bg-sidebar-dark/95 backdrop-blur-xl border-r border-slate-200/50 dark:border-slate-800 transition-transform duration-page ease-in-out lg:static lg:translate-x-0 flex flex-col h-full shadow-[4px_0_24px_rgba(0,0,0,0.02)]"
>
    <!-- Logo area -->
    <div class="flex items-center justify-between h-20 px-6 border-b border-slate-100 dark:border-slate-700 shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-secondary shadow-soft group-hover:shadow-card transition-all duration-300 group-hover:scale-105">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                </svg>
            </div>
            <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary-600 to-secondary font-sans tracking-tight">LaundryKu</span>
        </a>
        <button @click="sidebarOpen = false" class="lg:hidden p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 px-4 py-6 overflow-y-auto scrollbar-thin space-y-1.5">
        <div class="px-3 pb-2 text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Menu Utama</div>
        
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'sidebar-link-active' : 'sidebar-link-inactive' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            Dashboard
        </a>

        <a href="{{ route('transactions.index') }}" class="{{ request()->routeIs('transactions.*') ? 'sidebar-link-active' : 'sidebar-link-inactive' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
            Transaksi
        </a>

        <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'sidebar-link-active' : 'sidebar-link-inactive' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Pelanggan
        </a>

        <div class="px-3 pt-6 pb-2 text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Manajemen</div>
        
        <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'sidebar-link-active' : 'sidebar-link-inactive' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            Layanan
        </a>

        @if(auth()->user()->role === 'admin')
        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'sidebar-link-active' : 'sidebar-link-inactive' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Pengguna (Admin)
        </a>

        <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'sidebar-link-active' : 'sidebar-link-inactive' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Laporan
        </a>
        @endif
    </div>

    <!-- User & Settings Bottom -->
    <div class="p-4 border-t border-slate-100 dark:border-slate-700 shrink-0">
        <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50 dark:bg-slate-900/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary to-secondary flex items-center justify-center text-white font-bold shrink-0">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-semibold text-slate-800 dark:text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate capitalize">{{ Auth::user()->role ?? 'User' }}</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="p-2 text-slate-400 hover:text-danger hover:bg-danger-50 dark:hover:bg-danger-500/20 rounded-lg transition-colors" title="Logout">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>

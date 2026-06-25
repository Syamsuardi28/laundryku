<!DOCTYPE html>
<html lang="id" x-data x-init="$store.theme.init()" :class="{ 'dark': $store.theme.dark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - LaundryKu</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
</head>
<body class="bg-surface dark:bg-surface-dark min-h-screen transition-colors duration-200">
    {{-- Loading Overlay --}}
    <div x-show="$store.loading.active" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/20 backdrop-blur-sm dark:bg-slate-900/40">
        <div class="flex flex-col items-center gap-3 rounded-2xl bg-white p-6 shadow-elevated dark:bg-slate-800">
            <svg class="h-10 w-10 animate-spin text-primary" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Memproses...</span>
        </div>
    </div>

    {{-- Toast Notification --}}
    <div x-show="$store.toast.visible" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed top-20 right-4 z-[90] max-w-sm">
        <div class="flex items-center gap-3 rounded-2xl border px-4 py-3 shadow-elevated"
             :class="{
                'bg-success-50 border-success/30 text-success-600 dark:bg-success-500/10 dark:text-success': $store.toast.type === 'success',
                'bg-danger-50 border-danger/30 text-danger dark:bg-danger-500/10': $store.toast.type === 'error',
                'bg-primary-50 border-primary/30 text-primary dark:bg-primary/10': $store.toast.type === 'info'
             }">
            <svg x-show="$store.toast.type === 'success'" class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <svg x-show="$store.toast.type === 'error'" class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            <p class="text-sm font-medium" x-text="$store.toast.message"></p>
            <button @click="$store.toast.visible = false" class="ml-auto shrink-0 opacity-60 hover:opacity-100">&times;</button>
        </div>
    </div>

    {{-- Confirm Delete Modal --}}
    <div x-data x-cloak>
        <div x-show="$store.confirm.open" class="fixed inset-0 z-[80] flex items-center justify-center p-4">
            <div x-show="$store.confirm.open" x-transition.opacity class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="$store.confirm.open = false"></div>
            <div x-show="$store.confirm.open" x-transition class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-elevated dark:bg-slate-800 animate-slide-up">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-danger-50 text-danger dark:bg-danger-500/20">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Konfirmasi Hapus</h3>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400" x-text="$store.confirm.message"></p>
                <div class="mt-6 flex gap-3">
                    <button @click="$store.confirm.open = false" class="btn-secondary flex-1">Batal</button>
                    <button @click="$store.confirm.submit()" class="btn-danger flex-1">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         TOP NAVBAR
    ============================================================ --}}
    <nav class="fixed top-0 z-50 w-full border-b border-slate-200/80 bg-white/90 backdrop-blur-xl dark:border-slate-700/80 dark:bg-slate-900/90">
        <div class="px-4 py-3 lg:px-6">
            <div class="flex items-center justify-between gap-4">
                {{-- Logo & Mobile Hamburger --}}
                <div class="flex items-center gap-3">
                    <button data-drawer-target="app-sidebar" data-drawer-toggle="app-sidebar" type="button"
                            class="inline-flex items-center rounded-xl p-2 text-slate-500 hover:bg-slate-100 lg:hidden dark:hover:bg-slate-700 transition-colors">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z" clip-rule="evenodd"/></svg>
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primary-700 text-white shadow-soft">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <div class="hidden sm:block">
                            <span class="text-lg font-bold text-slate-900 dark:text-white leading-none">LaundryKu</span>
                            <p class="text-[10px] font-medium text-slate-400 leading-none mt-0.5 uppercase tracking-widest">Management System</p>
                        </div>
                    </a>
                </div>

                {{-- Search Bar --}}
                <form action="{{ route('search.index') }}" method="GET" class="hidden flex-1 max-w-xl md:block">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="search" name="q" placeholder="Cari transaksi, pelanggan..."
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-9 pr-4 text-sm transition-all focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:focus:bg-slate-800 dark:placeholder-slate-400">
                    </div>
                </form>

                <div class="flex items-center gap-1 sm:gap-2">
                    {{-- Dark Mode Toggle --}}
                    <button @click="$store.theme.toggle()" type="button"
                            class="rounded-xl p-2.5 text-slate-500 transition-all hover:bg-slate-100 hover:text-slate-700 dark:hover:bg-slate-700 dark:hover:text-slate-300"
                            title="Toggle Dark Mode">
                        <svg x-show="!$store.theme.dark" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-show="$store.theme.dark" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>

                    {{-- Notification Bell --}}
                    <button type="button" class="relative rounded-xl p-2.5 text-slate-500 transition-all hover:bg-slate-100 dark:hover:bg-slate-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if(($pendingCount ?? 0) > 0)
                            <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-danger ring-2 ring-white dark:ring-slate-900"></span>
                        @endif
                    </button>

                    {{-- User Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" type="button" class="flex items-center gap-2.5 rounded-xl px-2 py-1.5 transition-all hover:bg-slate-100 dark:hover:bg-slate-700">
                            <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primary-700 text-xs font-bold text-white shadow-soft">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden text-left lg:block">
                                <p class="text-sm font-semibold text-slate-900 dark:text-white leading-tight">{{ auth()->user()->name }}</p>
                                <p class="text-xs capitalize text-slate-500 dark:text-slate-400 leading-tight">
                                    @if(auth()->user()->isAdmin())
                                        <span class="inline-flex items-center gap-1">
                                            <span class="h-1.5 w-1.5 rounded-full bg-success"></span>Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1">
                                            <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>Petugas
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <svg class="hidden h-4 w-4 text-slate-400 lg:block transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-cloak x-transition
                             class="absolute right-0 mt-2 w-60 rounded-2xl border border-slate-200 bg-white py-2 shadow-elevated dark:border-slate-700 dark:bg-slate-800">
                            <div class="border-b border-slate-100 px-4 py-3 dark:border-slate-700">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primary-700 text-sm font-bold text-white">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                                <span class="mt-2 inline-flex items-center rounded-lg px-2 py-0.5 text-xs font-semibold {{ auth()->user()->isAdmin() ? 'bg-success-50 text-success dark:bg-success-500/20' : 'bg-primary-50 text-primary dark:bg-primary/20' }}">
                                    {{ ucfirst(auth()->user()->role) }}
                                </span>
                            </div>
                            <a href="{{ route('settings.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-700/50 transition-colors">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Pengaturan Akun
                            </a>
                            <div class="border-t border-slate-100 dark:border-slate-700 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-2.5 px-4 py-2.5 text-sm text-danger hover:bg-danger-50 dark:hover:bg-danger-500/10 transition-colors">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- ============================================================
         SIDEBAR
    ============================================================ --}}
    <aside id="app-sidebar" class="fixed top-0 left-0 z-40 h-screen w-64 -translate-x-full border-r border-slate-200/80 bg-white pt-[61px] transition-transform duration-300 dark:border-slate-700/80 dark:bg-slate-900 lg:translate-x-0" aria-label="Sidebar">
        <div class="flex h-full flex-col overflow-y-auto">
            {{-- User Info Card in Sidebar --}}
            <div class="mx-3 mt-4 mb-2 rounded-xl bg-gradient-to-br from-primary-50 to-blue-50 p-3 dark:from-primary/10 dark:to-blue-500/5 border border-primary-100/50 dark:border-primary/10">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primary-700 text-sm font-bold text-white shadow-soft shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                        <span class="inline-flex items-center gap-1 text-xs font-medium {{ auth()->user()->isAdmin() ? 'text-success' : 'text-primary' }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ auth()->user()->isAdmin() ? 'bg-success' : 'bg-primary' }}"></span>
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Navigation Menu --}}
            <nav class="flex-1 px-3 pb-4">
                {{-- Main Section --}}
                <p class="mb-2 mt-4 px-3 text-[10px] font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">Menu Utama</p>
                <ul class="space-y-0.5">
                    {{-- Dashboard --}}
                    <li>
                        <a href="{{ route('dashboard') }}"
                           class="{{ request()->routeIs('dashboard') ? 'sidebar-link-active' : 'sidebar-link-inactive' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    {{-- Pelanggan — Hierarchical --}}
                    <li>
                        <div x-data="{ open: {{ request()->routeIs('customers.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" type="button" class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-semibold transition-all hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300">
                                <svg class="h-5 w-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Pelanggan</span>
                                <svg class="ml-auto h-4 w-4 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <ul x-show="open" x-cloak class="mt-1 space-y-0.5 pl-8">
                                <li>
                                    <a href="{{ route('customers.index') }}" class="block rounded-lg py-1.5 px-3 text-xs font-medium transition-all {{ request()->routeIs('customers.index') ? 'text-primary bg-primary-50 dark:bg-primary/20' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200' }}">
                                        Data Pelanggan
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('customers.create') }}" class="block rounded-lg py-1.5 px-3 text-xs font-medium transition-all {{ request()->routeIs('customers.create') ? 'text-primary bg-primary-50 dark:bg-primary/20' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200' }}">
                                        Tambah Pelanggan
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- Transaksi — Hierarchical --}}
                    <li>
                        <div x-data="{ open: {{ request()->routeIs('transactions.index', 'transactions.create', 'transactions.edit', 'transactions.show') ? 'true' : 'false' }} }">
                            <button @click="open = !open" type="button" class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-semibold transition-all hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300">
                                <svg class="h-5 w-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <span>Transaksi</span>
                                <svg class="ml-auto h-4 w-4 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <ul x-show="open" x-cloak class="mt-1 space-y-0.5 pl-8">
                                <li>
                                    <a href="{{ route('transactions.create') }}" class="block rounded-lg py-1.5 px-3 text-xs font-medium transition-all {{ request()->routeIs('transactions.create') ? 'text-primary bg-primary-50 dark:bg-primary/20' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200' }}">
                                        Buat Transaksi
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('transactions.index') }}" class="block rounded-lg py-1.5 px-3 text-xs font-medium transition-all {{ request()->routeIs('transactions.index', 'transactions.show', 'transactions.edit') ? 'text-primary bg-primary-50 dark:bg-primary/20' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200' }}">
                                        Data Transaksi
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- Nota — Hierarchical --}}
                    <li>
                        <div x-data="{ open: {{ request()->routeIs('transactions.nota-masuk', 'transactions.nota-pengambilan') ? 'true' : 'false' }} }">
                            <button @click="open = !open" type="button" class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-semibold transition-all hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300">
                                <svg class="h-5 w-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span>Nota</span>
                                <svg class="ml-auto h-4 w-4 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <ul x-show="open" x-cloak class="mt-1 space-y-0.5 pl-8">
                                <li>
                                    <a href="{{ route('transactions.nota-masuk') }}" class="block rounded-lg py-1.5 px-3 text-xs font-medium transition-all {{ request()->routeIs('transactions.nota-masuk') ? 'text-primary bg-primary-50 dark:bg-primary/20' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200' }}">
                                        Nota Masuk Laundry
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('transactions.nota-pengambilan') }}" class="block rounded-lg py-1.5 px-3 text-xs font-medium transition-all {{ request()->routeIs('transactions.nota-pengambilan') ? 'text-primary bg-primary-50 dark:bg-primary/20' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200' }}">
                                        Nota Pengambilan
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>

                {{-- Admin Section --}}
                @if(auth()->user()->isAdmin())
                <p class="mb-2 mt-6 px-3 text-[10px] font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">Admin</p>
                <ul class="space-y-0.5">
                    {{-- Layanan --}}
                    <li>
                        <a href="{{ route('services.index') }}"
                           class="{{ request()->routeIs('services.*') ? 'sidebar-link-active' : 'sidebar-link-inactive' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            <span>Layanan</span>
                        </a>
                    </li>

                    {{-- Laporan --}}
                    <li>
                        <a href="{{ route('reports.index') }}"
                           class="{{ request()->routeIs('reports.*') ? 'sidebar-link-active' : 'sidebar-link-inactive' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <span>Laporan</span>
                        </a>
                    </li>

                    {{-- Kelola User --}}
                    <li>
                        <a href="{{ route('users.index') }}"
                           class="{{ request()->routeIs('users.*') ? 'sidebar-link-active' : 'sidebar-link-inactive' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span>Kelola User</span>
                        </a>
                    </li>
                </ul>
                @endif

                {{-- Bottom Section --}}
                <p class="mb-2 mt-6 px-3 text-[10px] font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">Akun</p>
                <ul class="space-y-0.5">
                    <li>
                        <a href="{{ route('settings.index') }}"
                           class="{{ request()->routeIs('settings.*') ? 'sidebar-link-active' : 'sidebar-link-inactive' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Profil</span>
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="sidebar-link-inactive w-full text-left !text-danger hover:!bg-danger-50 dark:hover:!bg-danger-500/10">
                                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    {{-- ============================================================
         MAIN CONTENT
    ============================================================ --}}
    <div class="lg:ml-64">
        <main class="min-h-screen p-4 pt-20 lg:p-6 lg:pt-24">
            @if(session('success'))
                <script>document.addEventListener('DOMContentLoaded', () => Alpine.store('toast').show(@json(session('success')), 'success'));</script>
            @endif
            @if(session('error'))
                <script>document.addEventListener('DOMContentLoaded', () => Alpine.store('toast').show(@json(session('error')), 'error'));</script>
            @endif
            @if(session('print_auto'))
                <script>window.open(@json(session('print_auto')), '_blank');</script>
            @endif

            @yield('content')
        </main>
    </div>

    <style>[x-cloak] { display: none !important; }</style>
</body>
</html>

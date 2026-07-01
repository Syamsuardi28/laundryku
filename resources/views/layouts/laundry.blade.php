<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }" :class="{ 'dark': $store.theme?.dark }" style="overscroll-behavior-y: none;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - LaundryKu</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @stack('scripts')
</head>
<body class="font-sans antialiased text-slate-800 bg-surface dark:bg-surface-dark selection:bg-primary selection:text-white transition-colors duration-200" style="overscroll-behavior-y: none;">
    
    {{-- Alpine Theme Store Init --}}
    <div x-data x-init="if($store.theme) $store.theme.init()"></div>

    {{-- Loading Overlay --}}
    <div x-data x-show="$store.loading?.active" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/20 backdrop-blur-sm dark:bg-slate-900/40">
        <div class="flex flex-col items-center gap-3 rounded-2xl bg-white p-6 shadow-elevated dark:bg-slate-800">
            <svg class="h-10 w-10 animate-spin text-primary" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Memproses...</span>
        </div>
    </div>

    {{-- Premium Toast Notification --}}
    <div x-data="{ 
            visible: false, 
            timeout: null,
            init() {
                this.$watch('$store.toast.visible', value => {
                    this.visible = value;
                    if (value) {
                        clearTimeout(this.timeout);
                        this.timeout = setTimeout(() => {
                            this.$store.toast.visible = false;
                        }, 4000); // 4 seconds
                    }
                });
            }
         }"
         x-show="visible" x-cloak
         x-transition:enter="transition ease-out duration-300 cubic-bezier(0.175, 0.885, 0.32, 1.275)"
         x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:translate-x-8"
         x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:translate-x-0"
         x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:translate-x-8"
         class="fixed bottom-6 right-4 sm:right-6 z-[100] max-w-sm w-[90vw] sm:w-96"
         @mouseenter="clearTimeout(timeout)"
         @mouseleave="timeout = setTimeout(() => $store.toast.visible = false, 3000)">
        
        <div class="relative overflow-hidden flex items-start gap-3.5 p-4 rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.2)] dark:shadow-[0_10px_40px_-10px_rgba(0,0,0,0.5)] border bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl"
             :class="{
                'border-success-500/30 dark:border-success-500/20': $store.toast?.type === 'success',
                'border-danger-500/30 dark:border-danger-500/20': $store.toast?.type === 'error',
                'border-primary-500/30 dark:border-primary-500/20': $store.toast?.type === 'info'
             }">
            
            <!-- Dynamic Left Accent Line -->
            <div class="absolute left-0 top-0 bottom-0 w-1.5"
                 :class="{
                    'bg-success-500 shadow-[0_0_10px_rgba(34,197,94,0.4)]': $store.toast?.type === 'success',
                    'bg-danger-500 shadow-[0_0_10px_rgba(239,68,68,0.4)]': $store.toast?.type === 'error',
                    'bg-primary-500 shadow-[0_0_10px_rgba(37,99,235,0.4)]': $store.toast?.type === 'info'
                 }">
            </div>

            <!-- Icon -->
            <div class="shrink-0 rounded-full p-2 mt-0.5"
                 :class="{
                     'bg-success-50 text-success-600 dark:bg-success-500/10 dark:text-success-400': $store.toast?.type === 'success',
                     'bg-danger-50 text-danger-600 dark:bg-danger-500/10 dark:text-danger-400': $store.toast?.type === 'error',
                     'bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400': $store.toast?.type === 'info'
                 }">
                <!-- Success -->
                <svg x-show="$store.toast?.type === 'success'" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                <!-- Error -->
                <svg x-show="$store.toast?.type === 'error'" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                <!-- Info -->
                <svg x-show="$store.toast?.type === 'info'" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>

            <!-- Content -->
            <div class="flex-1 pr-2 pt-1">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white" 
                    x-text="$store.toast?.type === 'success' ? 'Berhasil!' : ($store.toast?.type === 'error' ? 'Terjadi Kesalahan' : 'Informasi')"></h3>
                <p class="mt-1 text-sm font-medium text-slate-600 dark:text-slate-400 leading-relaxed" x-text="$store.toast?.message"></p>
            </div>

            <!-- Close Button -->
            <button @click="$store.toast.visible = false" class="absolute top-3 right-3 p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:text-slate-300 dark:hover:bg-slate-800 transition-colors focus:outline-none">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    </div>

    {{-- Confirm Delete Modal --}}
    <div x-data x-cloak>
        <div x-show="$store.confirm?.open" class="fixed inset-0 z-[80] flex items-center justify-center p-4">
            <div x-show="$store.confirm?.open" x-transition.opacity class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="$store.confirm.open = false"></div>
            <div x-show="$store.confirm?.open" x-transition class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-elevated dark:bg-slate-800 animate-slide-up">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-danger-50 text-danger dark:bg-danger-500/20">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Konfirmasi Hapus</h3>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400" x-text="$store.confirm?.message"></p>
                <div class="mt-6 flex gap-3">
                    <button @click="$store.confirm.open = false" class="w-full h-10 px-4 rounded-xl border border-slate-200 dark:border-slate-700 font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">Batal</button>
                    <button @click="$store.confirm.submit()" class="w-full h-10 px-4 rounded-xl bg-danger text-white font-medium hover:bg-danger-600 transition-colors">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden scrollbar-thin overscroll-none bg-surface dark:bg-surface-dark">
            <!-- Topbar -->
            @include('layouts.topbar')

            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 w-full max-w-7xl mx-auto"
                  x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)"
                  x-show="mounted"
                  x-transition:enter="transition ease-out duration-page"
                  x-transition:enter-start="opacity-0 translate-y-5"
                  x-transition:enter-end="opacity-100 translate-y-0">
                @if(session('success'))
                    <script>document.addEventListener('DOMContentLoaded', () => { if(window.Alpine && Alpine.store('toast')) Alpine.store('toast').show(@json(session('success')), 'success'); });</script>
                @endif
                @if(session('error'))
                    <script>document.addEventListener('DOMContentLoaded', () => { if(window.Alpine && Alpine.store('toast')) Alpine.store('toast').show(@json(session('error')), 'error'); });</script>
                @endif
                @if(session('print_auto'))
                    <script>window.open(@json(session('print_auto')), '_blank');</script>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <style>[x-cloak] { display: none !important; }</style>
</body>
</html>

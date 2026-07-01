<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LaundryKu') }} - Laundry Lebih Mudah, Cepat, dan Modern</title>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- AlpineJS for Interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .spotlight {
            background: radial-gradient(circle at center, rgba(37,99,235,0.15) 0%, transparent 70%);
        }
        .dark .spotlight {
            background: radial-gradient(circle at center, rgba(37,99,235,0.2) 0%, transparent 70%);
        }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 selection:bg-primary selection:text-white transition-colors duration-300" x-data="{ scrolled: false, mobileMenu: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Alpine Theme Store Init -->
    <div x-data x-init="if($store.theme) $store.theme.init()"></div>

    <!-- Navbar -->
    <nav :class="{'bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl shadow-sm border-b border-slate-200 dark:border-slate-800 py-3': scrolled, 'bg-transparent py-5': !scrolled}" class="fixed top-0 inset-x-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-12">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#2563EB] to-[#06B6D4] flex items-center justify-center shadow-lg group hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white group-hover:rotate-12 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                        </svg>
                    </div>
                    <span class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">LaundryKu</span>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#fitur" class="text-sm font-bold text-slate-600 dark:text-slate-300 hover:text-[#2563EB] dark:hover:text-[#60A5FA] transition-colors">Fitur</a>
                    <a href="#cara-kerja" class="text-sm font-bold text-slate-600 dark:text-slate-300 hover:text-[#2563EB] dark:hover:text-[#60A5FA] transition-colors">Cara Kerja</a>
                    <a href="#testimoni" class="text-sm font-bold text-slate-600 dark:text-slate-300 hover:text-[#2563EB] dark:hover:text-[#60A5FA] transition-colors">Testimoni</a>
                    <a href="#faq" class="text-sm font-bold text-slate-600 dark:text-slate-300 hover:text-[#2563EB] dark:hover:text-[#60A5FA] transition-colors">FAQ</a>
                </div>

                <!-- Actions -->
                <div class="hidden md:flex items-center gap-4">
                    <!-- Dark Mode Toggle -->
                    <button type="button" @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light')" class="p-2 text-slate-400 hover:text-[#2563EB] dark:hover:text-[#60A5FA] bg-slate-100 dark:bg-slate-800 rounded-xl transition-all shadow-inner">
                        <svg class="w-5 h-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        <svg class="w-5 h-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                    </button>
                    
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#2563EB] to-[#3B82F6] text-white text-sm font-bold shadow-[0_4px_12px_rgba(37,99,235,0.25)] hover:shadow-[0_6px_20px_rgba(37,99,235,0.4)] hover:-translate-y-0.5 transition-all">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-700 dark:text-slate-200 hover:text-[#2563EB] dark:hover:text-[#60A5FA] transition-colors">Log in</a>
                        <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#2563EB] to-[#3B82F6] text-white text-sm font-bold shadow-[0_4px_12px_rgba(37,99,235,0.25)] hover:shadow-[0_6px_20px_rgba(37,99,235,0.4)] hover:-translate-y-0.5 transition-all">Mulai Gratis</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center gap-2">
                    <button type="button" @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light')" class="p-2 text-slate-400 hover:text-[#2563EB] bg-slate-100 dark:bg-slate-800 rounded-xl transition-all">
                        <svg class="w-5 h-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        <svg class="w-5 h-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                    </button>
                    <button @click="mobileMenu = !mobileMenu" class="p-2 text-slate-600 dark:text-slate-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="mobileMenu" x-collapse class="md:hidden bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
            <div class="px-4 pt-2 pb-6 space-y-1">
                <a href="#fitur" @click="mobileMenu = false" class="block px-3 py-2 rounded-xl text-base font-bold text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-800">Fitur</a>
                <a href="#cara-kerja" @click="mobileMenu = false" class="block px-3 py-2 rounded-xl text-base font-bold text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-800">Cara Kerja</a>
                <a href="#testimoni" @click="mobileMenu = false" class="block px-3 py-2 rounded-xl text-base font-bold text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-800">Testimoni</a>
                <a href="#faq" @click="mobileMenu = false" class="block px-3 py-2 rounded-xl text-base font-bold text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-800">FAQ</a>
                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex flex-col gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="w-full text-center px-5 py-3 rounded-xl bg-[#2563EB] text-white font-bold">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center px-5 py-3 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold">Log in</a>
                        <a href="{{ route('login') }}" class="w-full text-center px-5 py-3 rounded-xl bg-gradient-to-r from-[#2563EB] to-[#3B82F6] text-white font-bold shadow-lg">Mulai Gratis Sekarang</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- 1. HERO SECTION -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-slate-50 dark:bg-slate-900">
        <!-- Background Effects -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none spotlight">
            <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-blue-400/20 dark:bg-blue-600/20 blur-[120px] rounded-full mix-blend-multiply dark:mix-blend-screen animate-blob"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-cyan-400/20 dark:bg-cyan-600/20 blur-[120px] rounded-full mix-blend-multiply dark:mix-blend-screen animate-blob" style="animation-delay: 2s;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto" data-aos="zoom-in" data-aos-duration="1000">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20 text-sm font-bold mb-8 shadow-sm">
                    <span class="flex h-2.5 w-2.5 rounded-full bg-blue-600 dark:bg-blue-400 animate-pulse"></span>
                    LaundryKu v2.0 Kini Tersedia
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-slate-900 dark:text-white tracking-tight leading-[1.1] mb-8">
                    Kelola Laundry Lebih <br>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-[#2563EB] to-[#06B6D4]">Mudah & Modern.</span>
                </h1>
                <p class="text-xl text-slate-600 dark:text-slate-400 mb-12 max-w-2xl mx-auto leading-relaxed font-medium">
                    Sistem manajemen laundry cerdas berbasis cloud. Pantau transaksi, kelola pelanggan, dan tingkatkan omzet bisnis Anda dalam satu platform elegan.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('login') }}" class="group w-full sm:w-auto px-8 py-4 rounded-[16px] bg-gradient-to-r from-[#2563EB] to-[#3B82F6] text-white text-lg font-bold shadow-[0_8px_24px_rgba(37,99,235,0.3)] hover:shadow-[0_12px_32px_rgba(37,99,235,0.4)] hover:-translate-y-1 transition-all flex items-center justify-center gap-2">
                        Mulai Sekarang Gratis
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                    <a href="#demo" class="group w-full sm:w-auto px-8 py-4 rounded-[16px] bg-white dark:bg-slate-800 text-slate-700 dark:text-white text-lg font-bold border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 dark:group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                        Lihat Demo
                    </a>
                </div>
            </div>

            <!-- Hero Mockup/Image -->
            <div class="mt-20 relative mx-auto max-w-5xl" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                <div class="relative rounded-[32px] border border-slate-200/60 dark:border-slate-700/60 bg-white/40 dark:bg-slate-800/40 backdrop-blur-2xl p-3 shadow-2xl transition-transform hover:scale-[1.02] duration-500 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-white/10 dark:from-slate-900/10 to-transparent"></div>
                    <div class="rounded-[24px] overflow-hidden border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-900 aspect-[16/10] sm:aspect-[16/9] flex items-center justify-center relative shadow-inner">
                        <!-- Abstract Dashboard Mockup -->
                        <div class="w-full h-full p-4 sm:p-8 flex flex-col gap-4">
                            <!-- Mockup Header -->
                            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-4">
                                <div class="flex gap-2">
                                    <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                </div>
                                <div class="w-32 h-6 rounded-md bg-slate-200 dark:bg-slate-700 animate-pulse"></div>
                            </div>
                            <!-- Mockup Content -->
                            <div class="flex-1 flex gap-6">
                                <!-- Sidebar -->
                                <div class="w-48 hidden md:flex flex-col gap-3">
                                    <div class="w-full h-8 rounded-lg bg-[#2563EB]/10 dark:bg-[#2563EB]/20 border border-[#2563EB]/20"></div>
                                    <div class="w-full h-8 rounded-lg bg-slate-200 dark:bg-slate-800"></div>
                                    <div class="w-full h-8 rounded-lg bg-slate-200 dark:bg-slate-800"></div>
                                </div>
                                <!-- Main Area -->
                                <div class="flex-1 flex flex-col gap-4">
                                    <div class="flex gap-4">
                                        <div class="flex-1 h-24 rounded-xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 p-4 flex flex-col justify-between">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50"></div>
                                            <div class="w-20 h-4 rounded bg-slate-200 dark:bg-slate-700"></div>
                                        </div>
                                        <div class="flex-1 h-24 rounded-xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 p-4 flex flex-col justify-between">
                                            <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/50"></div>
                                            <div class="w-16 h-4 rounded bg-slate-200 dark:bg-slate-700"></div>
                                        </div>
                                        <div class="flex-1 h-24 rounded-xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 p-4 flex flex-col justify-between hidden sm:flex">
                                            <div class="w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-900/50"></div>
                                            <div class="w-24 h-4 rounded bg-slate-200 dark:bg-slate-700"></div>
                                        </div>
                                    </div>
                                    <div class="flex-1 rounded-xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 p-4">
                                        <div class="w-1/3 h-6 rounded bg-slate-200 dark:bg-slate-700 mb-6"></div>
                                        <div class="space-y-3">
                                            <div class="w-full h-4 rounded bg-slate-100 dark:bg-slate-700/50"></div>
                                            <div class="w-5/6 h-4 rounded bg-slate-100 dark:bg-slate-700/50"></div>
                                            <div class="w-4/6 h-4 rounded bg-slate-100 dark:bg-slate-700/50"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. TRUSTED SECTION -->
    <section class="py-12 border-y border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-8">Dipercaya oleh bisnis laundry di seluruh Indonesia</p>
            <div class="relative overflow-hidden group">
                <div class="flex space-x-16 items-center text-center opacity-60 dark:opacity-40 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-500 w-max animate-marquee">
                    <!-- Logos -->
                    <div class="flex justify-center w-48"><h3 class="text-2xl font-black text-slate-800 dark:text-white">CleanFast</h3></div>
                    <div class="flex justify-center w-48"><h3 class="text-2xl font-black text-slate-800 dark:text-white">Wash&Go</h3></div>
                    <div class="flex justify-center w-48"><h3 class="text-2xl font-black text-slate-800 dark:text-white">KlinLaundry</h3></div>
                    <div class="flex justify-center w-48"><h3 class="text-2xl font-black text-slate-800 dark:text-white">SuperWash</h3></div>
                    <div class="flex justify-center w-48"><h3 class="text-2xl font-black text-slate-800 dark:text-white">CleanFast</h3></div>
                    <div class="flex justify-center w-48"><h3 class="text-2xl font-black text-slate-800 dark:text-white">Wash&Go</h3></div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. FITUR SECTION -->
    <section id="fitur" class="py-24 bg-slate-50 dark:bg-slate-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white mb-4">Semua yang Anda butuhkan, dalam satu tempat.</h2>
                <p class="text-lg text-slate-600 dark:text-slate-400">Tinggalkan pencatatan manual. LaundryKu mengotomatisasi bisnis Anda dari penerimaan hingga pembayaran.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Fitur 1 -->
                <div class="group bg-white dark:bg-slate-800 rounded-[24px] p-8 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Tracking Laundry</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed font-medium">Lacak status setiap cucian secara real-time dari masuk, diproses, hingga siap diambil.</p>
                </div>
                
                <!-- Fitur 2 -->
                <div class="group bg-white dark:bg-slate-800 rounded-[24px] p-8 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 rounded-2xl bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Notifikasi Otomatis</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed font-medium">Kirim notifikasi otomatis ke pelanggan saat laundry mereka sudah selesai diproses.</p>
                </div>

                <!-- Fitur 3 -->
                <div class="group bg-white dark:bg-slate-800 rounded-[24px] p-8 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-50 dark:bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Database Pelanggan</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed font-medium">Simpan data pelanggan Anda dengan aman, lengkap dengan riwayat transaksi mereka.</p>
                </div>

                <!-- Fitur 4 -->
                <div class="group bg-white dark:bg-slate-800 rounded-[24px] p-8 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Laporan Keuangan</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed font-medium">Pantau pendapatan harian, bulanan, dan performa layanan dengan grafik yang interaktif.</p>
                </div>

                <!-- Fitur 5 -->
                <div class="group bg-white dark:bg-slate-800 rounded-[24px] p-8 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Sistem Pembayaran</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed font-medium">Kelola pembayaran lunas atau DP dengan pencatatan otomatis yang rapi dan terintegrasi.</p>
                </div>

                <!-- Fitur 6 -->
                <div class="group bg-white dark:bg-slate-800 rounded-[24px] p-8 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="600">
                    <div class="w-14 h-14 rounded-2xl bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Dashboard Pintar</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed font-medium">Satu panel untuk melihat seluruh aktivitas bisnis Anda secara menyeluruh dalam sekilas.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. HOW IT WORKS -->
    <section id="cara-kerja" class="py-24 bg-white dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white mb-4">Alur Kerja Sangat Sederhana</h2>
                <p class="text-lg text-slate-600 dark:text-slate-400">Proses transaksi dari pelanggan datang hingga selesai, hanya butuh beberapa klik.</p>
            </div>

            <div class="relative max-w-5xl mx-auto">
                <!-- Connecting Line -->
                <div class="hidden lg:block absolute top-1/2 left-10 right-10 h-1 bg-slate-100 dark:bg-slate-800 -translate-y-1/2 z-0 rounded-full">
                    <div class="h-full bg-gradient-to-r from-[#2563EB] to-[#06B6D4] w-full origin-left transform scale-x-0 transition-transform duration-1000" data-aos="scale-x-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-12 lg:gap-8 relative z-10">
                    <!-- Step 1 -->
                    <div class="text-center group" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-20 h-20 mx-auto bg-white dark:bg-slate-800 border-4 border-slate-100 dark:border-slate-700 group-hover:border-[#2563EB] rounded-2xl flex items-center justify-center shadow-lg mb-6 transition-all duration-300 group-hover:-translate-y-2 group-hover:shadow-[#2563EB]/20">
                            <span class="text-2xl font-black text-slate-400 dark:text-slate-500 group-hover:text-[#2563EB] transition-colors">1</span>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Input Pesanan</h4>
                        <p class="text-slate-600 dark:text-slate-400 font-medium">Catat nama dan rincian cucian pelanggan.</p>
                    </div>
                    <!-- Step 2 -->
                    <div class="text-center group" data-aos="fade-up" data-aos-delay="200">
                        <div class="w-20 h-20 mx-auto bg-white dark:bg-slate-800 border-4 border-slate-100 dark:border-slate-700 group-hover:border-[#2563EB] rounded-2xl flex items-center justify-center shadow-lg mb-6 transition-all duration-300 group-hover:-translate-y-2 group-hover:shadow-[#2563EB]/20 lg:mt-8">
                            <span class="text-2xl font-black text-slate-400 dark:text-slate-500 group-hover:text-[#2563EB] transition-colors">2</span>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Proses Cuci</h4>
                        <p class="text-slate-600 dark:text-slate-400 font-medium">Ubah status pesanan ke Sedang Diproses.</p>
                    </div>
                    <!-- Step 3 -->
                    <div class="text-center group" data-aos="fade-up" data-aos-delay="300">
                        <div class="w-20 h-20 mx-auto bg-white dark:bg-slate-800 border-4 border-slate-100 dark:border-slate-700 group-hover:border-[#2563EB] rounded-2xl flex items-center justify-center shadow-lg mb-6 transition-all duration-300 group-hover:-translate-y-2 group-hover:shadow-[#2563EB]/20">
                            <span class="text-2xl font-black text-slate-400 dark:text-slate-500 group-hover:text-[#2563EB] transition-colors">3</span>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Selesai</h4>
                        <p class="text-slate-600 dark:text-slate-400 font-medium">Cucian selesai, notifikasi otomatis terkirim.</p>
                    </div>
                    <!-- Step 4 -->
                    <div class="text-center group" data-aos="fade-up" data-aos-delay="400">
                        <div class="w-20 h-20 mx-auto bg-white dark:bg-slate-800 border-4 border-slate-100 dark:border-slate-700 group-hover:border-[#2563EB] rounded-2xl flex items-center justify-center shadow-lg mb-6 transition-all duration-300 group-hover:-translate-y-2 group-hover:shadow-[#2563EB]/20 lg:mt-8">
                            <span class="text-2xl font-black text-slate-400 dark:text-slate-500 group-hover:text-[#2563EB] transition-colors">4</span>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Ambil</h4>
                        <p class="text-slate-600 dark:text-slate-400 font-medium">Pelanggan membayar dan mengambil cucian.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Custom CSS for animation -->
        <style>
            [data-aos="scale-x-full"] { transform: scaleX(0); }
            [data-aos="scale-x-full"].aos-animate { transform: scaleX(1); }
        </style>
    </section>

    <!-- 5. CTA SECTION -->
    <section class="py-24 relative overflow-hidden bg-slate-900">
        <div class="absolute inset-0 bg-gradient-to-br from-[#1E3A8A] to-[#0F172A] z-0"></div>
        <!-- Abstract Shapes -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-30">
            <div class="absolute -top-24 -right-24 w-[500px] h-[500px] bg-[#3B82F6] blur-[100px] rounded-full mix-blend-screen"></div>
            <div class="absolute -bottom-24 -left-24 w-[500px] h-[500px] bg-[#06B6D4] blur-[100px] rounded-full mix-blend-screen"></div>
        </div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center" data-aos="zoom-in">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6 tracking-tight">Siap meroketkan bisnis laundry Anda?</h2>
            <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto font-medium">Tinggalkan cara manual. Mulai kelola laundry Anda dengan sistem profesional kelas dunia hari ini juga.</p>
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-[16px] bg-white px-8 py-4 text-lg font-bold text-slate-900 shadow-xl transition-all duration-300 hover:scale-105 hover:bg-slate-50 hover:shadow-white/20">
                Mulai Kelola Gratis
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
            </a>
        </div>
    </section>

    <!-- 6. FOOTER -->
    <footer class="bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 pt-16 pb-8 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-[#2563EB] to-[#06B6D4] flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" /></svg>
                        </div>
                        <span class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight">LaundryKu</span>
                    </div>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Sistem manajemen laundry cerdas generasi masa depan.</p>
                </div>
                
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white mb-4">Produk</h4>
                    <ul class="space-y-3 text-sm text-slate-500 dark:text-slate-400 font-medium">
                        <li><a href="#fitur" class="hover:text-[#2563EB] dark:hover:text-[#60A5FA] transition-colors">Fitur Utama</a></li>
                        <li><a href="#cara-kerja" class="hover:text-[#2563EB] dark:hover:text-[#60A5FA] transition-colors">Cara Kerja</a></li>
                        <li><a href="#testimoni" class="hover:text-[#2563EB] dark:hover:text-[#60A5FA] transition-colors">Testimoni</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white mb-4">Bantuan</h4>
                    <ul class="space-y-3 text-sm text-slate-500 dark:text-slate-400 font-medium">
                        <li><a href="#faq" class="hover:text-[#2563EB] dark:hover:text-[#60A5FA] transition-colors">FAQ</a></li>
                        <li><a href="#" class="hover:text-[#2563EB] dark:hover:text-[#60A5FA] transition-colors">Kontak Kami</a></li>
                        <li><a href="#" class="hover:text-[#2563EB] dark:hover:text-[#60A5FA] transition-colors">Panduan</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white mb-4">Legal</h4>
                    <ul class="space-y-3 text-sm text-slate-500 dark:text-slate-400 font-medium">
                        <li><a href="#" class="hover:text-[#2563EB] dark:hover:text-[#60A5FA] transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-[#2563EB] dark:hover:text-[#60A5FA] transition-colors">Kebijakan Privasi</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 border-t border-slate-200 dark:border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">© {{ date('Y') }} LaundryKu. All rights reserved.</p>
                <div class="flex gap-4">
                    <!-- Social Icons -->
                    <a href="#" class="text-slate-400 hover:text-[#2563EB] transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    <a href="#" class="text-slate-400 hover:text-[#2563EB] transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS Script Initialization -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                once: true,
                duration: 800,
                easing: 'ease-out-cubic',
                offset: 50,
            });
        });
    </script>
</body>
</html>

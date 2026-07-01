<x-guest-layout>
    <div class="flex min-h-screen bg-surface dark:bg-surface-dark w-full">
        <!-- Left Side: Illustration & Tagline -->
        <div class="hidden lg:flex flex-col justify-between w-1/2 bg-gradient-to-br from-primary-600 to-secondary p-12 relative overflow-hidden">
            <!-- Abstract Background Elements -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-secondary/20 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-soft">
                    <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" /></svg>
                </div>
                <span class="text-2xl font-bold text-white tracking-tight">LaundryKu</span>
            </div>

            <div class="relative z-10 animate-slide-up flex-1 flex flex-col justify-center">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                    Gabung Sekarang,<br>Kembangkan Bisnismu.
                </h1>
                <p class="text-lg text-primary-100 max-w-md leading-relaxed">
                    Lebih dari 1000+ pengusaha laundry telah mempercayakan bisnisnya pada sistem kami.
                </p>
                
                <!-- Features List -->
                <div class="mt-12 space-y-4">
                    <div class="flex items-center gap-3 text-white">
                        <div class="w-8 h-8 rounded-full bg-success flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <span class="font-medium">Otomatisasi Laporan Keuangan</span>
                    </div>
                    <div class="flex items-center gap-3 text-white">
                        <div class="w-8 h-8 rounded-full bg-success flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <span class="font-medium">Manajemen Pelanggan & WhatsApp Notif</span>
                    </div>
                </div>
            </div>
            
            <div class="relative z-10 text-sm text-primary-200">
                &copy; {{ date('Y') }} LaundryKu. All rights reserved.
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="flex-1 flex flex-col justify-center items-center p-6 sm:p-12 relative">
            <!-- Dark Mode Toggle Mobile -->
            <div class="absolute top-6 right-6 lg:hidden">
                <button @click="document.documentElement.classList.toggle('dark')" class="p-2 text-slate-400 hover:text-primary transition-colors bg-white dark:bg-slate-800 rounded-xl shadow-soft">
                    <svg class="w-5 h-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <svg class="w-5 h-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                </button>
            </div>

            <div class="w-full max-w-md bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl rounded-[24px] shadow-elevated border border-slate-100 dark:border-slate-800 p-8 sm:p-10 animate-slide-up">
                
                <div class="text-center mb-8">
                    <div class="lg:hidden flex justify-center mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center shadow-soft">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" /></svg>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Buat Akun Baru</h2>
                    <p class="text-slate-500 dark:text-slate-400">Bergabunglah dalam hitungan detik</p>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-danger-50 dark:bg-danger-500/10 border border-danger-200 dark:border-danger-500/20 text-danger-600 dark:text-danger-400 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf
                    
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nama Outlet / Owner</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 focus-within:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="input-modern pl-11" placeholder="LaundryKu Pusat">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 focus-within:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="input-modern pl-11" placeholder="owner@laundryku.test">
                        </div>
                    </div>

                    <!-- Password -->
                    <div x-data="{ show: false }">
                        <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input id="password" :type="show ? 'text' : 'password'" name="password" required class="input-modern pl-11 pr-11" placeholder="••••••••">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div x-data="{ show: false }">
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Konfirmasi Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input id="password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation" required class="input-modern pl-11 pr-11" placeholder="••••••••">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full h-12 rounded-[14px] bg-gradient-to-r from-primary to-secondary text-white font-bold shadow-soft hover:shadow-card hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                        Buat Akun
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800">
                    <p class="text-center text-sm text-slate-500 mb-4">Sudah punya akun?</p>
                    <a href="{{ route('login') }}" class="w-full h-12 rounded-[14px] bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all flex items-center justify-center">
                        Login Sekarang
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>

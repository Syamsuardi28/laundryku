<x-guest-layout>
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .animate-float { animation: float 3s ease-in-out infinite; }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .animate-shake { animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both; }
        
        .blur-to-clear { animation: blurToClear 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes blurToClear {
            0% { filter: blur(10px); opacity: 0; transform: scale(0.95); }
            100% { filter: blur(0); opacity: 1; transform: scale(1); }
        }
    </style>

    <div class="flex min-h-screen bg-[#F8FAFC] dark:bg-slate-900 w-full font-['Plus_Jakarta_Sans'] relative">
        

        <!-- ==============================================
             LEFT SIDE: VISUAL & COPY
             ============================================== -->
        <div class="hidden lg:flex flex-col justify-between w-[55%] relative overflow-hidden bg-gradient-to-br from-[#2563EB] via-[#3B82F6] to-[#06B6D4] p-12">
            
            <!-- Blob & Pattern Decorators -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
                <!-- Abstract Pattern overlay -->
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
                <!-- Blobs -->
                <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-white/20 rounded-full mix-blend-overlay filter blur-[80px] animate-blob"></div>
                <div class="absolute top-[20%] right-[-10%] w-80 h-80 bg-[#06B6D4]/40 rounded-full mix-blend-overlay filter blur-[80px] animate-blob animation-delay-2000"></div>
                <div class="absolute bottom-[-10%] left-[20%] w-96 h-96 bg-white/20 rounded-full mix-blend-overlay filter blur-[80px] animate-blob animation-delay-4000"></div>
            </div>

            <!-- Header Left -->
            <div class="relative z-10 flex items-center gap-3 blur-to-clear" style="animation-delay: 0.1s;">
                <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20 shadow-lg animate-float">
                    <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" /></svg>
                </div>
                <span class="text-2xl font-bold text-white tracking-tight">LaundryKu</span>
            </div>

            <!-- Content Left -->
            <div class="relative z-10 blur-to-clear" style="animation-delay: 0.3s;">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-[1.15] mb-6 tracking-tight">
                    Kelola Bisnis Laundry<br>Anda Lebih Mudah
                </h1>
                <p class="text-lg text-blue-100 max-w-lg leading-relaxed mb-10 font-medium">
                    Kelola pelanggan, transaksi, pembayaran, laporan, dan proses laundry dalam satu sistem yang modern dan efisien.
                </p>
                
                <!-- Highlights -->
                <div class="grid grid-cols-2 gap-4 max-w-md">
                    @foreach(['Cepat', 'Aman', 'Mudah Digunakan', 'Dashboard Modern'] as $highlight)
                    <div class="flex items-center gap-3 blur-to-clear" style="animation-delay: {{ 0.4 + ($loop->index * 0.1) }}s;">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-blue-50 font-semibold">{{ $highlight }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="relative z-10 text-sm font-medium text-blue-200 blur-to-clear" style="animation-delay: 0.5s;">
                &copy; {{ date('Y') }} LaundryKu. All rights reserved.
            </div>
        </div>

        <!-- ==============================================
             RIGHT SIDE: LOGIN FORM
             ============================================== -->
        <div class="flex-1 flex flex-col justify-center items-center p-6 sm:p-12 relative" x-data="loginForm()">
            
            <!-- Top Right Actions (Back & Dark Mode) -->
            <div class="absolute top-6 right-6 sm:top-8 sm:right-8 flex items-center gap-3 z-50 blur-to-clear" style="animation-delay: 0.1s;">
                <!-- Back to Home Button -->
                <a href="{{ url('/') }}" class="group p-2.5 text-slate-400 hover:text-[#2563EB] bg-white/80 dark:bg-slate-800/80 backdrop-blur-md rounded-xl shadow-sm hover:shadow-md transition-all border border-slate-100 dark:border-slate-700 flex items-center justify-center" title="Kembali ke Beranda">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                
                <!-- Dark Mode Toggle (Desktop & Mobile) -->
                <button @click="$store.theme.toggle()" class="p-2.5 text-slate-400 hover:text-[#2563EB] bg-white/80 dark:bg-slate-800/80 backdrop-blur-md rounded-xl shadow-sm hover:shadow-md transition-all border border-slate-100 dark:border-slate-700 flex items-center justify-center" title="Toggle Dark Mode">
                    <svg class="w-5 h-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <svg class="w-5 h-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                </button>
            </div>

            <!-- Login Card -->
            <div 
                x-data="{
                    mouseX: 0, mouseY: 0, rotateX: 0, rotateY: 0, hovering: false,
                    handleMouseMove(e) {
                        this.hovering = true;
                        const rect = this.$el.getBoundingClientRect();
                        this.mouseX = e.clientX - rect.left;
                        this.mouseY = e.clientY - rect.top;
                        const centerX = rect.width / 2;
                        const centerY = rect.height / 2;
                        this.rotateX = -((this.mouseY - centerY) / centerY) * 4;
                        this.rotateY = ((this.mouseX - centerX) / centerX) * 4;
                    },
                    handleMouseLeave() {
                        this.hovering = false;
                        this.rotateX = 0;
                        this.rotateY = 0;
                    }
                }"
                @mousemove="handleMouseMove"
                @mouseleave="handleMouseLeave"
                :style="`transform: perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg);`"
                :class="[shakeForm ? 'animate-shake' : '', hovering ? '' : 'transition-transform duration-500 ease-out']" 
                class="w-full max-w-[420px] bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl rounded-[28px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-[#E2E8F0] dark:border-slate-800 p-8 sm:p-10 blur-to-clear relative overflow-hidden group" 
                style="animation-delay: 0.2s;"
            >
                <!-- Interactive Spotlight Glow -->
                <div class="absolute inset-0 z-0 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                     :style="`background: radial-gradient(400px circle at ${mouseX}px ${mouseY}px, rgba(37,99,235,0.08), transparent 80%);`">
                </div>
                
                <div class="relative z-10">
                    <div class="text-center mb-8">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden flex justify-center mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#2563EB] to-[#06B6D4] flex items-center justify-center shadow-lg animate-float">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" /></svg>
                        </div>
                    </div>
                    <div class="hidden lg:flex justify-center mb-5">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#2563EB] to-[#06B6D4] flex items-center justify-center shadow-lg animate-float">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" /></svg>
                        </div>
                    </div>
                    <h2 class="text-[28px] font-extrabold text-[#0F172A] dark:text-white mb-1 tracking-tight">LaundryKu</h2>
                    <p class="text-sm font-medium text-[#334155] dark:text-slate-400">Laundry Management System</p>
                </div>

                <!-- Error Message -->
                <div x-show="errorMessage" x-transition.opacity.duration.300ms x-cloak class="mb-6 p-4 rounded-[16px] bg-red-50 dark:bg-red-500/10 border border-red-100 dark:border-red-500/20 text-red-600 dark:text-red-400 text-sm flex items-start gap-3">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span x-text="errorMessage" class="font-medium"></span>
                </div>

                <form @submit.prevent="submitLogin" class="space-y-5">
                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-bold text-[#0F172A] dark:text-slate-300 mb-2">Email Address</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors duration-200">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                            </div>
                            <input type="email" x-model="email" x-ref="emailInput" required placeholder="admin@laundryku.test" 
                                   :class="{'border-red-500 focus:border-red-500 focus:ring-red-500/20': errorMessage}"
                                   class="w-full rounded-[16px] border border-[#E2E8F0] dark:border-slate-700 bg-[#F8FAFC]/50 dark:bg-slate-800/50 pl-11 pr-4 py-3.5 text-[15px] font-medium text-[#0F172A] dark:text-white placeholder-slate-400 dark:placeholder-slate-500 transition-all duration-200 focus:border-[#2563EB] focus:ring-[4px] focus:ring-[#2563EB]/10 focus:outline-none focus:bg-white dark:focus:bg-slate-800 hover:border-slate-300 dark:hover:border-slate-600 shadow-sm">
                        </div>
                    </div>

                    <!-- Password -->
                    <div x-data="{ show: false }">
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-bold text-[#0F172A] dark:text-slate-300">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[13px] font-bold text-[#2563EB] hover:text-[#3B82F6] transition-colors">Lupa Password?</a>
                            @endif
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors duration-200">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input :type="show ? 'text' : 'password'" x-model="password" required placeholder="••••••••" 
                                   :class="{'border-red-500 focus:border-red-500 focus:ring-red-500/20': errorMessage}"
                                   class="w-full rounded-[16px] border border-[#E2E8F0] dark:border-slate-700 bg-[#F8FAFC]/50 dark:bg-slate-800/50 pl-11 pr-12 py-3.5 text-[15px] font-medium text-[#0F172A] dark:text-white placeholder-slate-400 dark:placeholder-slate-500 transition-all duration-200 focus:border-[#2563EB] focus:ring-[4px] focus:ring-[#2563EB]/10 focus:outline-none focus:bg-white dark:focus:bg-slate-800 hover:border-slate-300 dark:hover:border-slate-600 shadow-sm">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-[#0F172A] dark:hover:text-white transition-colors focus:outline-none">
                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative flex items-center justify-center">
                                <input type="checkbox" x-model="remember" class="peer appearance-none w-5 h-5 rounded-[6px] border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 checked:bg-[#2563EB] checked:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/20 transition-all duration-200 cursor-pointer">
                                <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-[14px] font-bold text-[#334155] dark:text-slate-400 group-hover:text-[#0F172A] dark:group-hover:text-slate-200 transition-colors">Remember Me</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" :disabled="loading" class="w-full h-[52px] rounded-[16px] bg-gradient-to-r from-[#2563EB] to-[#3B82F6] text-white text-[15px] font-bold shadow-[0_4px_12px_rgba(37,99,235,0.25)] hover:shadow-[0_6px_20px_rgba(37,99,235,0.4)] hover:-translate-y-[2px] active:scale-[0.98] active:translate-y-0 hover:from-[#3B82F6] hover:to-[#60A5FA] transition-all duration-300 flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none">
                        <svg x-show="loading" class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span x-text="loading ? 'Memproses...' : 'Masuk ke Sistem'"></span>
                    </button>
                </form>
                
                </div> <!-- End of z-10 content wrapper -->

            </div>
        </div>
    </div>

    <!-- Alpine.js Form Logic for Login -->
    <script>
        function loginForm() {
            return {
                email: '',
                password: '',
                remember: false,
                loading: false,
                errorMessage: '',
                shakeForm: false,
                async submitLogin() {
                    if (this.loading) return;
                    this.loading = true;
                    this.errorMessage = '';
                    this.shakeForm = false;

                    try {
                        const response = await fetch("{{ route('login') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ email: this.email, password: this.password, remember: this.remember })
                        });
                        const data = await response.json();
                        if (response.ok && data.status === 'success') {
                            window.location.href = data.redirect || '/dashboard';
                        } else {
                            this.loading = false;
                            this.errorMessage = data.message || (data.errors ? Object.values(data.errors).flat()[0] : 'Kredensial tidak valid.');
                            this.triggerShake();
                        }
                    } catch (err) {
                        this.loading = false;
                        this.errorMessage = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                        this.triggerShake();
                    }
                },
                triggerShake() {
                    this.shakeForm = true;
                    setTimeout(() => { this.shakeForm = false; }, 500);
                    // Focus back to email input
                    this.$nextTick(() => { this.$refs.emailInput.focus(); });
                }
            };
        }
    </script>
</x-guest-layout>

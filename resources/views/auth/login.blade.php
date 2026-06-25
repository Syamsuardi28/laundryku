<!DOCTYPE html>
<html lang="id" x-data x-init="$store.theme.init()" :class="{ 'dark': $store.theme.dark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Login ke LaundryKu - Sistem Manajemen Laundry Modern">
    <title>Login - LaundryKu</title>
    
    <!-- Preconnect & Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        
        /* Smooth Fade In Entrance for Card */
        @keyframes fadeInCard {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-card-fade {
            animation: fadeInCard 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="min-h-screen antialiased bg-[#F8FAFC] text-[#111827] dark:bg-slate-950 dark:text-slate-100 flex flex-col justify-center items-center p-4 sm:p-6 transition-colors duration-300">

    <div x-data="loginForm()" class="w-full max-w-[450px] animate-card-fade">
        
        <!-- Header Branding (Outside Card) -->
        <div class="flex flex-col items-center mb-6 select-none">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-[#111827] dark:text-white mt-4">
                Selamat Datang Kembali
            </h1>
            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">
                Masuk untuk mengelola LaundryKu
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-200 dark:border-slate-800 shadow-lg p-6 sm:p-8">
            
            <!-- Inline Validation Error Alert -->
            <div x-show="errorMessage" x-cloak
                 class="mb-5 p-3.5 rounded-xl border border-red-200 bg-red-50 text-xs text-red-800 dark:border-red-900/40 dark:bg-red-950/20 dark:text-red-400 flex items-start gap-2.5">
                <svg class="h-4.5 w-4.5 text-red-600 dark:text-red-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span x-text="errorMessage"></span>
            </div>

            <!-- Login Form -->
            <form @submit.prevent="submitLogin" class="space-y-4" id="form-login">
                
                <!-- Email Field -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                        Email
                    </label>
                    <input type="email" name="email" id="email" x-model="email"
                           placeholder="Masukkan alamat email"
                           class="w-full h-11 px-3.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-850 text-sm text-[#111827] dark:text-white placeholder-gray-400 dark:placeholder-slate-500 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 focus:outline-none transition-colors"
                           required autocomplete="email" :disabled="loading" autofocus>
                </div>

                <!-- Password Field -->
                <div class="space-y-1.5" x-data="{ show: false }">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                            Password
                        </label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                            Lupa Password?
                        </a>
                        @endif
                    </div>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" id="password" x-model="password"
                               placeholder="Masukkan password"
                               class="w-full h-11 pl-3.5 pr-10 rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-850 text-sm text-[#111827] dark:text-white placeholder-gray-400 dark:placeholder-slate-500 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 focus:outline-none transition-colors"
                               required autocomplete="current-password" :disabled="loading">
                        <button type="button" @click="show = !show" :disabled="loading"
                                class="absolute inset-y-0 right-3.5 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-slate-300 transition-colors">
                            <svg x-show="!show" class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="show" x-cloak class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center pt-0.5">
                    <label class="flex items-center gap-2.5 cursor-pointer" for="remember">
                        <input type="checkbox" name="remember" id="remember" x-model="remember" :disabled="loading"
                               class="h-4.5 w-4.5 rounded border-gray-300 bg-white text-blue-600 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800">
                        <span class="text-xs text-gray-600 dark:text-slate-400">Ingat Saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" :disabled="loading"
                            class="w-full h-[48px] inline-flex items-center justify-center gap-2 text-sm font-semibold text-white rounded-xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                        <template x-if="loading">
                            <svg class="animate-spin h-4.5 w-4.5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <span x-text="loading ? 'Sedang masuk...' : 'Masuk'"></span>
                    </button>
                </div>
            </form>

            <!-- Quick Demo Accounts -->
            <div class="mt-6 border-t border-gray-200 dark:border-slate-800 pt-5">
                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-slate-500 mb-2.5">
                    Akun Demo Cepat
                </p>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" @click="fillDemo('admin@laundryku.test', 'password')" :disabled="loading"
                            class="p-2.5 text-left rounded-xl bg-gray-50 hover:bg-gray-100 dark:bg-slate-800/40 dark:hover:bg-slate-800 border border-gray-200 dark:border-slate-800 transition-colors select-none">
                        <p class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400">Admin</p>
                        <p class="text-[10px] text-gray-500 dark:text-slate-400 truncate">admin@laundryku.test</p>
                    </button>
                    <button type="button" @click="fillDemo('petugas@laundryku.test', 'password')" :disabled="loading"
                            class="p-2.5 text-left rounded-xl bg-gray-50 hover:bg-gray-100 dark:bg-slate-800/40 dark:hover:bg-slate-800 border border-gray-200 dark:border-slate-800 transition-colors select-none">
                        <p class="text-[10px] font-bold text-blue-600 dark:text-blue-400">Petugas</p>
                        <p class="text-[10px] text-gray-500 dark:text-slate-400 truncate">petugas@laundryku.test</p>
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer Control: Light/Dark Toggle -->
        <div class="mt-6 flex items-center justify-center">
            <button @click="$store.theme.toggle()" type="button" :disabled="loading"
                    class="flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold text-gray-500 hover:text-gray-900 dark:text-slate-400 dark:hover:text-slate-200 transition-colors select-none">
                <svg x-show="!$store.theme.dark" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <svg x-show="$store.theme.dark" x-cloak class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span x-text="$store.theme.dark ? 'Mode Terang' : 'Mode Gelap'"></span>
            </button>
        </div>
    </div>

    <!-- Alpine.js Form Controller -->
    <script>
        function loginForm() {
            return {
                email: '',
                password: '',
                remember: false,
                loading: false,
                errorMessage: '',

                fillDemo(email, password) {
                    if (this.loading) return;
                    this.email = email;
                    this.password = password;
                    this.errorMessage = '';
                },

                async submitLogin() {
                    if (this.loading) return;
                    this.loading = true;
                    this.errorMessage = '';

                    try {
                        const response = await fetch("{{ route('login') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                email: this.email,
                                password: this.password,
                                remember: this.remember
                            })
                        });

                        const data = await response.json();

                        if (response.ok && data.status === 'success') {
                            // Instant redirection on success for fast login experience
                            window.location.href = data.redirect;
                        } else {
                            this.loading = false;
                            let errorMsg = 'Email atau password salah.';
                            if (data.errors) {
                                errorMsg = Object.values(data.errors).flat()[0];
                            } else if (data.message) {
                                errorMsg = data.message;
                            }
                            this.errorMessage = errorMsg;
                        }
                    } catch (err) {
                        this.loading = false;
                        this.errorMessage = 'Terjadi kesalahan sistem. Silakan coba beberapa saat lagi.';
                    }
                }
            };
        }
    </script>
</body>
</html>

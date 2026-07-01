<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LaundryKu') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Fallback theme init just in case app.js hasn't loaded yet -->
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased text-slate-800 bg-surface dark:bg-surface-dark selection:bg-primary selection:text-white">
        <div x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)"
             x-show="mounted" 
             x-transition:enter="transition ease-out duration-page"
             x-transition:enter-start="opacity-0 translate-y-5"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="min-h-screen">
            {{ $slot }}
        </div>
    </body>
</html>

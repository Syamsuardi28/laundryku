<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LaundryKu') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800 bg-surface dark:bg-surface-dark selection:bg-primary selection:text-white" x-data="{ sidebarOpen: false }">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden scrollbar-thin bg-surface dark:bg-surface-dark">
                <!-- Topbar -->
                @include('layouts.topbar')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white/50 dark:bg-slate-800/50 backdrop-blur-md border-b border-slate-100 dark:border-slate-700 sticky top-0 z-20">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 p-4 sm:p-6 lg:p-8 w-full max-w-7xl mx-auto"
                      x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)"
                      x-show="mounted"
                      x-transition:enter="transition ease-out duration-page"
                      x-transition:enter-start="opacity-0 translate-y-5"
                      x-transition:enter-end="opacity-100 translate-y-0">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>

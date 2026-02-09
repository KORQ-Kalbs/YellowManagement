<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-cloak>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@isset($title) {{ $title }} - @endisset {{ config('app.name', 'Yellow Drink POS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900" x-data="{ theme: localStorage.getItem('theme') || 'light' }" x-init="$watch('theme', val => { localStorage.setItem('theme', val); val === 'dark' ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark'); })" :class="theme === 'dark' && 'dark'">
        <script>
            (function() {
                const theme = localStorage.getItem('theme') || 'light';
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>

        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <x-sidebar />

            <!-- Main Content Area -->
            <div class="flex flex-col ml-64 w-full min-h-screen">
                <!-- Navbar -->
                <x-navbar />

                <!-- Page Content -->
                <main class="flex-1 bg-gray-50 dark:bg-gray-900">
                    @isset($header)
                        <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <div class="px-6 py-8 sm:px-8">
                                {{ $header }}
                            </div>
                        </div>
                    @endisset

                    <div class="px-6 py-8 sm:px-8">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
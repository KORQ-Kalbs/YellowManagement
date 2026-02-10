<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        
        <!-- Theme initialization script (prevents flash) -->
        <script>
            (function() {
                const theme = localStorage.getItem('theme') || 'light';
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 overflow-x-hidden" 
          x-data="{ 
              sidebarOpen: window.innerWidth >= 1024,
              theme: localStorage.getItem('theme') || 'light' 
          }" 
          x-init="
              $watch('theme', val => { 
                  localStorage.setItem('theme', val); 
                  if (val === 'dark') {
                      document.documentElement.classList.add('dark');
                  } else {
                      document.documentElement.classList.remove('dark');
                  }
              });
              window.addEventListener('resize', () => {
                  if (window.innerWidth >= 1024) {
                      sidebarOpen = true;
                  }
              });
          ">
        
        <div class="flex min-h-screen max-w-full overflow-x-hidden">
            <!-- Sidebar -->
            <x-sidebar />

            <!-- Main Content Area -->
            <div class="flex flex-col w-full min-h-screen transition-all duration-300 lg:ml-0"
                 :class="sidebarOpen && window.innerWidth >= 1024 ? 'lg:ml-64' : 'lg:ml-20'">
                <!-- Navbar -->
                <x-navbar />

                <!-- Page Content -->
                <main class="flex-1 bg-gray-50 dark:bg-gray-900 w-full overflow-x-hidden">
                    @isset($header)
                        <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <div class="px-4 py-6 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </div>
                    @endisset

                    <div class="px-4 py-6 sm:px-6 lg:px-8 w-full">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen && window.innerWidth < 1024" 
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
             style="display: none;">
        </div>
    </body>
</html>
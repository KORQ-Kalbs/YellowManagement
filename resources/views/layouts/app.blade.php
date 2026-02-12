<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@isset($title) {{ $title }} - @endisset {{ config('app.name', 'Yellow Drink POS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

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
            <!-- Sidebar - Hidden on Mobile -->
            <div class="hidden lg:block fixed top-0 left-0 z-50 h-full">
                <x-sidebar />
            </div>

            <!-- Main Content Area -->
            <div class="flex flex-col w-full min-h-screen transition-all duration-300 lg:ml-0"
                 :class="sidebarOpen && window.innerWidth >= 1024 ? 'lg:ml-64' : 'lg:ml-20'">
                <!-- Navbar -->
                <x-navbar />

                <!-- Page Content -->
                <main class="flex-1 bg-gray-50 dark:bg-gray-900 w-full overflow-x-hidden pb-16 lg:pb-0">
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

        <!-- Mobile Bottom Navigation -->
        <nav class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 lg:hidden">
            <div class="grid grid-cols-5 h-16">
                @if(auth()->user()->role === 'admin')
                    <!-- Admin Bottom Nav -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex flex-col items-center justify-center space-y-1 {{ Request::routeIs('admin.dashboard') ? 'text-yellow-500' : 'text-gray-600 dark:text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="text-xs">Home</span>
                    </a>
                    
                    <a href="{{ route('admin.products.index') }}" 
                       class="flex flex-col items-center justify-center space-y-1 {{ Request::routeIs('admin.products.*') ? 'text-yellow-500' : 'text-gray-600 dark:text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span class="text-xs">Products</span>
                    </a>
                    
                    <a href="{{ route('admin.pos') }}" 
                       class="flex flex-col items-center justify-center -mt-4">
                        <div class="flex items-center justify-center w-14 h-14 bg-yellow-500 rounded-full shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs text-yellow-500 mt-1">POS</span>
                    </a>
                    
                    <a href="{{ route('admin.kasir.index') }}" 
                       class="flex flex-col items-center justify-center space-y-1 {{ Request::routeIs('admin.kasir.*') ? 'text-yellow-500' : 'text-gray-600 dark:text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="text-xs">Kasir</span>
                    </a>
                    
                    <a href="{{ route('admin.reports.index') }}" 
                       class="flex flex-col items-center justify-center space-y-1 {{ Request::routeIs('admin.reports.*') ? 'text-yellow-500' : 'text-gray-600 dark:text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="text-xs">Reports</span>
                    </a>
                @else
                    <!-- Kasir Bottom Nav -->
                    <a href="{{ route('kasir.dashboard') }}" 
                       class="flex flex-col items-center justify-center space-y-1 {{ Request::routeIs('kasir.dashboard') ? 'text-yellow-500' : 'text-gray-600 dark:text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="text-xs">Home</span>
                    </a>
                    
                    <a href="{{ route('kasir.transaksi.index') }}" 
                       class="flex flex-col items-center justify-center space-y-1 {{ Request::routeIs('kasir.transaksi.*') ? 'text-yellow-500' : 'text-gray-600 dark:text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span class="text-xs">History</span>
                    </a>
                    
                    <a href="{{ route('kasir.pos') }}" 
                       class="flex flex-col items-center justify-center -mt-4">
                        <div class="flex items-center justify-center w-14 h-14 bg-yellow-500 rounded-full shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs text-yellow-500 mt-1">POS</span>
                    </a>
                    
                    <a href="{{ route('kasir.reports.index') }}" 
                       class="flex flex-col items-center justify-center space-y-1 {{ Request::routeIs('kasir.reports.*') ? 'text-yellow-500' : 'text-gray-600 dark:text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="text-xs">Reports</span>
                    </a>
                    
                    <a href="{{ route('profile') }}" 
                       class="flex flex-col items-center justify-center space-y-1 {{ Request::routeIs('profile') ? 'text-yellow-500' : 'text-gray-600 dark:text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-xs">Profile</span>
                    </a>
                @endif
            </div>
        </nav>

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
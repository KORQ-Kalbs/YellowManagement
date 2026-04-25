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
    <body class="font-sans antialiased app-shell-bg app-text overflow-x-hidden" 
          x-data="{ 
              sidebarOpen: window.innerWidth >= 1024,
              theme: localStorage.getItem('theme') || 'light',
              sidebarWidth: localStorage.getItem('sidebarWidth') || 224,
              isResizing: false
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
                  } else {
                      sidebarOpen = false;
                  }
              });
              
              // Handle sidebar resizing
              document.addEventListener('mousemove', (e) => {
                  if (isResizing) {
                      let newWidth = e.clientX;
                      if (newWidth >= 180 && newWidth <= 400) {
                          sidebarWidth = newWidth;
                      }
                  }
              });
              
              document.addEventListener('mouseup', () => {
                  if (isResizing) {
                      isResizing = false;
                      document.body.style.cursor = '';
                      document.body.style.userSelect = '';
                  }
              });
          ">
        
        <div class="flex min-h-screen max-w-full overflow-x-hidden">
            <!-- Sidebar - Hidden on Mobile -->
            <x-sidebar />

            <!-- Main Content Area -->
            <div class="flex flex-col w-full min-h-screen lg:ml-56"
                 :style="sidebarOpen && window.innerWidth >= 1024 ? `margin-left: ${sidebarWidth}px` : (window.innerWidth >= 1024 ? 'margin-left: 80px' : '')">
                <!-- Navbar -->
                <x-navbar />

                <!-- Page Content -->
                <main class="flex-1 app-shell-bg w-full overflow-x-hidden pb-16 lg:pb-0">
                    @isset($header)
                        <div class="app-surface border-b app-border">
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
        <nav class="fixed bottom-0 left-0 right-0 z-50 app-surface border-t app-border lg:hidden"
             x-data="{ moreMenuOpen: false }">
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
                       class="flex flex-col items-center justify-center space-y-1 {{ Request::routeIs('admin.products.*', 'admin.kategoris.*') ? 'text-yellow-500' : 'text-gray-600 dark:text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span class="text-xs">Inventory</span>
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
                    
                    <a href="{{ route('admin.transaksi.index') }}" 
                       class="flex flex-col items-center justify-center space-y-1 {{ Request::routeIs('admin.transaksi.*') ? 'text-yellow-500' : 'text-gray-600 dark:text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span class="text-xs">History</span>
                    </a>
                    
                    <button @click="moreMenuOpen = !moreMenuOpen"
                            class="flex flex-col items-center justify-center space-y-1 {{ Request::routeIs('admin.reports.*', 'admin.kasir.*') ? 'text-yellow-500' : 'text-gray-600 dark:text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span class="text-xs">More</span>
                    </button>
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
            
            <!-- Admin More Menu Modal -->
            @if(auth()->user()->role === 'admin')
                <div x-show="moreMenuOpen" 
                     @click.away="moreMenuOpen = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-4"
                     class="absolute bottom-16 left-0 right-0 app-surface border-t app-border shadow-lg"
                     style="display: none;">
                    <div class="grid grid-cols-2 gap-2 p-4">
                        <!-- Reports -->
                        <a href="{{ route('admin.reports.index') }}" 
                           @click="moreMenuOpen = false"
                           class="flex flex-col items-center justify-center p-4 rounded-lg transition-colors {{ Request::routeIs('admin.reports.*') ? 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400' : 'bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600' }}">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span class="text-sm font-medium">Reports</span>
                        </a>
                        
                        <!-- Kasir Management -->
                        <a href="{{ route('admin.kasir.index') }}" 
                           @click="moreMenuOpen = false"
                           class="flex flex-col items-center justify-center p-4 rounded-lg transition-colors {{ Request::routeIs('admin.kasir.*') ? 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400' : 'bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600' }}">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span class="text-sm font-medium">Kasir</span>
                        </a>
                        
                        <!-- Categories -->
                        <a href="{{ route('admin.kategoris.index') }}" 
                           @click="moreMenuOpen = false"
                           class="flex flex-col items-center justify-center p-4 rounded-lg transition-colors {{ Request::routeIs('admin.kategoris.*') ? 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400' : 'bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600' }}">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <span class="text-sm font-medium">Categories</span>
                        </a>

                        <!-- Dashboard Settings -->
                        <a href="{{ route('admin.dashboard-setting.index') }}" 
                           @click="moreMenuOpen = false"
                           class="flex flex-col items-center justify-center p-4 rounded-lg transition-colors {{ Request::routeIs('admin.dashboard-setting.*') ? 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400' : 'bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600' }}">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3.75a2.25 2.25 0 013 0l.5.5a2.25 2.25 0 003.182 0l.5-.5a2.25 2.25 0 013 3l-.5.5a2.25 2.25 0 000 3.182l.5.5a2.25 2.25 0 01-3 3l-.5-.5a2.25 2.25 0 00-3.182 0l-.5.5a2.25 2.25 0 01-3-3l.5-.5a2.25 2.25 0 000-3.182l-.5-.5a2.25 2.25 0 010-3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" />
                            </svg>
                            <span class="text-sm font-medium">Dashboard Settings</span>
                        </a>
                        
                        <!-- Profile -->
                        <a href="{{ route('profile') }}" 
                           @click="moreMenuOpen = false"
                           class="flex flex-col items-center justify-center p-4 rounded-lg transition-colors {{ Request::routeIs('profile') ? 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400' : 'bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600' }}">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-sm font-medium">Profile</span>
                        </a>
                    </div>
                </div>
            @endif
        </nav>


    </body>
</html>
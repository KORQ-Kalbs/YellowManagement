<aside 
    :class="sidebarOpen ? '' : 'w-20'"
    :style="sidebarOpen ? `width: ${sidebarWidth}px` : ''"
    style="font-family: 'Montserrat', sans-serif;"
    class="fixed top-0 left-0 z-50 h-full transition-all duration-200 ease-linear shadow-xl bg-gradient-to-b from-yellow-400 via-yellow-500 to-orange-500"
    x-data="{
        /* Dropdown states commented out - restore if needed
        productsOpen: {{ Request::routeIs('admin.products.*', 'admin.kategoris.*') ? 'true' : 'false' }},
        posOpen: {{ Request::routeIs('admin.pos', 'kasir.pos') ? 'true' : 'false' }},
        adminReportsOpen: {{ Request::routeIs('admin.reports.*') ? 'true' : 'false' }},
        kasirReportsOpen: {{ Request::routeIs('kasir.reports.*') ? 'true' : 'false' }}
        */
    }"
    x-init="
        sidebarWidth = localStorage.getItem('sidebarWidth') || 256;
        $watch('sidebarWidth', value => localStorage.setItem('sidebarWidth', value));
    ">
    
    <!-- Resize Handle -->
    <div x-show="sidebarOpen"
         @mousedown="
            isResizing = true;
            document.body.style.cursor = 'ew-resize';
            document.body.style.userSelect = 'none';
         "
         class="absolute top-0 right-0 w-1 h-full cursor-ew-resize hover:bg-yellow-600 transition-colors group">
        <div class="absolute top-1/2 right-0 transform translate-x-1/2 -translate-y-1/2 w-3 h-12 bg-yellow-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
    </div>
    
    <!-- Logo Section -->
    <div class="flex items-center justify-between" :class="sidebarOpen ? 'p-4' : 'py-4 px-2'">
        <div class="flex items-center min-w-0 space-x-3 overflow-hidden">
            <div class="flex items-center justify-center flex-shrink-0 w-9 h-9 bg-white rounded-lg shadow-md">
                <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
            </div>
            <div x-show="sidebarOpen" x-transition class="overflow-hidden whitespace-nowrap">
                <h1 class="text-[14px] font-semibold leading-[1.5] text-white truncate">Yellow Drink</h1>
                <p class="text-[12px] font-medium leading-[1.5] text-yellow-100">Money Manage</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 py-2 space-y-1 overflow-y-auto h-[calc(100vh-200px)]" :class="sidebarOpen ? 'px-4' : 'px-2'">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" 
           @class([
               'flex items-center p-2 rounded-md transition-all duration-200 gap-2 text-[14px] leading-[1.5] text-white group',
               'font-semibold bg-white bg-opacity-20 shadow-lg' => Request::routeIs('dashboard'),
               'font-medium hover:bg-white hover:bg-opacity-10' => !Request::routeIs('dashboard')
           ])
           :title="!sidebarOpen ? 'Dashboard' : ''">
            <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Dashboard</span>
        </a>

        @if(auth()->user()->role === 'admin')
            <!-- All Sales Section -->
            <div x-show="sidebarOpen" x-transition class="px-2 mt-4 mb-2 text-[11px] font-bold tracking-wider text-white/70 uppercase">
                All Sales
            </div>

            <!-- POS -->
            <a href="{{ route('admin.pos') }}" 
               @class([
                   'flex items-center p-2 rounded-md transition-all duration-200 gap-2 text-[14px] leading-[1.5] text-white group',
                   'font-semibold bg-white bg-opacity-20 shadow-lg' => Request::routeIs('admin.pos'),
                   'font-medium hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.pos')
               ])
               :title="!sidebarOpen ? 'POS' : ''">
                <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Penjualan</span>
            </a>

            <!-- Transactions -->
            <a href="{{ route('admin.transaksi.index') }}" 
               @class([
                   'flex items-center p-2 rounded-md transition-all duration-200 gap-2 text-[14px] leading-[1.5] text-white group',
                   'font-semibold bg-white bg-opacity-20 shadow-lg' => Request::routeIs('admin.transaksi.*'),
                   'font-medium hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.transaksi.*')
               ])
               :title="!sidebarOpen ? 'Transactions' : ''">
                <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Histori</span>
            </a>

            <!-- Reports -->
            <a href="{{ route('admin.reports.index') }}" 
               @class([
                   'flex items-center p-2 rounded-md transition-all duration-200 gap-2 text-[14px] leading-[1.5] text-white group',
                   'font-semibold bg-white bg-opacity-20 shadow-lg' => Request::routeIs('admin.reports.*'),
                   'font-medium hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.reports.*')
               ])
               :title="!sidebarOpen ? 'Reports' : ''">
                <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Laporan</span>
            </a>

            <!-- All Data Section -->
            <div x-show="sidebarOpen" x-transition class="px-2 mt-4 mb-2 text-[11px] font-bold tracking-wider text-white/70 uppercase">
                All Data
            </div>

            <!-- Products -->
            <a href="{{ route('admin.products.index') }}" 
               @class([
                   'flex items-center p-2 rounded-md transition-all duration-200 gap-2 text-[14px] leading-[1.5] text-white group',
                   'font-semibold bg-white bg-opacity-20 shadow-lg' => Request::routeIs('admin.products.*'),
                   'font-medium hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.products.*')
               ])
               :title="!sidebarOpen ? 'Products' : ''">
                <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Data Produk</span>
            </a>

            <!-- Categories -->
            <a href="{{ route('admin.kategoris.index') }}" 
               @class([
                   'flex items-center p-2 rounded-md transition-all duration-200 gap-2 text-[14px] leading-[1.5] text-white group',
                   'font-semibold bg-white bg-opacity-20 shadow-lg' => Request::routeIs('admin.kategoris.*'),
                   'font-medium hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.kategoris.*')
               ])
               :title="!sidebarOpen ? 'Categories' : ''">
                <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Data Kategori</span>
            </a>

            <!-- Event Diskon -->
            <a href="{{ route('admin.event-diskon.index') }}" 
               @class([
                   'flex items-center p-2 rounded-md transition-all duration-200 gap-2 text-[14px] leading-[1.5] text-white group',
                   'font-semibold bg-white bg-opacity-20 shadow-lg' => Request::routeIs('admin.event-diskon.*'),
                   'font-medium hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.event-diskon.*')
               ])
               :title="!sidebarOpen ? 'Event Diskon' : ''">
                <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                </svg>
                <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Event Diskon</span>
            </a>

            <!-- Kasir Management -->
            <a href="{{ route('admin.kasir.index') }}" 
               @class([
                   'flex items-center p-2 rounded-md transition-all duration-200 gap-2 text-[14px] leading-[1.5] text-white group',
                   'font-semibold bg-white bg-opacity-20 shadow-lg' => Request::routeIs('admin.kasir.*'),
                   'font-medium hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.kasir.*')
               ])
               :title="!sidebarOpen ? 'Kasir Management' : ''">
                <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Data Karyawan</span>
            </a>

        @elseif(auth()->user()->role === 'kasir')
            <!-- All Sales Section -->
            <div x-show="sidebarOpen" x-transition class="px-2 mt-4 mb-2 text-[11px] font-bold tracking-wider text-white/70 uppercase">
                All Sales
            </div>

            <!-- POS -->
            <a href="{{ route('kasir.pos') }}" 
               @class([
                   'flex items-center p-2 rounded-md transition-all duration-200 gap-2 text-[14px] leading-[1.5] text-white group',
                   'font-semibold bg-white bg-opacity-20 shadow-lg' => Request::routeIs('kasir.pos'),
                   'font-medium hover:bg-white hover:bg-opacity-10' => !Request::routeIs('kasir.pos')
               ])
               :title="!sidebarOpen ? 'POS' : ''">
                <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Penjualan</span>
            </a>

            <!-- Transactions -->
            <a href="{{ route('kasir.transaksi.index') }}" 
               @class([
                   'flex items-center p-2 rounded-md transition-all duration-200 gap-2 text-[14px] leading-[1.5] text-white group',
                   'font-semibold bg-white bg-opacity-20 shadow-lg' => Request::routeIs('kasir.transaksi.*'),
                   'font-medium hover:bg-white hover:bg-opacity-10' => !Request::routeIs('kasir.transaksi.*')
               ])
               :title="!sidebarOpen ? 'Transactions' : ''">
                <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Histori</span>
            </a>

            <!-- Reports -->
            <a href="{{ route('kasir.reports.index') }}" 
               @class([
                   'flex items-center p-2 rounded-md transition-all duration-200 gap-2 text-[14px] leading-[1.5] text-white group',
                   'font-semibold bg-white bg-opacity-20 shadow-lg' => Request::routeIs('kasir.reports.*'),
                   'font-medium hover:bg-white hover:bg-opacity-10' => !Request::routeIs('kasir.reports.*')
               ])
               :title="!sidebarOpen ? 'Reports' : ''">
                <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Laporan</span>
            </a>
        @endif
    </nav>

    <!-- User Profile Section (Bottom) -->
    <div x-data="{ profileModalOpen: false }">
        <!-- Theme Toggle -->
        <div class="py-2" :class="sidebarOpen ? 'px-4' : 'px-2'">
            <button @click="theme = theme === 'dark' ? 'light' : 'dark'" 
                    class="flex items-center w-full p-2 gap-2 text-[14px] leading-[1.5] font-medium text-white transition-all duration-200 rounded-md hover:bg-white hover:bg-opacity-10"
                    :title="!sidebarOpen ? 'Toggle Theme' : ''">
                <svg class="flex-shrink-0 w-4 h-4" x-show="theme === 'light'" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg class="flex-shrink-0 w-4 h-4" x-show="theme === 'dark'" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.707.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm5.657-9.193a1 1 0 00-1.414 0l-.707.707A1 1 0 005.05 6.464l.707-.707a1 1 0 011.414 0zM5 8a1 1 0 100-2H4a1 1 0 100 2h1z" clip-rule="evenodd"></path>
                </svg>
                <span x-show="sidebarOpen" x-transition class="whitespace-nowrap" x-text="theme === 'dark' ? 'Light Mode' : 'Dark Mode'"></span>
            </button>
        </div>

        <!-- User Profile Button -->
        <div class="pb-4" :class="sidebarOpen ? 'px-4' : 'px-2'">
            <button @click="profileModalOpen = true" 
                    class="flex items-center w-full p-2 gap-2 text-white transition-all duration-200 rounded-md hover:bg-white hover:bg-opacity-10"
                    :class="sidebarOpen ? '' : 'justify-center'">
                <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 text-[14px] font-bold text-yellow-500 bg-white rounded-full">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                </div>
                <div x-show="sidebarOpen" x-transition class="flex-1 min-w-0 text-left">
                    <p class="text-[14px] font-semibold leading-[1.5] text-white truncate">{{ auth()->user()?->name ?? 'User' }}</p>
                    <p class="text-[12px] font-medium leading-[1.5] text-yellow-100 truncate">{{ ucfirst(auth()->user()?->role ?? 'guest') }}</p>
                </div>
                <svg x-show="sidebarOpen" class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </button>
        </div>

        <!-- Profile Modal -->
        <div x-show="profileModalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
             @click.self="profileModalOpen = false"
             style="display: none;">
            <div x-show="profileModalOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md mx-4 overflow-hidden">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-yellow-400 to-orange-500">
                    <h3 class="text-lg font-semibold text-white">User Settings</h3>
                    <button @click="profileModalOpen = false" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <!-- User Info -->
                    <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-center w-16 h-16 text-2xl font-bold text-white bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full">
                            {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ auth()->user()?->name ?? 'User' }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ auth()->user()?->email ?? 'user@example.com' }}</p>
                            <span class="inline-block mt-1 px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-200">
                                {{ ucfirst(auth()->user()?->role ?? 'guest') }}
                            </span>
                        </div>
                    </div>

                    <!-- Menu Items -->
                    <div class="space-y-2">
                        <a href="{{ route('profile') }}" 
                           @click="profileModalOpen = false"
                           class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="font-medium">Edit Profile</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-3 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span class="font-medium">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>

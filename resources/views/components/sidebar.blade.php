<aside 
    :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="fixed top-0 left-0 z-50 h-full transition-all duration-300 shadow-xl bg-gradient-to-b from-yellow-400 via-yellow-500 to-orange-500"
    :style="window.innerWidth < 1024 && !sidebarOpen ? 'transform: translateX(-100%)' : ''"
    x-data="{
        productsOpen: {{ Request::routeIs('admin.products.*', 'admin.kategoris.*') ? 'true' : 'false' }},
        posOpen: {{ Request::routeIs('admin.pos', 'kasir.pos') ? 'true' : 'false' }},
        adminReportsOpen: {{ Request::routeIs('admin.reports.*') ? 'true' : 'false' }},
        kasirReportsOpen: {{ Request::routeIs('kasir.reports.*') ? 'true' : 'false' }}
    }">
    
    <!-- Logo Section -->
    <div class="flex items-center justify-between p-4 border-b border-yellow-600 lg:p-6">
        <div class="flex items-center min-w-0 space-x-3 overflow-hidden">
            <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-white rounded-lg shadow-md lg:w-10 lg:h-10">
                <svg class="w-5 h-5 text-yellow-500 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
            </div>
            <div x-show="sidebarOpen" x-transition class="overflow-hidden whitespace-nowrap">
                <h1 class="text-base font-bold text-white truncate lg:text-lg">Yellow Drink</h1>
                <p class="text-xs text-yellow-100">POS System</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-2 lg:px-4 py-4 lg:py-6 space-y-1 lg:space-y-2 overflow-y-auto h-[calc(100vh-200px)]">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" 
           @class([
               'flex items-center px-4 py-3 rounded-lg font-medium transition-all duration-200 space-x-3 text-white group',
               'bg-white bg-opacity-20 shadow-lg' => Request::routeIs('dashboard'),
               'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('dashboard')
           ])
           :title="!sidebarOpen ? 'Dashboard' : ''">
            <svg class="flex-shrink-0 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Dashboard</span>
        </a>

        @if(auth()->user()->role === 'admin')
            <!-- Admin Section Label -->
            <div x-show="sidebarOpen" x-transition class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold tracking-wider text-yellow-100 uppercase">Admin</p>
            </div>

            <!-- Products & Categories Dropdown -->
            <div>
                <button @click="productsOpen = !productsOpen"
                   @class([
                       'w-full flex items-center px-4 py-3 rounded-lg font-medium transition-all duration-200 space-x-3 text-white group',
                       'bg-white bg-opacity-20 shadow-lg' => Request::routeIs('admin.products.*', 'admin.kategoris.*'),
                       'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.products.*', 'admin.kategoris.*')
                   ])
                   :title="!sidebarOpen ? 'Inventory' : ''">
                    <svg class="flex-shrink-0 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="flex-1 text-left whitespace-nowrap">Inventory</span>
                    <svg x-show="sidebarOpen" :class="productsOpen && 'rotate-180'" class="flex-shrink-0 w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                </button>
                
                <!-- Dropdown Items -->
                <div x-show="productsOpen" x-transition class="mt-1 ml-4 space-y-1">
                    <!-- Products -->
                    <a href="{{ route('admin.products.index') }}" 
                       @class([
                           'flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 space-x-3 text-white',
                           'bg-white bg-opacity-20' => Request::routeIs('admin.products.*'),
                           'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.products.*')
                       ])>
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition>Products</span>
                    </a>

                    <!-- Categories -->
                    <a href="{{ route('admin.kategoris.index') }}" 
                       @class([
                           'flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 space-x-3 text-white',
                           'bg-white bg-opacity-20' => Request::routeIs('admin.kategoris.*'),
                           'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.kategoris.*')
                       ])>
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition>Categories</span>
                    </a>
                </div>
            </div>

            <!-- POS Dropdown -->
            <div>
                <button @click="posOpen = !posOpen"
                   @class([
                       'w-full flex items-center px-4 py-3 rounded-lg font-medium transition-all duration-200 space-x-3 text-white group',
                       'bg-white bg-opacity-20 shadow-lg' => Request::routeIs('admin.pos', 'admin.reports.*'),
                       'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.pos', 'admin.reports.*')
                   ])
                   :title="!sidebarOpen ? 'POS' : ''">
                    <svg class="flex-shrink-0 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="flex-1 text-left whitespace-nowrap">POS</span>
                    <svg x-show="sidebarOpen" :class="posOpen && 'rotate-180'" class="flex-shrink-0 w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                </button>
                
                <!-- Dropdown Items -->
                <div x-show="posOpen" x-transition class="mt-1 ml-4 space-y-1">
                    <a href="{{ route('admin.pos') }}" 
                       @class([
                           'flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 space-x-3 text-white',
                           'bg-white bg-opacity-20' => Request::routeIs('admin.pos'),
                           'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.pos')
                       ])>
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition>POS</span>
                    </a>
                    <a href="{{ route('admin.reports.index') }}" 
                       @class([
                           'flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 space-x-3 text-white',
                           'bg-white bg-opacity-20' => Request::routeIs('admin.reports.*'),
                           'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.reports.*')
                       ])>
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition>Reports</span>
                    </a>
                </div>
            </div>

            <!-- Kasir Management -->
            <a href="{{ route('admin.kasir.index') }}" 
               @class([
                   'flex items-center px-4 py-3 rounded-lg font-medium transition-all duration-200 space-x-3 text-white group',
                   'bg-white bg-opacity-20 shadow-lg' => Request::routeIs('admin.kasir.*'),
                   'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.kasir.*')
               ])
               :title="!sidebarOpen ? 'Kasir Management' : ''">
                <svg class="flex-shrink-0 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Kasir Management</span>
            </a>

        @elseif(auth()->user()->role === 'kasir')
            <!-- Kasir Section Label -->
            <div x-show="sidebarOpen" x-transition class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold tracking-wider text-yellow-100 uppercase">Kasir</p>
            </div>

            <!-- POS Dropdown -->
            <div>
                <button @click="posOpen = !posOpen"
                   @class([
                       'w-full flex items-center px-4 py-3 rounded-lg font-medium transition-all duration-200 space-x-3 text-white group',
                       'bg-white bg-opacity-20 shadow-lg' => Request::routeIs('kasir.pos', 'kasir.transaksi.*', 'kasir.reports.*'),
                       'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('kasir.pos', 'kasir.transaksi.*', 'kasir.reports.*')
                   ])
                   :title="!sidebarOpen ? 'POS' : ''">
                    <svg class="flex-shrink-0 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="flex-1 text-left whitespace-nowrap">POS</span>
                    <svg x-show="sidebarOpen" :class="posOpen && 'rotate-180'" class="flex-shrink-0 w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                </button>
                
                <!-- Dropdown Items -->
                <div x-show="posOpen" x-transition class="mt-1 ml-4 space-y-1">
                    <a href="{{ route('kasir.pos') }}" 
                       @class([
                           'flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 space-x-3 text-white',
                           'bg-white bg-opacity-20' => Request::routeIs('kasir.pos'),
                           'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('kasir.pos')
                       ])>
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition>Point of Sale</span>
                    </a>
                    
                    <!-- Transactions -->
                    <a href="{{ route('kasir.transaksi.index') }}" 
                       @class([
                           'flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 space-x-3 text-white',
                           'bg-white bg-opacity-20' => Request::routeIs('kasir.transaksi.*'),
                           'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('kasir.transaksi.*')
                       ])>
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition>Transaction History</span>
                    </a>

                    <!-- Reports -->
                    <a href="{{ route('kasir.reports.index') }}" 
                       @class([
                           'flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 space-x-3 text-white',
                           'bg-white bg-opacity-20' => Request::routeIs('kasir.reports.*'),
                           'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('kasir.reports.*')
                       ])>
                        <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition>Reports</span>
                    </a>
                </div>
            </div>
        @endif
    </nav>

    <!-- User Profile Section (Bottom) -->
    <div class="p-4 bg-white border-t border-yellow-600 bg-opacity-10">
        <div class="flex items-center" :class="sidebarOpen ? 'space-x-3' : 'justify-center'">
            <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 text-sm font-bold text-yellow-500 bg-white rounded-full">
                {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
            </div>
            <div x-show="sidebarOpen" x-transition class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ auth()->user()?->name ?? 'User' }}</p>
                <p class="text-xs text-yellow-100 truncate">{{ ucfirst(auth()->user()?->role ?? 'guest') }}</p>
            </div>
        </div>
    </div>
</aside>

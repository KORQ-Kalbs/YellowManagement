@props(['active' => false])

<aside class="fixed left-0 top-0 h-full w-64 bg-gradient-to-b from-yellow-400 via-yellow-500 to-orange-500 shadow-xl z-50">
    <!-- Logo Section -->
    <div class="p-6 border-b border-yellow-600">
        <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg shadow-md">
                <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold text-white">Yellow Drink</h1>
                <p class="text-xs text-yellow-100">POS System</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" @class(['flex items-center px-4 py-3 rounded-lg font-medium transition-all duration-200 space-x-3 text-white', 'bg-white bg-opacity-20 shadow-lg' => Request::routeIs('dashboard'), 'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('dashboard')])>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- Transactions -->
        <a href="{{ route('admin.transaksi.index') }}" @class(['flex items-center px-4 py-3 rounded-lg font-medium transition-all duration-200 space-x-3 text-white', 'bg-white bg-opacity-20 shadow-lg' => Request::routeIs('admin.transaksi.*'), 'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.transaksi.*')])>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span>Transactions</span>
        </a>

        <!-- Products -->
        <a href="{{ route('admin.products.index') }}" @class(['flex items-center px-4 py-3 rounded-lg font-medium transition-all duration-200 space-x-3 text-white', 'bg-white bg-opacity-20 shadow-lg' => Request::routeIs('admin.products.*'), 'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.products.*')])>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <span>Products</span>
        </a>

        <!-- Categories -->
        <a href="{{ route('admin.kategoris.index') }}" @class(['flex items-center px-4 py-3 rounded-lg font-medium transition-all duration-200 space-x-3 text-white', 'bg-white bg-opacity-20 shadow-lg' => Request::routeIs('admin.kategoris.*'), 'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.kategoris.*')])>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            <span>Categories</span>
        </a>

        <!-- Units -->
        <a href="{{ route('admin.units.index') }}" @class(['flex items-center px-4 py-3 rounded-lg font-medium transition-all duration-200 space-x-3 text-white', 'bg-white bg-opacity-20 shadow-lg' => Request::routeIs('admin.units.*'), 'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.units.*')])>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2V3m-6 14l2 2m0 0l2-2m-2 2V8" />
            </svg>
            <span>Units</span>
        </a>

        <!-- Reports -->
        <a href="{{ route('admin.reports.index') }}" @class(['flex items-center px-4 py-3 rounded-lg font-medium transition-all duration-200 space-x-3 text-white', 'bg-white bg-opacity-20 shadow-lg' => Request::routeIs('admin.reports.*'), 'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.reports.*')])>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <span>Reports</span>
        </a>

        <!-- Settings -->
        <a href="{{ route('admin.settings.index') }}" @class(['flex items-center px-4 py-3 rounded-lg font-medium transition-all duration-200 space-x-3 text-white', 'bg-white bg-opacity-20 shadow-lg' => Request::routeIs('admin.settings.*'), 'hover:bg-white hover:bg-opacity-10' => !Request::routeIs('admin.settings.*')])>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Settings</span>
        </a>
    </nav>

    <!-- User Profile Section (Bottom) -->
    <div class="p-4 border-t border-yellow-600 bg-white bg-opacity-10">
        <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-white text-yellow-500 font-bold text-sm">
                {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ auth()->user()?->name ?? 'User' }}</p>
                <p class="text-xs text-yellow-100 truncate">{{ ucfirst(auth()->user()?->role ?? 'guest') }}</p>
            </div>
        </div>
    </div>
</aside>

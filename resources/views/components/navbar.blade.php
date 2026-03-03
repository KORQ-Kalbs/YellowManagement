@props(['title' => null])

<nav class="flex items-center justify-between px-4 py-3 lg:px-6 lg:py-4 bg-white dark:bg-gray-800 sticky top-0 z-30 w-full">
    <!-- Left: Sidebar Toggle & Breadcrumb -->
    <div class="flex items-center space-x-3 min-w-0 flex-1">
        <!-- Sidebar Toggle Button -->
        <button @click="sidebarOpen = !sidebarOpen" 
            class="p-2 transition-colors bg-gray-100 rounded-lg dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 flex-shrink-0"
            title="Toggle Sidebar">
            <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        
        <!-- Breadcrumb / Page Info -->
        <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
            @if(auth()->user()->role === 'admin')
                <span style="font-size: 14px;">Admin</span>
            @else
                <span style="font-size: 14px;">Kasir</span>
            @endif
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="font-bold text-gray-900 dark:text-white truncate" style="font-size: 14px;">
                @if(Request::routeIs('dashboard', 'admin.dashboard', 'kasir.dashboard'))
                    Dashboard
                @elseif(Request::routeIs('admin.products.*'))
                    Data Produk
                @elseif(Request::routeIs('admin.kategoris.*'))
                    Data Kategori
                @elseif(Request::routeIs('admin.pos', 'kasir.pos'))
                    Penjualan
                @elseif(Request::routeIs('admin.transaksi.*', 'kasir.transaksi.*'))
                    Histori Transaksi
                @elseif(Request::routeIs('admin.reports.*', 'kasir.reports.*'))
                    Laporan
                @elseif(Request::routeIs('admin.kasir.*'))
                    Data Karyawan
                @elseif(Request::routeIs('profile'))
                    Profile
                @else
                    {{ $title ?? 'Page' }}
                @endif
            </span>
        </div>
    </div>
</nav>

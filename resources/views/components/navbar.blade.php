@props(['title' => null])

<nav class="flex items-center justify-between px-3 py-3 lg:px-6 lg:py-4 app-surface sticky top-0 z-30 w-full shadow-sm dark:shadow-md border-b app-border">
    <!-- Left: Sidebar Toggle & Breadcrumb -->
    <div class="flex items-center flex-1 min-w-0 space-x-2 lg:space-x-3">
        <!-- Mobile Logo -->
        <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-lg lg:hidden bg-gradient-to-br">
            <img src="{{ asset('img/yellowlogosblack.png') }}" alt="Yellow Drink" width="60" height="60" class="object-contain w-15 h-15 dark:hidden">
            <img src="{{ asset('img/yellowlogoswhite.png') }}" alt="Yellow Drink" width="60" height="60" class="hidden object-contain w-15 h-15 dark:block">
        </div>

        <!-- Sidebar Toggle Button -->
        <button @click="sidebarOpen = !sidebarOpen"
            class="hidden lg:flex p-2 transition-colors rounded-lg app-surface app-hover flex-shrink-0 border app-border"
            title="Toggle Sidebar">
            <svg class="w-5 h-5 app-text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Breadcrumb / Page Info -->
        <div class="flex items-center space-x-2 app-text min-w-0">
            @if(auth()->user()->role === 'admin')
                <span style="font-size: 13px;" class="app-muted font-medium">Admin</span>
            @else
                <span style="font-size: 13px;" class="app-muted font-medium">Kasir</span>
            @endif
            <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="font-semibold app-text truncate min-w-0" style="font-size: 13px;">
                @if(Request::routeIs('dashboard', 'admin.dashboard', 'kasir.dashboard'))
                    Dashboard
                <!-- Sales -->
                @elseif(Request::routeIs('admin.pos', 'kasir.pos'))
                    Penjualan
                @elseif(Request::routeIs('admin.transaksi.*', 'kasir.transaksi.*'))
                    Histori Transaksi
                @elseif(Request::routeIs('admin.reports.*', 'kasir.reports.*'))
                    Laporan
                <!-- Data -->
                @elseif(Request::routeIs('admin.products.*'))
                    Data Produk
                @elseif(Request::routeIs('admin.kategoris.*'))
                    Data Kategori
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

    <!-- Right: User Menu (optional future enhancement) -->
    <div class="items-center flex-shrink-0 hidden space-x-2 md:flex">
        <!-- You can add theme toggle or user menu here in the future -->
    </div>
</nav>

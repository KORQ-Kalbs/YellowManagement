@props([
    'title' => null,
    'variant' => 'app',
    'brandName' => 'Yellow',
    'menuHref' => '/#menu',
    'aboutHref' => '/#about',
    'locationHref' => '/#location',
    'loginHref' => '/login',
])

@if($variant === 'guest')
<nav class="fixed inset-x-0 top-0 z-50 flex items-center justify-between border-b border-[#FFD600]/20 bg-white/85 px-6 py-5 backdrop-blur-xl lg:px-14">
    <a href="/" class="font-display text-2xl font-black tracking-tight text-[#1A1600] no-underline">
        {{ $brandName }}<span class="text-[#C9A800]">.</span>
    </a>
    <ul class="hidden items-center gap-8 text-xs font-bold uppercase tracking-[.09em] text-[#4A3F00] md:flex" style="list-style:none;">
        <li><a href="{{ $menuHref }}" class="transition-colors hover:text-[#1A1600] no-underline">Menu</a></li>
        <li><a href="{{ $aboutHref }}" class="transition-colors hover:text-[#1A1600] no-underline">Tentang</a></li>
        <li><a href="{{ $locationHref }}" class="transition-colors hover:text-[#1A1600] no-underline">Lokasi</a></li>
    </ul>

    
</nav>
@else
<nav class="sticky top-0 z-30 flex items-center justify-between w-full px-3 py-3 border-b shadow-sm lg:px-6 lg:py-4 app-surface dark:shadow-md app-border">
    <!-- Left: Sidebar Toggle & Breadcrumb -->
    <div class="flex items-center flex-1 min-w-0 space-x-2 lg:space-x-3">
        <!-- Mobile Logo -->
        <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-lg lg:hidden bg-gradient-to-br">
            <img src="{{ asset('img/yellowlogosblack.png') }}" alt="Yellow Drink" width="60" height="60" class="object-contain w-15 h-15 dark:hidden">
            <img src="{{ asset('img/yellowlogoswhite.png') }}" alt="Yellow Drink" width="60" height="60" class="hidden object-contain w-15 h-15 dark:block">
        </div>

        <!-- Sidebar Toggle Button -->
        <button @click="sidebarOpen = !sidebarOpen"
            class="flex-shrink-0 hidden p-2 transition-colors border rounded-lg lg:flex app-surface app-hover app-border"
            title="Toggle Sidebar">
            <svg class="w-5 h-5 app-text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Breadcrumb / Page Info -->
        <div class="flex items-center min-w-0 space-x-2 app-text">
            @if(auth()->user()->role === 'admin')
                <span style="font-size: 13px;" class="font-medium app-muted">Admin</span>
            @else
                <span style="font-size: 13px;" class="font-medium app-muted">Kasir</span>
            @endif
            <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="min-w-0 font-semibold truncate app-text" style="font-size: 13px;">
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
@endif

<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div x-data="{ sidebarOpen: true, profileOpen: false }" class="flex h-screen bg-gray-50 dark:bg-gray-900">
    
    <!-- Sidebar -->
    <aside 
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 w-64 transition-transform duration-300 transform shadow-xl bg-gradient-to-b from-yellow-400 via-yellow-500 to-orange-500 lg:translate-x-0 lg:static lg:inset-0">
        
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between h-16 px-6 bg-black bg-opacity-10">
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg shadow-md">
                    <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                    </svg>
                </div>
                <span class="text-xl font-bold text-white">Yellow Drink</span>
            </div>
            
            <!-- Close button (mobile) -->
            <button @click="sidebarOpen = false" class="text-white lg:hidden hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- User Profile Section -->
        <div class="px-6 py-4 border-b border-white border-opacity-20">
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-12 h-12 text-lg font-bold text-yellow-500 bg-white rounded-full">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-white" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></p>
                    <p class="text-xs text-yellow-100">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               wire:navigate
               class="flex items-center px-4 py-3 space-x-3 text-white transition-all duration-200 rounded-lg group {{ request()->routeIs('dashboard') ? 'bg-white bg-opacity-20 shadow-lg' : 'hover:bg-white hover:bg-opacity-10' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-yellow-100 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="font-medium">Dashboard</span>
                @if(request()->routeIs('dashboard'))
                    <div class="w-1 h-8 ml-auto bg-white rounded-full"></div>
                @endif
            </a>

            @if(auth()->user()->role === 'admin')
                <!-- Admin Menu -->
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold tracking-wider text-yellow-100 uppercase">Admin</p>
                </div>

                <!-- Products -->
                <a href="{{ route('admin.products.index') }}" 
                   wire:navigate
                   class="flex items-center px-4 py-3 space-x-3 text-white transition-all duration-200 rounded-lg group {{ request()->routeIs('admin.products.*') ? 'bg-white bg-opacity-20 shadow-lg' : 'hover:bg-white hover:bg-opacity-10' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-yellow-100 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="font-medium">Produk</span>
                    @if(request()->routeIs('admin.products.*'))
                        <div class="w-1 h-8 ml-auto bg-white rounded-full"></div>
                    @endif
                </a>

                <!-- Categories -->
                <a href="{{ route('admin.kategoris.index') }}" 
                   wire:navigate
                   class="flex items-center px-4 py-3 space-x-3 text-white transition-all duration-200 rounded-lg group {{ request()->routeIs('admin.kategoris.*') ? 'bg-white bg-opacity-20 shadow-lg' : 'hover:bg-white hover:bg-opacity-10' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.kategoris.*') ? 'text-white' : 'text-yellow-100 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span class="font-medium">Kategori</span>
                    @if(request()->routeIs('admin.kategoris.*'))
                        <div class="w-1 h-8 ml-auto bg-white rounded-full"></div>
                    @endif
                </a>

                <!-- Transactions -->
                <a href="{{ route('admin.transaksi.index') }}" 
                   wire:navigate
                   class="flex items-center px-4 py-3 space-x-3 text-white transition-all duration-200 rounded-lg group {{ request()->routeIs('admin.transaksi.*') ? 'bg-white bg-opacity-20 shadow-lg' : 'hover:bg-white hover:bg-opacity-10' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.transaksi.*') ? 'text-white' : 'text-yellow-100 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="font-medium">Transaksi</span>
                    @if(request()->routeIs('admin.transaksi.*'))
                        <div class="w-1 h-8 ml-auto bg-white rounded-full"></div>
                    @endif
                </a>

                <!-- Reports -->
                <a href="{{ route('admin.reports.index') }}" 
                   wire:navigate
                   class="flex items-center px-4 py-3 space-x-3 text-white transition-all duration-200 rounded-lg group {{ request()->routeIs('admin.reports.*') ? 'bg-white bg-opacity-20 shadow-lg' : 'hover:bg-white hover:bg-opacity-10' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.reports.*') ? 'text-white' : 'text-yellow-100 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="font-medium">Laporan</span>
                    @if(request()->routeIs('admin.reports.*'))
                        <div class="w-1 h-8 ml-auto bg-white rounded-full"></div>
                    @endif
                </a>

            @elseif(auth()->user()->role === 'kasir')
                <!-- Kasir Menu -->
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold tracking-wider text-yellow-100 uppercase">Kasir</p>
                </div>

                <!-- POS -->
                <a href="{{ route('kasir.pos') }}" 
                   wire:navigate
                   class="flex items-center px-4 py-3 space-x-3 text-white transition-all duration-200 rounded-lg group {{ request()->routeIs('kasir.pos') ? 'bg-white bg-opacity-20 shadow-lg' : 'hover:bg-white hover:bg-opacity-10' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('kasir.pos') ? 'text-white' : 'text-yellow-100 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="font-medium">Point of Sale</span>
                    @if(request()->routeIs('kasir.pos'))
                        <div class="w-1 h-8 ml-auto bg-white rounded-full"></div>
                    @endif
                </a>

                <!-- Transactions -->
                <a href="{{ route('kasir.transaksi.index') }}" 
                   wire:navigate
                   class="flex items-center px-4 py-3 space-x-3 text-white transition-all duration-200 rounded-lg group {{ request()->routeIs('kasir.transaksi.*') ? 'bg-white bg-opacity-20 shadow-lg' : 'hover:bg-white hover:bg-opacity-10' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('kasir.transaksi.*') ? 'text-white' : 'text-yellow-100 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="font-medium">Riwayat Transaksi</span>
                    @if(request()->routeIs('kasir.transaksi.*'))
                        <div class="w-1 h-8 ml-auto bg-white rounded-full"></div>
                    @endif
                </a>

                <!-- Laporan -->
                <a href="{{ route('kasir.reports.index') }}" 
                   wire:navigate
                   class="flex items-center px-4 py-3 space-x-3 text-white transition-all duration-200 rounded-lg group {{ request()->routeIs('kasir.reports.*') ? 'bg-white bg-opacity-20 shadow-lg' : 'hover:bg-white hover:bg-opacity-10' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('kasir.reports.*') ? 'text-white' : 'text-yellow-100 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="font-medium">Laporan</span>
                    @if(request()->routeIs('kasir.reports.*'))
                        <div class="w-1 h-8 ml-auto bg-white rounded-full"></div>
                    @endif
                </a>
            @endif

        </nav>

        <!-- Bottom Section -->
        <div class="p-4 border-t border-white border-opacity-20">
            <!-- Profile Link -->
            <a href="{{ route('profile') }}" 
               wire:navigate
               class="flex items-center px-4 py-3 mb-2 space-x-3 text-white transition-all duration-200 rounded-lg group hover:bg-white hover:bg-opacity-10">
                <svg class="w-5 h-5 text-yellow-100 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="font-medium">Profile</span>
            </a>

            <!-- Logout Button -->
            <button wire:click="logout" class="flex items-center w-full px-4 py-3 space-x-3 text-white transition-all duration-200 rounded-lg group hover:bg-red-500">
                <svg class="w-5 h-5 text-yellow-100 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span class="font-medium">Logout</span>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex flex-col flex-1 w-full overflow-hidden">
        
        <!-- Top Bar (Mobile) -->
        <header class="flex items-center justify-between h-16 px-6 bg-white border-b border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700 lg:hidden">
            <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="text-xl font-bold text-gray-800 dark:text-white">Yellow Drink</span>
            <div class="w-6"></div> <!-- Spacer -->
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900">
            @isset($slot)
                {{ $slot }}
            @endisset
        </main>
    </div>

    <!-- Overlay (Mobile) -->
    <div 
        x-show="sidebarOpen" 
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
</div>
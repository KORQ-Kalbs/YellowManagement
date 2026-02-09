<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Dashboard Kasir
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Selamat datang kembali, {{ auth()->user()->name }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ now()->format('d F Y') }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-500">{{ now()->format('H:i') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Transactions Today -->
            <x-stat-card
                label="Transaksi Hari Ini"
                :value="$transaksi_hari_ini ?? 0"
                color="blue"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <!-- Revenue Today -->
            <x-stat-card
                label="Pendapatan Hari Ini"
                :value="'Rp ' . number_format($pendapatan_hari_ini ?? 0, 0, ',', '.')"
                color="green"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <!-- Average Transaction -->
            <x-stat-card
                label="Rata-rata Transaksi"
                :value="$transaksi_hari_ini > 0 ? 'Rp ' . number_format($pendapatan_hari_ini / $transaksi_hari_ini, 0, ',', '.') : 'Rp 0'"
                color="yellow"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h.01a1 1 0 110 2H12zm-2.763 5a2 2 0 00-.894 3.756 3.972 3.972 0 01.891-1.631A.5.5 0 1010.5 13h-.5zm1.753-2.908a4 4 0 00-7.671 0H3a2 2 0 100 4h.276a2 2 0 100-4h.724zM10 9a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                </x-slot>
            </x-stat-card>
        </div>

        <!-- Quick Actions -->
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('kasir.pos') }}" wire:navigate class="inline-flex items-center px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Buat Transaksi Baru
            </a>

            <a href="{{ route('kasir.transaksi.index') }}" wire:navigate class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-800 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Lihat Riwayat
            </a>
        </div>

        <!-- Recent Transactions -->
        @if(isset($transaksi_terbaru) && count($transaksi_terbaru) > 0)
            <x-card title="Transaksi Terbaru" noPadding="true">
                <x-table>
                    <x-table-head>
                        <x-table-heading>No. Invoice</x-table-heading>
                        <x-table-heading>Tanggal</x-table-heading>
                        <x-table-heading>Jumlah Item</x-table-heading>
                        <x-table-heading>Total Harga</x-table-heading>
                        <x-table-heading>Status</x-table-heading>
                        <x-table-heading>Aksi</x-table-heading>
                    </x-table-head>
                    <x-table-body>
                        @foreach($transaksi_terbaru as $transaksi)
                            <x-table-row>
                                <x-table-cell>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $transaksi->no_invoice }}</span>
                                </x-table-cell>
                                <x-table-cell>
                                    {{ $transaksi->tanggal_transaksi->format('d/m/Y H:i') }}
                                </x-table-cell>
                                <x-table-cell>
                                    {{ $transaksi->details->count() }} item
                                </x-table-cell>
                                <x-table-cell>
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                    </span>
                                </x-table-cell>
                                <x-table-cell>
                                    @if($transaksi->status === 'completed')
                                        <x-badge type="completed">Selesai</x-badge>
                                    @elseif($transaksi->status === 'pending')
                                        <x-badge type="pending">Menunggu</x-badge>
                                    @else
                                        <x-badge type="cancelled">Dibatalkan</x-badge>
                                    @endif
                                </x-table-cell>
                                <x-table-cell>
                                    <a href="{{ route('kasir.transaksi.show', $transaksi->id) }}" wire:navigate class="text-yellow-600 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300 font-medium text-sm">
                                        Lihat
                                    </a>
                                </x-table-cell>
                            </x-table-row>
                        @endforeach
                    </x-table-body>
                </x-table>
            </x-card>
        @else
            <x-card>
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">Belum ada transaksi hari ini</p>
                    <p class="text-gray-500 dark:text-gray-500 text-sm mt-1">Mulai buat transaksi baru untuk melihat di sini</p>
                </div>
            </x-card>
        @endif
    </div>
</x-app-layout>
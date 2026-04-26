<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Riwayat Transaksi
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Kelola dan lihat semua transaksi Anda
                </p>
            </div>
            <a href="{{ route('kasir.pos') }}" class="inline-flex items-center px-4 py-2 font-medium text-white transition-colors bg-yellow-500 rounded-lg hover:bg-yellow-600">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Transaksi Baru
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Filters -->
        <x-card>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <x-input-label for="search" value="Cari Invoice" />
                    <input type="text" id="search" placeholder="No. Invoice..." class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <x-input-label for="status" value="Status" />
                    <select id="status" class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="completed">Selesai</option>
                        <option value="pending">Menunggu</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="date" value="Tanggal" />
                    <input type="date" id="date" class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
            </div>
        </x-card>

        <!-- Transactions Table -->
        <x-card noPadding="true">
            @if(isset($transaksis) && $transaksis->count() > 0)
                <x-table>
                    <x-table-head>
                        <x-table-heading>No. Invoice</x-table-heading>
                        <x-table-heading>Tanggal & Waktu</x-table-heading>
                        <x-table-heading>Items</x-table-heading>
                        <x-table-heading>Total Harga</x-table-heading>
                        <x-table-heading>Status</x-table-heading>
                        <x-table-heading>Aksi</x-table-heading>
                    </x-table-head>
                    <x-table-body>
                        @foreach($transaksis as $transaksi)
                            <x-table-row>
                                <x-table-cell>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $transaksi->no_invoice }}</span>
                                </x-table-cell>
                                <x-table-cell>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaksi->tanggal_transaksi->format('d/m/Y') }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $transaksi->tanggal_transaksi->format('H:i') }}</p>
                                    </div>
                                </x-table-cell>
                                <x-table-cell>
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-200">
                                        {{ $transaksi->details->count() }} item
                                    </span>
                                </x-table-cell>
                                <x-table-cell>
                                    <span class="font-bold text-gray-900 dark:text-white">
                                        Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                    </span>
                                </x-table-cell>
                                <x-table-cell>
                                    @if($transaksi->status === 'completed')
                                        <x-badge type="completed">✓ Selesai</x-badge>
                                    @elseif($transaksi->status === 'pending')
                                        <x-badge type="pending">⏳ Menunggu</x-badge>
                                    @else
                                        <x-badge type="cancelled">✕ Dibatalkan</x-badge>
                                    @endif
                                </x-table-cell>
                                <x-table-cell>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('kasir.transaksi.show', $transaksi->id) }}" class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-600 transition-colors rounded-lg bg-blue-50 dark:bg-blue-900/30 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat
                                        </a>
                                    </div>
                                </x-table-cell>
                            </x-table-row>
                        @endforeach
                    </x-table-body>
                </x-table>

                <!-- Pagination -->
                @if(method_exists($transaksis, 'links'))
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $transaksis->links() }}
                    </div>
                @endif
            @else
                <div class="py-16 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Tidak ada transaksi</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Mulai buat transaksi baru untuk melihatnya di sini</p>
                </div>
            @endif
        </x-card>
    </div>
</x-app-layout>

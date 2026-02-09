<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                Laporan & Analitik
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Pantau penjualan dan performa sistem
            </p>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Date Range Filter -->
        <x-card>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <x-input-label for="start-date" value="Tanggal Mulai" />
                    <input type="date" id="start-date" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <x-input-label for="end-date" value="Tanggal Akhir" />
                    <input type="date" id="end-date" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                </div>
                <div class="flex items-end">
                    <button onclick="filterReport()" class="w-full px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors">
                        Filter
                    </button>
                </div>
                <div class="flex items-end">
                    <button onclick="exportReport()" class="w-full px-4 py-2 bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-800 text-white font-medium rounded-lg transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Export
                    </button>
                </div>
            </div>
        </x-card>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <x-stat-card
                label="Total Penjualan"
                :value="'Rp ' . number_format(\App\Models\Transaksi::sum('total_harga'), 0, ',', '.')"
                color="yellow"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card
                label="Total Transaksi"
                :value="\App\Models\Transaksi::count()"
                color="blue"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card
                label="Rata-rata per Transaksi"
                :value="$transaksi_count = \App\Models\Transaksi::count() > 0 ? 'Rp ' . number_format(\App\Models\Transaksi::sum('total_harga') / \App\Models\Transaksi::count(), 0, ',', '.') : 'Rp 0'"
                color="green"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h.01a1 1 0 110 2H12zm-2.763 5a2 2 0 00-.894 3.756 3.972 3.972 0 01.891-1.631A.5.5 0 1010.5 13h-.5zm1.753-2.908a4 4 0 00-7.671 0H3a2 2 0 100 4h.276a2 2 0 100-4h.724zM10 9a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card
                label="Produk Terjual"
                :value="\App\Models\DetailTransaksi::sum('jumlah')"
                color="purple"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z" />
                    </svg>
                </x-slot>
            </x-stat-card>
        </div>

        <!-- Top Selling Products -->
        <x-card title="Produk Terlaris">
            @php
                $topProducts = \App\Models\DetailTransaksi::with('product')
                    ->select('product_id', \DB::raw('SUM(jumlah) as total_jumlah'), \DB::raw('SUM(subtotal) as total_pendapatan'))
                    ->groupBy('product_id')
                    ->orderByDesc('total_jumlah')
                    ->take(5)
                    ->get();
            @endphp

            @if($topProducts->count() > 0)
                <div class="space-y-3">
                    @foreach($topProducts as $item)
                        <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $item->product?->nama ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $item->total_jumlah }} unit terjual</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 dark:text-gray-400 text-center py-8">Tidak ada data penjualan</p>
            @endif
        </x-card>

        <!-- Transactions by Status -->
        <x-card title="Status Transaksi">
            @php
                $completedCount = \App\Models\Transaksi::where('status', 'completed')->count();
                $pendingCount = \App\Models\Transaksi::where('status', 'pending')->count();
                $cancelledCount = \App\Models\Transaksi::where('status', 'cancelled')->count();
                $total = $completedCount + $pendingCount + $cancelledCount;
            @endphp

            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Selesai</span>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $completedCount }} ({{ $total > 0 ? round(($completedCount / $total) * 100) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $total > 0 ? ($completedCount / $total) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Menunggu</span>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $pendingCount }} ({{ $total > 0 ? round(($pendingCount / $total) * 100) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $total > 0 ? ($pendingCount / $total) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Dibatalkan</span>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $cancelledCount }} ({{ $total > 0 ? round(($cancelledCount / $total) * 100) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: {{ $total > 0 ? ($cancelledCount / $total) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </x-card>
    </div>

    <script>
        function filterReport() {
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;
            // Implement filter logic here
            alert('Filter by dates: ' + startDate + ' to ' + endDate);
        }

        function exportReport() {
            // Implement export logic here
            alert('Exporting report...');
        }
    </script>
</x-app-layout>

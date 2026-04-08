<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Dashboard Admin
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Kelola dan pantau sistem Yellow Drink POS
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ now()->format('d F Y') }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-500">{{ now()->format('H:i') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Products -->
            <x-stat-card
                label="Total Produk"
                :value="\App\Models\Product::count()"
                color="blue"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <!-- Total Categories -->
            <x-stat-card
                label="Total Kategori"
                :value="\App\Models\Kategori::count()"
                color="green"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <!-- Total Transactions -->
            <x-stat-card
                label="Total Transaksi"
                :value="\App\Models\Transaksi::where('status', 'completed')->count()"
                color="yellow"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <!-- Total Produk Terjual -->
            <x-stat-card
                label="Produk Terjual"
                :value="number_format($totalProdukTerjual ?? 0, 0, ',', '.')"
                color="purple"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                    </svg>
                </x-slot>
            </x-stat-card>
        </div>

        <!-- Financial Metrics -->
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-8 mb-4">Ringkasan Keuangan</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Pendapatan Kotor -->
            <x-stat-card
                label="Pendapatan Kotor"
                :value="'Rp ' . number_format($totalPendapatan ?? 0, 0, ',', '.')"
                color="blue"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <!-- Pengeluaran -->
            <x-stat-card
                label="Pengeluaran"
                :value="'Rp ' . number_format($pengeluaran ?? 0, 0, ',', '.')"
                color="red"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z" clip-rule="evenodd" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <!-- Pendapatan Bersih -->
            <x-stat-card
                label="Pendapatan Bersih"
                :value="'Rp ' . number_format($pendapatanBersih ?? 0, 0, ',', '.')"
                color="green"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                    </svg>
                </x-slot>
            </x-stat-card>
        </div>

        <!-- Sales Chart -->
        <x-card>
            <div class="mb-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Penjualan 7 Hari Terakhir</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Grafik penjualan harian seluruh sistem</p>
            </div>
            <div class="h-64">
                <canvas id="salesChart"></canvas>
            </div>
        </x-card>

        <!-- Management Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Quick Access -->
            <x-card title="Akses Cepat">
                <div class="space-y-3">
                    <a href="{{ route('admin.products.index') }}" class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors group">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Kelola Produk</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ \App\Models\Product::count() }} produk</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="{{ route('admin.kategoris.index') }}" class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors group">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Kelola Kategori</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ \App\Models\Kategori::count() }} kategori</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="{{ route('admin.transaksi.index') }}" class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors group">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Lihat Transaksi</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ \App\Models\Transaksi::count() }} transaksi</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </x-card>

            <!-- System Info -->
            <x-card title="Informasi Sistem">
                <div class="space-y-4">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Aplikasi</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">Yellow Drink POS</span>
                    </div>
                    <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Versi Laravel</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ App::VERSION() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Pengguna Aktif</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ \App\Models\User::count() }}</span>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Recent Transactions -->
        <x-card title="Transaksi Terbaru" noPadding="true">
            @php
                $transaksi_terbaru = \App\Models\Transaksi::with(['user', 'details.product'])
                    ->latest('tanggal_transaksi')
                    ->take(10)
                    ->get();
            @endphp

            @if($transaksi_terbaru->count() > 0)
                <x-table>
                    <x-table-head>
                        <x-table-heading>No. Invoice</x-table-heading>
                        <x-table-heading>Kasir</x-table-heading>
                        <x-table-heading>Tanggal</x-table-heading>
                        <x-table-heading>Items</x-table-heading>
                        <x-table-heading>Total</x-table-heading>
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
                                    {{ $transaksi->user->name }}
                                </x-table-cell>
                                <x-table-cell>
                                    {{ $transaksi->tanggal_transaksi->format('d/m/Y H:i') }}
                                </x-table-cell>
                                <x-table-cell>
                                    {{ $transaksi->details->count() }}
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
                                    <a href="{{ route('admin.transaksi.show', $transaksi->id) }}" class="text-yellow-600 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300 font-medium text-sm">
                                        Lihat
                                    </a>
                                </x-table-cell>
                            </x-table-row>
                        @endforeach
                    </x-table-body>
                </x-table>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-600 dark:text-gray-400">Belum ada transaksi</p>
                </div>
            @endif
        </x-card>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function initDashboardChart() {
            const canvas = document.getElementById('salesChart');
            if (!canvas || typeof Chart === 'undefined') return;

            // Destroy existing instance if re-navigating via Livewire SPA
            if (canvas._chartInstance) {
                canvas._chartInstance.destroy();
            }

            const isDark = document.documentElement.classList.contains('dark');

            canvas._chartInstance = new Chart(canvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: @json($labels ?? []),
                    datasets: [{
                        label: 'Penjualan (Rp)',
                        data: @json($salesData ?? []),
                        borderColor: 'rgb(234, 179, 8)',
                        backgroundColor: 'rgba(234, 179, 8, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { labels: { color: isDark ? '#9CA3AF' : '#374151' } }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: isDark ? '#9CA3AF' : '#374151',
                                callback: value => 'Rp ' + value.toLocaleString('id-ID')
                            },
                            grid: { color: isDark ? '#374151' : '#E5E7EB' }
                        },
                        x: {
                            ticks: { color: isDark ? '#9CA3AF' : '#374151' },
                            grid: { color: isDark ? '#374151' : '#E5E7EB' }
                        }
                    }
                }
            });
        }

        // Standard page load
        window.addEventListener('load', initDashboardChart);

        // Livewire SPA navigation (wire:navigate)
        document.addEventListener('livewire:navigated', initDashboardChart);
    </script>
</x-app-layout>

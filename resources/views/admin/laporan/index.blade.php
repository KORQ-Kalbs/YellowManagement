<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Reports</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Sales and business analytics</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Period Selector Tabs -->
        <div class="flex flex-wrap gap-2 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <a href="{{ route('admin.reports.index', ['period' => 'day', 'date' => $selectedDate->format('Y-m-d')]) }}" 
               class="px-6 py-2 rounded-lg font-medium transition-colors {{ $period === 'day' ? 'bg-blue-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Per Hari
            </a>
            <a href="{{ route('admin.reports.index', ['period' => 'week', 'date' => $selectedDate->format('Y-m-d')]) }}" 
               class="px-6 py-2 rounded-lg font-medium transition-colors {{ $period === 'week' ? 'bg-blue-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Per Minggu
            </a>
            <a href="{{ route('admin.reports.index', ['period' => 'month', 'date' => $selectedDate->format('Y-m-d')]) }}" 
               class="px-6 py-2 rounded-lg font-medium transition-colors {{ $period === 'month' ? 'bg-blue-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Per Bulan
            </a>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <x-stat-card 
                title="Total Revenue" 
                :value="'Rp ' . number_format($stats['totalRevenue'] ?? 0, 0, ',', '.')" 
                color="blue"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card 
                title="Today's Revenue" 
                :value="'Rp ' . number_format($stats['dailyRevenue'] ?? 0, 0, ',', '.')" 
                color="green"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card 
                title="Total Transactions" 
                :value="$stats['totalTransactions'] ?? 0" 
                color="yellow"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                    </svg>
                </x-slot>
            </x-stat-card>
        </div>

        <!-- Sales Chart -->
        <x-card>
            <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        @if($period === 'day') Penjualan Per Hari
                        @elseif($period === 'week') Penjualan Per Minggu
                        @else Penjualan Per Bulan
                        @endif
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Sales performance overview</p>
                </div>
                
                <!-- Date Picker and Actions -->
                <div class="flex flex-wrap gap-2">
                    <input type="date" 
                           id="datePicker" 
                           value="{{ $selectedDate->format('Y-m-d') }}"
                           class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm"
                           onchange="window.location.href='{{ route('admin.reports.index') }}?period={{ $period }}&date=' + this.value">
                    
                    <button onclick="window.location.reload()" 
                            class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Refresh
                    </button>
                    
                    <a href="{{ route('admin.reports.export.excel', ['period' => $period, 'date' => $selectedDate->format('Y-m-d')]) }}"
                            class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export Excel
                    </a>
                    
                    <a href="{{ route('admin.reports.export.pdf', ['period' => $period, 'date' => $selectedDate->format('Y-m-d')]) }}"
                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Export PDF
                    </a>
                </div>
            </div>
            <div class="h-80">
                <canvas id="salesChart"></canvas>
            </div>
        </x-card>

        <!-- Top Products -->
        <x-card>
            <div class="mb-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Top Selling Products</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400" id="productsTable">
                    <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Product Name</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Sold Units</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse($topProducts ?? [] as $product)
                            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $product->nama_produk }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <x-badge type="info">
                                        {{ $product->kategori->nama_kategori ?? 'N/A' }}
                                    </x-badge>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-600 dark:text-gray-400">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $product->sold_count ?? 0 }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-green-600 dark:text-green-400">Rp {{ number_format(($product->harga * ($product->sold_count ?? 0)), 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white dark:bg-gray-800">
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    <p>No sales data available yet</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const isDark = document.documentElement.classList.contains('dark');
        
        new Chart(ctx, {
            type: '{{ $period === "month" ? "line" : "bar" }}',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Sales (Rp)',
                    data: @json($salesData),
                    backgroundColor: '{{ $period === "month" ? "rgba(234, 179, 8, 0.1)" : "rgba(234, 179, 8, 0.8)" }}',
                    borderColor: 'rgb(234, 179, 8)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: {{ $period === 'month' ? 'true' : 'false' }}
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: isDark ? '#9CA3AF' : '#374151'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: isDark ? '#9CA3AF' : '#374151',
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: {
                            color: isDark ? '#374151' : '#E5E7EB'
                        }
                    },
                    x: {
                        ticks: {
                            color: isDark ? '#9CA3AF' : '#374151'
                        },
                        grid: {
                            color: isDark ? '#374151' : '#E5E7EB'
                        }
                    }
                }
            }
        });
        
        function exportExcel() { /* handled by backend route */ }
    </script>
</x-app-layout>

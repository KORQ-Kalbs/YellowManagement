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
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-stat-card 
                title="Total Revenue" 
                :value="'Rp ' . number_format($totalRevenue ?? 0, 0, ',', '.')" 
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
                :value="'Rp ' . number_format($dailyRevenue ?? 0, 0, ',', '.')" 
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
                :value="$totalTransactions ?? 0" 
                color="yellow"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card 
                title="Top Products" 
                :value="count($topProducts ?? [])" 
                color="purple"
            >
                <x-slot name="icon">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </x-slot>
            </x-stat-card>
        </div>

        <!-- Sales Chart -->
        <x-card>
            <div class="mb-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Sales Trend (Last 7 Days)</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Daily sales performance overview</p>
            </div>
            <div class="h-64">
                <canvas id="salesChart"></canvas>
            </div>
        </x-card>

        <!-- Top Products -->
        <x-card>
            <div class="mb-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Top Selling Products</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
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
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Sales (Rp)',
                    data: @json($salesData),
                    backgroundColor: 'rgba(234, 179, 8, 0.8)',
                    borderColor: 'rgb(234, 179, 8)',
                    borderWidth: 1
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
    </script>
</x-app-layout>

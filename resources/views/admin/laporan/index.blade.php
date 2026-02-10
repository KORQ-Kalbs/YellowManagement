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
                icon="chart-bar"
                color="bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400"
            />
            <x-stat-card 
                title="Today's Revenue" 
                :value="'Rp ' . number_format($dailyRevenue ?? 0, 0, ',', '.')" 
                icon="trending-up"
                color="bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400"
            />
            <x-stat-card 
                title="Total Transactions" 
                :value="$totalTransactions ?? 0" 
                icon="shopping-cart"
                color="bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400"
            />
            <x-stat-card 
                title="Top Products" 
                :value="count($topProducts ?? [])" 
                icon="star"
                color="bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400"
            />
        </div>

        <!-- Top Products -->
        <x-card>
            <x-slot name="header">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Top Selling Products</h3>
            </x-slot>

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
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $product->name }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <x-badge :color="'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200'">
                                        {{ $product->kategori->name ?? 'N/A' }}
                                    </x-badge>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-600 dark:text-gray-400">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $product->sold_count ?? 0 }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-green-600 dark:text-green-400">Rp {{ number_format(($product->price * ($product->sold_count ?? 0)), 0, ',', '.') }}</span>
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
</x-app-layout>

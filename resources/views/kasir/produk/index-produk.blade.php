<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Data Produk</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Lihat daftar produk yang tersedia (Read-only)</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="p-4 text-green-800 bg-green-100 rounded-lg dark:bg-green-900/30 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 text-red-800 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <!-- Products Table -->
        <x-card noPadding="true">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                    <thead class="font-semibold text-gray-700 bg-gray-100 border-b border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Nama Produk</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Kategori</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Harga</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Varian</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Stok</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse($products as $product)
                            <tr class="transition-colors bg-[#fef3c7] dark:bg-gray-800 hover:bg-[#fde89a] dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $product->nama_produk }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span>{{ $product->kategori?->nama_kategori ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($product->allVariants->count())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($product->allVariants as $v)
                                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300">
                                                    {{ $v->kode_variant }}
                                                    @if(floatval($v->harga_tambahan) != 0)
                                                        <span class="ml-1 text-[10px] opacity-70">+{{ number_format($v->harga_tambahan, 0, ',', '.') }}</span>
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $product->stok }}</p>
                                        <p class="text-xs {{ $product->stok <= 5 ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}">
                                            {{ $product->stok > 10 ? 'Banyak' : ($product->stok > 5 ? 'Cukup' : ($product->stok > 0 ? 'Sedikit' : 'Habis')) }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($product->status === 'active')
                                        <x-badge type="success">Aktif</x-badge>
                                    @else
                                        <x-badge type="warning">Nonaktif</x-badge>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-[#fef3c7] dark:bg-gray-800">
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <p class="text-lg text-gray-600 dark:text-gray-400">Tidak ada produk yang ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $products->links() }}
                </div>
            @endif
        </x-card>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Kelola Produk
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Tambah, edit, dan kelola inventaris produk
                </p>
            </div>
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Filters -->
        <x-card>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <x-input-label for="search" value="Cari Produk" />
                    <input type="text" id="search" placeholder="Nama produk..." class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <x-input-label for="kategori" value="Kategori" />
                    <select id="kategori" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="">Semua Kategori</option>
                        @foreach(\App\Models\Kategori::all() as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="status" value="Status" />
                    <select id="status" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="stok-status" value="Stok" />
                    <select id="stok-status" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="">Semua</option>
                        <option value="ready">Tersedia</option>
                        <option value="low">Stok Rendah</option>
                        <option value="empty">Habis</option>
                    </select>
                </div>
            </div>
        </x-card>

        <!-- Products Table -->
        <x-card noPadding="true">
            @if(isset($products) && $products->count() > 0)
                <x-table>
                    <x-table-head>
                        <x-table-heading>Produk</x-table-heading>
                        <x-table-heading>Kategori</x-table-heading>
                        <x-table-heading>Harga</x-table-heading>
                        <x-table-heading>Stok</x-table-heading>
                        <x-table-heading>Status</x-table-heading>
                        <x-table-heading>Aksi</x-table-heading>
                    </x-table-head>
                    <x-table-body>
                        @foreach($products as $product)
                            <x-table-row>
                                <x-table-cell>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $product->nama }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">SKU: {{ $product->sku ?? '-' }}</p>
                                    </div>
                                </x-table-cell>
                                <x-table-cell>
                                    <span class="text-sm">{{ $product->kategori?->nama ?? '-' }}</span>
                                </x-table-cell>
                                <x-table-cell>
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    </span>
                                </x-table-cell>
                                <x-table-cell>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $product->stok }}</p>
                                        <p class="text-xs {{ $product->stok <= 5 ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}">
                                            {{ $product->stok > 10 ? 'Banyak' : ($product->stok > 5 ? 'Cukup' : ($product->stok > 0 ? 'Rendah' : 'Habis')) }}
                                        </p>
                                    </div>
                                </x-table-cell>
                                <x-table-cell>
                                    @if($product->status === 'active')
                                        <x-badge type="success">Aktif</x-badge>
                                    @else
                                        <x-badge type="warning">Nonaktif</x-badge>
                                    @endif
                                </x-table-cell>
                                <x-table-cell>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 rounded-lg bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50 transition-colors text-sm font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </x-table-cell>
                            </x-table-row>
                        @endforeach
                    </x-table-body>
                </x-table>

                <!-- Pagination -->
                @if(method_exists($products, 'links'))
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $products->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-16">
                    <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Tidak ada produk</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Mulai dengan menambahkan produk baru</p>
                </div>
            @endif
        </x-card>
    </div>
</x-app-layout>

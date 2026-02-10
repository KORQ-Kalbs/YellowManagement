<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Product Management</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage your product inventory</p>
            </div>
            <button @click="$dispatch('open-modal', 'product-modal'); resetForm()" class="inline-flex items-center px-4 py-2 font-medium text-white transition-colors bg-yellow-500 rounded-lg hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Product
            </button>
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
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Name</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Category</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Price</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Stock</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Status</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse($products as $product)
                            <tr class="transition-colors bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50">
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
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $product->stok }}</p>
                                        <p class="text-xs {{ $product->stok <= 5 ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}">
                                            {{ $product->stok > 10 ? 'Plenty' : ($product->stok > 5 ? 'Adequate' : ($product->stok > 0 ? 'Low' : 'Out')) }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($product->status === 'active')
                                        <x-badge type="success">Active</x-badge>
                                    @else
                                        <x-badge type="warning">Inactive</x-badge>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <button @click="editProduct({{ $product->id }}, '{{ $product->nama_produk }}', {{ $product->kategori_id }}, {{ $product->harga }}, {{ $product->stok }}, '{{ $product->status }}')" class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-600 transition-colors rounded-lg bg-blue-50 dark:bg-blue-900/30 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 text-sm font-medium text-red-600 transition-colors rounded-lg bg-red-50 dark:bg-red-900/30 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white dark:bg-gray-800">
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <p class="text-lg text-gray-600 dark:text-gray-400">No products found</p>
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

    <!-- Product Modal -->
    <x-modal name="product-modal" :show="false">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4" id="product-modal-title">Add Product</h3>
            
            <form id="product-form" method="POST" action="{{ route('admin.products.store') }}">
                @csrf
                <input type="hidden" id="product-method" name="_method" value="POST">
                <input type="hidden" id="product-id" name="id">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product Name</label>
                        <input type="text" id="product-nama" name="nama_produk" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                        <select id="product-kategori" name="kategori_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required>
                            <option value="">Select Category</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price</label>
                        <input type="number" id="product-harga" name="harga" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required min="0">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock</label>
                        <input type="number" id="product-stok" name="stok" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required min="0">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select id="product-status" name="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <x-secondary-button type="button" @click="$dispatch('close')">Cancel</x-secondary-button>
                    <x-primary-button type="submit">Save</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    <script>
        function resetForm() {
            document.getElementById('product-modal-title').textContent = 'Add Product';
            document.getElementById('product-form').action = '{{ route("admin.products.store") }}';
            document.getElementById('product-method').value = 'POST';
            document.getElementById('product-id').value = '';
            document.getElementById('product-nama').value = '';
            document.getElementById('product-kategori').value = '';
            document.getElementById('product-harga').value = '';
            document.getElementById('product-stok').value = '';
            document.getElementById('product-status').value = 'active';
        }

        function editProduct(id, nama, kategoriId, harga, stok, status) {
            document.getElementById('product-modal-title').textContent = 'Edit Product';
            document.getElementById('product-form').action = '{{ route("admin.products.update", ":id") }}'.replace(':id', id);
            document.getElementById('product-method').value = 'PUT';
            document.getElementById('product-id').value = id;
            document.getElementById('product-nama').value = nama;
            document.getElementById('product-kategori').value = kategoriId;
            document.getElementById('product-harga').value = harga;
            document.getElementById('product-stok').value = stok;
            document.getElementById('product-status').value = status;
            
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'product-modal' }));
        }
    </script>
</x-app-layout>

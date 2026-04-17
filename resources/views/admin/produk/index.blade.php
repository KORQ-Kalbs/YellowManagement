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
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Variants</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Stock</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Status</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Actions</th>
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
                                        <button @click="editProduct({{ $product->id }}, '{{ addslashes($product->nama_produk) }}', {{ $product->kategori_id }}, {{ $product->harga }}, {{ $product->stok }}, '{{ $product->status }}', {{ $product->allVariants->toJson() }})" class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-600 transition-colors rounded-lg bg-blue-50 dark:bg-blue-900/30 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50">
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
                            <tr class="bg-[#fef3c7] dark:bg-gray-800">
                                <td colspan="7" class="px-6 py-12 text-center">
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
            <h3 class="mb-4 text-lg font-bold text-gray-900 dark:text-white" id="product-modal-title">Add Product</h3>
            
            <form id="product-form" method="POST" action="{{ route('admin.products.store') }}">
                @csrf
                <input type="hidden" id="product-method" name="_method" value="POST">
                <input type="hidden" id="product-id" name="id">

                <div class="space-y-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Product Name</label>
                        <input type="text" id="product-nama" name="nama_produk" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                        <select id="product-kategori" name="kategori_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                            <option value="">Select Category</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Image</label>
                        <input type="file" id="product-gambar" name="gambar" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                        <input type="number" id="product-harga" name="harga" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white" required min="0">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Stock</label>
                        <input type="number" id="product-stok" name="stok" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white" required min="0">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select id="product-status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <!-- Variant Management Section -->
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-600">
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Ukuran / Varian</label>
                            <button type="button" onclick="addVariantRow()" class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200 dark:bg-yellow-900/40 dark:text-yellow-300">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah Varian
                            </button>
                        </div>
                        <div id="variant-rows" class="space-y-2"></div>
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Kosongkan jika produk tidak memiliki varian ukuran.</p>
                    </div>
                </div>

                <div class="flex justify-end mt-6 space-x-3">
                    <x-secondary-button type="button" @click="$dispatch('close')">Cancel</x-secondary-button>
                    <x-primary-button type="submit">Save</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    <script>
        let variantIndex = 0;

        function addVariantRow(data = null) {
            const container = document.getElementById('variant-rows');
            const idx = variantIndex++;
            const kode = data ? data.kode_variant : '';
            const nama = data ? data.nama_variant : '';
            const harga = data ? data.harga_tambahan : '0';
            const isActive = data ? (data.is_active ? 'checked' : '') : 'checked';
            const varId = data && data.id ? data.id : '';

            const row = document.createElement('div');
            row.className = 'flex items-center gap-2 p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg';
            row.innerHTML = `
                <input type="hidden" name="variants[${idx}][id]" value="${varId}">
                <div class="flex-shrink-0 w-16">
                    <input type="text" name="variants[${idx}][kode_variant]" value="${kode}" placeholder="S/M/L" maxlength="10"
                        class="w-full px-2 py-1.5 text-xs font-bold text-center border border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                </div>
                <div class="flex-1">
                    <input type="text" name="variants[${idx}][nama_variant]" value="${nama}" placeholder="Nama (cth: Small)"
                        class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                </div>
                <div class="w-24">
                    <input type="number" name="variants[${idx}][harga_tambahan]" value="${harga}" placeholder="+Harga" min="0"
                        class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
                <label class="flex items-center gap-1 cursor-pointer flex-shrink-0">
                    <input type="checkbox" name="variants[${idx}][is_active]" value="1" ${isActive}
                        class="w-3.5 h-3.5 text-yellow-500 border-gray-300 rounded focus:ring-yellow-500">
                    <span class="text-[10px] text-gray-500">Aktif</span>
                </label>
                <button type="button" onclick="this.closest('div.flex').remove()" class="flex-shrink-0 p-1 text-red-500 hover:text-red-700 hover:bg-red-50 rounded">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            `;
            container.appendChild(row);
        }

        function clearVariantRows() {
            document.getElementById('variant-rows').innerHTML = '';
            variantIndex = 0;
        }

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
            clearVariantRows();
        }

        function editProduct(id, nama, kategoriId, harga, stok, status, variants) {
            document.getElementById('product-modal-title').textContent = 'Edit Product';
            document.getElementById('product-form').action = '{{ route("admin.products.update", ":id") }}'.replace(':id', id);
            document.getElementById('product-method').value = 'PUT';
            document.getElementById('product-id').value = id;
            document.getElementById('product-nama').value = nama;
            document.getElementById('product-kategori').value = kategoriId;
            document.getElementById('product-harga').value = harga;
            document.getElementById('product-stok').value = stok;
            document.getElementById('product-status').value = status;

            // Populate variants
            clearVariantRows();
            if (variants && variants.length > 0) {
                variants.forEach(v => addVariantRow(v));
            }
            
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'product-modal' }));
        }
    </script>
</x-app-layout>

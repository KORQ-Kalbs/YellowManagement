<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Category Management</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Organize your products by categories</p>
            </div>
            <button @click="$dispatch('open-modal', 'category-modal'); resetCategoryForm()" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kategori
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

        <!-- Categories Table -->
        <x-card noPadding="true">
            @if(isset($kategoris) && $kategoris->count() > 0)
                <x-table>
                    <x-table-head>
                        <x-table-heading>Category Name</x-table-heading>
                        <x-table-heading>Products Count</x-table-heading>
                        <x-table-heading>Actions</x-table-heading>
                    </x-table-head>
                    <x-table-body>
                        @foreach($kategoris as $kategori)
                            <x-table-row>
                                <x-table-cell>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $kategori->nama_kategori }}</span>
                                </x-table-cell>
                                <x-table-cell>
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-200">
                                        {{ $kategori->products_count }} products
                                    </span>
                                </x-table-cell>
                                <x-table-cell>
                                    <div class="flex items-center space-x-2">
                                        <button @click="editCategory({{ $kategori->id }}, '{{ addslashes($kategori->nama_kategori) }}')" class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-600 transition-colors rounded-lg bg-blue-50 dark:bg-blue-900/30 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </button>
                                        
                                        <form action="{{ route('admin.kategoris.destroy', $kategori->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 text-sm font-medium text-red-600 transition-colors rounded-lg bg-red-50 dark:bg-red-900/30 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </x-table-cell>
                            </x-table-row>
                        @endforeach
                    </x-table-body>
                </x-table>
                
                @if(method_exists($kategoris, 'links'))
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $kategoris->links() }}
                    </div>
                @endif
            @else
                <div class="py-16 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">No categories found</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Create your first category to get started</p>
                </div>
            @endif
        </x-card>
    </div>

    <!-- Category Modal -->
    <x-modal name="category-modal" :show="false">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4" id="category-modal-title">Add Category</h3>
            
            <form id="category-form" method="POST" action="{{ route('admin.kategoris.store') }}">
                @csrf
                <input type="hidden" id="category-method" name="_method" value="POST">
                <input type="hidden" id="category-id" name="id">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category Name</label>
                        <input type="text" id="category-nama" name="nama_kategori" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required>
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
        function resetCategoryForm() {
            document.getElementById('category-modal-title').textContent = 'Add Category';
            document.getElementById('category-form').action = '{{ route("admin.kategoris.store") }}';
            document.getElementById('category-method').value = 'POST';
            document.getElementById('category-id').value = '';
            document.getElementById('category-nama').value = '';
        }

        function editCategory(id, nama) {
            document.getElementById('category-modal-title').textContent = 'Edit Category';
            document.getElementById('category-form').action = '{{ route("admin.kategoris.update", ":id") }}'.replace(':id', id);
            document.getElementById('category-method').value = 'PUT';
            document.getElementById('category-id').value = id;
            document.getElementById('category-nama').value = nama;
            
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'category-modal' }));
        }
    </script>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Kelola Kategori
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Atur kategori produk di sistem
                </p>
            </div>
            <button onclick="openCreateModal()" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kategori
            </button>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Search -->
        <x-card>
            <div>
                <x-input-label for="search-kategori" value="Cari Kategori" />
                <input type="text" id="search-kategori" placeholder="Nama kategori..." class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
        </x-card>

        <!-- Categories Grid or Table -->
        @if(isset($kategoris) && $kategoris->count() > 0)
            <!-- Grid View -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($kategoris as $kategori)
                    <x-card>
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $kategori->nama }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $kategori->products_count ?? 0 }} produk
                                </p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick="editKategori({{ $kategori->id }}, '{{ $kategori->nama }}')" class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <form action="{{ route('admin.kategoris.destroy', $kategori->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @if($kategori->deskripsi)
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($kategori->deskripsi, 100) }}</p>
                        @endif
                    </x-card>
                @endforeach
            </div>
        @else
            <x-card>
                <div class="text-center py-16">
                    <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Tidak ada kategori</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Mulai dengan membuat kategori pertama</p>
                </div>
            </x-card>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    <x-modal name="kategori-modal" :show="false">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4" id="modal-title">Tambah Kategori</h3>
            
            <form id="kategori-form" action="{{ route('admin.kategoris.store') }}" method="POST">
                @csrf
                <input type="hidden" id="kategori-id" name="id">
                <input type="hidden" id="method-override" name="_method" value="POST">

                <div class="space-y-4">
                    <div>
                        <x-input-label for="modal-nama" value="Nama Kategori" />
                        <x-text-input id="modal-nama" name="nama" type="text" required />
                    </div>

                    <div>
                        <x-input-label for="modal-deskripsi" value="Deskripsi" />
                        <textarea id="modal-deskripsi" name="deskripsi" rows="3" class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <x-secondary-button onclick="closeKategoriModal()">Batal</x-secondary-button>
                    <x-primary-button type="submit">Simpan</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    <script>
        function openCreateModal() {
            document.getElementById('modal-title').textContent = 'Tambah Kategori';
            document.getElementById('kategori-form').action = '{{ route("admin.kategoris.store") }}';
            document.getElementById('method-override').value = 'POST';
            document.getElementById('kategori-id').value = '';
            document.getElementById('modal-nama').value = '';
            document.getElementById('modal-deskripsi').value = '';
            document.getElementById('kategori-modal').style.display = 'block';
        }

        function editKategori(id, nama) {
            document.getElementById('modal-title').textContent = 'Edit Kategori';
            document.getElementById('kategori-form').action = '{{ route("admin.kategoris.update", ":id") }}'.replace(':id', id);
            document.getElementById('method-override').value = 'PATCH';
            document.getElementById('kategori-id').value = id;
            document.getElementById('modal-nama').value = nama;
            document.getElementById('kategori-modal').style.display = 'block';
        }

        function closeKategoriModal() {
            document.getElementById('kategori-modal').style.display = 'none';
        }
    </script>
</x-app-layout>

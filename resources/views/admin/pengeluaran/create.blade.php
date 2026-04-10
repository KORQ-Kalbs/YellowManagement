<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Tambah Pengeluaran</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Catat pengeluaran baru untuk toko</p>
            </div>
            <a href="{{ route('admin.expenses.index') }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <x-card>
            <form method="POST" action="{{ route('admin.expenses.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-5">
                    {{-- Tanggal --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="date" value="{{ old('date', today()->format('Y-m-d')) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-yellow-400 focus:border-yellow-400">
                        @error('date') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Kategori Pengeluaran <span class="text-red-500">*</span></label>
                        <select name="category_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-yellow-400 focus:border-yellow-400">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah (Rp) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-sm font-medium text-gray-500">Rp</span>
                            <input type="number" name="amount" value="{{ old('amount') }}" required min="1" placeholder="0"
                                class="w-full py-2 pl-10 pr-3 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-yellow-400 focus:border-yellow-400">
                        </div>
                        @error('amount') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                        <textarea name="description" rows="3" placeholder="Keterangan pengeluaran (opsional)..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-yellow-400 focus:border-yellow-400 resize-none">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Attachment --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Foto Nota / Bukti</label>
                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 dark:bg-gray-700/50 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6" id="upload-placeholder">
                                    <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    <p class="text-xs text-gray-500">JPG, PNG, atau PDF (Maks. 2MB)</p>
                                </div>
                                <p class="hidden text-sm font-medium text-green-600" id="upload-filename"></p>
                                <input type="file" name="attachment" class="hidden" accept=".jpg,.jpeg,.png,.pdf"
                                    onchange="document.getElementById('upload-filename').textContent = this.files[0]?.name || ''; document.getElementById('upload-filename').classList.toggle('hidden', !this.files[0]); document.getElementById('upload-placeholder').classList.toggle('hidden', !!this.files[0]);">
                            </label>
                        </div>
                        @error('attachment') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end mt-6 space-x-3">
                    <a href="{{ route('admin.expenses.index') }}">
                        <x-secondary-button type="button">Batal</x-secondary-button>
                    </a>
                    <x-primary-button type="submit">Simpan Pengeluaran</x-primary-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>

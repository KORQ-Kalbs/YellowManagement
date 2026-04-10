<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Pengeluaran</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Ubah data pengeluaran</p>
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
            <form method="POST" action="{{ route('admin.expenses.update', $expense) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-5">
                    {{-- Tanggal --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="date" value="{{ old('date', $expense->date->format('Y-m-d')) }}" required
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
                                <option value="{{ $cat->id }}" {{ old('category_id', $expense->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah (Rp) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-sm font-medium text-gray-500">Rp</span>
                            <input type="number" name="amount" value="{{ old('amount', $expense->amount) }}" required min="1"
                                class="w-full py-2 pl-10 pr-3 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-yellow-400 focus:border-yellow-400">
                        </div>
                        @error('amount') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                        <textarea name="description" rows="3" placeholder="Keterangan pengeluaran (opsional)..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-yellow-400 focus:border-yellow-400 resize-none">{{ old('description', $expense->description) }}</textarea>
                        @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Current Attachment --}}
                    @if($expense->attachment)
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Nota Saat Ini</label>
                        <a href="{{ Storage::url($expense->attachment) }}" target="_blank"
                           class="inline-flex items-center px-3 py-2 text-sm text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                            Lihat file saat ini
                        </a>
                    </div>
                    @endif

                    {{-- New Attachment --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $expense->attachment ? 'Ganti Foto Nota' : 'Foto Nota / Bukti' }}</label>
                        <input type="file" name="attachment" accept=".jpg,.jpeg,.png,.pdf"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <p class="mt-1 text-xs text-gray-500">JPG, PNG, atau PDF (Maks. 2MB). Kosongkan jika tidak ingin mengganti.</p>
                        @error('attachment') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end mt-6 space-x-3">
                    <a href="{{ route('admin.expenses.index') }}">
                        <x-secondary-button type="button">Batal</x-secondary-button>
                    </a>
                    <x-primary-button type="submit">Update Pengeluaran</x-primary-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Pengeluaran</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Kelola pencatatan pengeluaran toko</p>
            </div>
            <div class="flex gap-2">
                <button @click="$dispatch('open-modal', 'category-modal')" onclick="resetCategoryForm()"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                    Kategori
                </button>
                <a href="{{ route('admin.expenses.create') }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-500 border border-transparent rounded-lg hover:bg-yellow-600 transition-colors shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Tambah Pengeluaran
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Filter Section --}}
        <x-card>
            <form method="GET" action="{{ route('admin.expenses.index') }}" class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="block mb-1 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="px-3 py-2 text-sm border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-yellow-400 focus:border-yellow-400">
                </div>
                <div>
                    <label class="block mb-1 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="px-3 py-2 text-sm border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-yellow-400 focus:border-yellow-400">
                </div>
                <div>
                    <label class="block mb-1 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Kategori</label>
                    <select name="category_id" class="px-3 py-2 text-sm border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-yellow-400 focus:border-yellow-400">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-slate-700 rounded-lg hover:bg-slate-800 transition-colors">
                        <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Filter
                    </button>
                    <a href="{{ route('admin.expenses.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">Reset</a>
                </div>
            </form>
        </x-card>

        {{-- Summary Card --}}
        @if(request()->hasAny(['start_date', 'end_date', 'category_id']))
        <div class="bg-gradient-to-r from-slate-800 to-slate-700 rounded-xl p-5 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-300">Total Pengeluaran (Filtered)</p>
                    <p class="mt-1 text-2xl font-bold text-white">Rp {{ number_format($totalFiltered, 0, ',', '.') }}</p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-red-500/20">
                    <svg class="w-7 h-7 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z" clip-rule="evenodd" /></svg>
                </div>
            </div>
        </div>
        @endif

        {{-- Table --}}
        <x-card noPadding="true">
            <x-table>
                <x-table-head>
                    <x-table-heading>Tanggal</x-table-heading>
                    <x-table-heading>Kategori</x-table-heading>
                    <x-table-heading>Deskripsi</x-table-heading>
                    <x-table-heading>Jumlah</x-table-heading>
                    <x-table-heading>Nota</x-table-heading>
                    <x-table-heading>Dicatat Oleh</x-table-heading>
                    <x-table-heading>Aksi</x-table-heading>
                </x-table-head>
                <x-table-body>
                    @forelse($expenses as $expense)
                        <x-table-row>
                            <x-table-cell>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $expense->date->format('d/m/Y') }}</span>
                            </x-table-cell>
                            <x-table-cell>
                                <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300">
                                    {{ $expense->category->name }}
                                </span>
                            </x-table-cell>
                            <x-table-cell>
                                <p class="text-sm text-gray-700 dark:text-gray-300 max-w-xs truncate">{{ $expense->description ?: '-' }}</p>
                            </x-table-cell>
                            <x-table-cell>
                                <span class="font-bold text-red-600 dark:text-red-400">Rp {{ number_format($expense->amount, 0, ',', '.') }}</span>
                            </x-table-cell>
                            <x-table-cell>
                                @if($expense->attachment)
                                    <a href="{{ Storage::url($expense->attachment) }}" target="_blank"
                                       class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-600 bg-blue-50 rounded hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </x-table-cell>
                            <x-table-cell>
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $expense->user->name }}</span>
                            </x-table-cell>
                            <x-table-cell>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.expenses.edit', $expense) }}" class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-600 transition-colors rounded-lg bg-blue-50 dark:bg-blue-900/30 dark:text-blue-400 hover:bg-blue-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <form action="{{ route('admin.expenses.destroy', $expense) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengeluaran ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1 text-sm font-medium text-red-600 transition-colors rounded-lg bg-red-50 dark:bg-red-900/30 dark:text-red-400 hover:bg-red-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </x-table-cell>
                        </x-table-row>
                    @empty
                        <x-table-row>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                                </svg>
                                <p class="text-lg font-semibold text-gray-600 dark:text-gray-400">Belum ada data pengeluaran</p>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-500">Klik tombol "Tambah Pengeluaran" untuk memulai</p>
                            </td>
                        </x-table-row>
                    @endforelse
                </x-table-body>
            </x-table>

            @if($expenses->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $expenses->links() }}
                </div>
            @endif
        </x-card>
    </div>

    {{-- Category Modal --}}
    <x-modal name="category-modal" :show="false">
        <div class="p-6">
            <h3 class="mb-4 text-lg font-bold text-gray-900 dark:text-white">Kelola Kategori Pengeluaran</h3>

            {{-- Add category form --}}
            <form method="POST" action="{{ route('admin.expense-categories.store') }}" class="mb-4">
                @csrf
                <div class="flex gap-2">
                    <input type="text" name="name" placeholder="Nama kategori baru..." required
                        class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-yellow-400 focus:border-yellow-400">
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 transition-colors">Tambah</button>
                </div>
            </form>

            {{-- Category list --}}
            <div class="space-y-2 max-h-64 overflow-y-auto">
                @foreach($categories as $cat)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $cat->name }}</p>
                            <p class="text-xs text-gray-500">{{ $cat->expenses()->count() }} pengeluaran</p>
                        </div>
                        @if($cat->expenses()->count() === 0)
                        <form method="POST" action="{{ route('admin.expense-categories.destroy', $cat) }}" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1 text-red-500 hover:text-red-700 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                        </form>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end mt-4">
                <x-secondary-button @click="$dispatch('close')">Tutup</x-secondary-button>
            </div>
        </div>
    </x-modal>

    <script>
        function resetCategoryForm() {}
    </script>
</x-app-layout>

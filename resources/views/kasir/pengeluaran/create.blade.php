<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold app-text">Catat Pengeluaran (Petty Cash)</h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-3xl">
            <x-card>
                <form action="{{ route('kasir.expenses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="category_id" class="w-full p-2 border rounded">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jumlah (Rp)</label>
                            <input type="number" name="amount" required min="0" class="w-full p-2 border rounded" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                            <input type="text" name="description" class="w-full p-2 border rounded" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lampiran (opsional)</label>
                            <input type="file" name="attachment" class="w-full" />
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="submit" class="px-4 py-2 font-semibold text-white bg-green-600 rounded">Simpan Pengeluaran</button>
                            <a href="{{ route('kasir.dashboard') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded">Batal</a>
                        </div>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>

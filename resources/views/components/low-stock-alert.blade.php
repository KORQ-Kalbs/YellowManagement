@props([
    'products',
    'show' => true,
    'dismissRoute' => null,
    'title' => 'Peringatan Stok Rendah',
    'subtitle' => 'Beberapa produk sudah mendekati batas minimum stok.',
])

@if($show && $products->count())
    <div class="mb-6 overflow-hidden border border-amber-200 rounded-2xl shadow-sm bg-gradient-to-r from-amber-50 via-yellow-50 to-orange-50 dark:from-amber-950/40 dark:via-yellow-950/30 dark:to-orange-950/30 dark:border-amber-900/60">
        <div class="px-5 py-4 sm:px-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div class="flex items-start gap-4">
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-full bg-amber-500/10 text-amber-700 dark:text-amber-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        </svg>
                    </div>

                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="text-base font-bold text-amber-900 dark:text-amber-100">{{ $title }}</h3>
                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-200">
                                {{ $products->count() }} produk
                            </span>
                        </div>
                        <p class="mt-1 text-sm text-amber-800/90 dark:text-amber-100/80">{{ $subtitle }}</p>

                        <div class="grid gap-2 mt-4 sm:grid-cols-2 xl:grid-cols-3">
                            @foreach($products->take(6) as $product)
                                <div class="flex items-center justify-between gap-3 px-3 py-2 rounded-xl bg-white/80 dark:bg-gray-900/40 border border-amber-100 dark:border-amber-900/50">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $product->nama_produk }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $product->kategori?->nama_kategori ?? 'Tanpa kategori' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold {{ $product->stok <= 0 ? 'text-red-600 dark:text-red-400' : 'text-amber-700 dark:text-amber-300' }}">
                                            {{ $product->stok <= 0 ? 'Habis' : $product->stok }}
                                        </p>
                                        <p class="text-[10px] uppercase tracking-wide text-gray-500 dark:text-gray-400">stok</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($products->count() > 6)
                            <p class="mt-3 text-xs text-amber-800/80 dark:text-amber-100/70">+{{ $products->count() - 6 }} produk lainnya juga berada di batas rendah.</p>
                        @endif
                    </div>
                </div>

                @if($dismissRoute)
                    <form method="POST" action="{{ $dismissRoute }}" class="flex-shrink-0">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white transition-colors rounded-lg shadow-sm bg-amber-600 hover:bg-amber-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Sembunyikan hari ini
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endif
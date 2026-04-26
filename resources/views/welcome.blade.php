<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ data_get($welcomeSettings, 'brand_name', 'Yellow Drink') }} - Semua Berhak Minum Enak</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="overflow-x-hidden bg-[#311f08] text-[#F2E8D0] [font-family:'DM_Sans',sans-serif]">
    @php
        $welcome = $welcomeSettings ?? \App\Models\DashboardSetting::defaultsForPage('welcome');
        $featuredProducts = ($menuProducts ?? collect())->take(4);
        $heroImage = asset(data_get($welcome, 'hero_image', 'images/drink.png'));
        $bannerImage = asset(data_get($welcome, 'banner_image', 'images/banner.png'));
        $aboutImage = asset(data_get($welcome, 'about_image', 'images/banner.png'));
        $activeDiscountLabel = $activeDiscount ? $activeDiscount->name . ' - ' . floatval($activeDiscount->discount_percentage) . '% OFF' : null;
    @endphp

    <nav class="fixed inset-x-0 top-0 z-50 flex items-center justify-between bg-gradient-to-b from-[#1A1208]/95 to-transparent px-6 py-5 lg:px-16">
        <div class="text-2xl font-bold tracking-wide text-[#F5C518] [font-family:'Playfair_Display',serif]">{{ data_get($welcome, 'brand_name', 'Yellow Drink') }}</div>
        <ul class="items-center hidden gap-8 text-sm tracking-wider md:flex">
            <li><a href="#menu" class="transition-colors hover:text-[#F5C518]">Menu</a></li>
            <li><a href="#about" class="transition-colors hover:text-[#F5C518]">Tentang</a></li>
            <li><a href="#location" class="transition-colors hover:text-[#F5C518]">Lokasi</a></li>
        </ul>
        <a href="/login" class="rounded-full bg-[#F5C518] px-5 py-2.5 text-sm font-medium text-[#311f08] transition hover:scale-105 hover:bg-white">Login Kasir</a>
    </nav>

    <section class="relative flex items-end min-h-screen overflow-hidden">
        <div class="absolute inset-0 bg-[#1A1208] [background-image:linear-gradient(160deg,rgba(26,18,8,0.55)_0%,rgba(26,18,8,0.1)_50%,rgba(26,18,8,0.7)_100%),radial-gradient(ellipse_at_70%_40%,rgba(245,197,24,0.08)_0%,transparent_60%)]"></div>
        <div class="pointer-events-none absolute right-[5%] top-[10%] h-[520px] w-[520px] rounded-full bg-[radial-gradient(circle,rgba(245,197,24,0.15)_0%,transparent_70%)]"></div>

        @if($activeDiscountLabel)
            <div class="fixed z-[60] max-w-md px-4 py-3 text-sm border shadow-lg bottom-4 right-4 rounded-2xl border-amber-200 bg-amber-50/95 text-amber-900 backdrop-blur dark:border-amber-900/60 dark:bg-amber-950/55 dark:text-amber-100 lg:bottom-6 lg:right-6">
                <div class="font-semibold">Discount active</div>
                <div>{{ $activeDiscountLabel }}</div>
            </div>
        @endif

        <div class="absolute bottom-20 right-[20%] flex w-[clamp(220px,28vw,500px)] items-end justify-center">
            <div class="pointer-events-none absolute bottom-0 left-1/2 h-[60%] w-[80%] -translate-x-1/2 bg-[radial-gradient(ellipse_at_center_bottom,rgba(245,197,24,0.18)_0%,transparent_70%)]"></div>
            <img src="{{ $heroImage }}" alt="{{ data_get($welcome, 'brand_name', 'Yellow Drink') }}" class="relative z-10 w-full drop-shadow-[0_30px_40px_rgba(0,0,0,0.5)]" />
        </div>

        <div class="relative z-10 max-w-2xl px-6 pb-40 lg:px-16">
            <span class="mb-6 inline-block rounded-full border border-[#F5C518]/40 px-4 py-1.5 text-xs font-medium uppercase tracking-[0.15em] text-[#F5C518]">{{ data_get($welcome, 'hero_badge', 'Minuman Kekinian Terbaik') }}</span>
            <h1 class="mb-6 text-5xl font-black leading-[1.05] text-[#F5EDD6] lg:text-7xl [font-family:'Playfair_Display',serif]">
                {{ data_get($welcome, 'hero_title', 'Segarnya Rasa') }}<br />
                <em class="italic text-[#F5C518]">{{ data_get($welcome, 'hero_highlight', 'Temani') }}</em><br />
                {{ data_get($welcome, 'hero_title_suffix', 'Setiap Cerita') }}
            </h1>
            <p class="mb-10 max-w-lg text-base leading-8 text-[#9E8A6E] lg:text-[1.05rem]">
                {{ data_get($welcome, 'hero_subtitle', 'Minuman berkualitas, harga ramah di kantong. Karena semua berhak minum enak.') }}
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ data_get($welcome, 'hero_primary_link', '#menu') }}" class="rounded-full bg-[#F5C518] px-8 py-3.5 text-sm font-medium tracking-wide text-[#311f08] transition hover:-translate-y-0.5 hover:bg-white">{{ data_get($welcome, 'hero_primary_label', 'Lihat Menu') }}</a>
                <a href="{{ data_get($welcome, 'hero_secondary_link', '#location') }}" class="rounded-full border border-[#F2E8D0]/30 px-8 py-3.5 text-sm tracking-wide text-[#F2E8D0] transition hover:border-[#F5C518] hover:text-[#F5C518]">{{ data_get($welcome, 'hero_secondary_label', 'Temukan Toko') }}</a>
            </div>
        </div>

        <div class="absolute inset-x-0 bottom-0 z-10 hidden border-t border-[#F5C518]/10 bg-[#1A1208]/70 backdrop-blur-xl md:flex">
            @foreach(data_get($welcome, 'stats', []) as $stat)
                <div class="flex-1 border-r border-[#F5C518]/10 px-8 py-5 last:border-r-0">
                    <div class="text-3xl font-bold leading-none text-[#F5C518] [font-family:'Playfair_Display',serif]">{{ data_get($stat, 'value', '-') }}</div>
                    <div class="mt-1 text-xs leading-5 text-[#9E8A6E]">{{ data_get($stat, 'label', '') }}<br />{{ data_get($stat, 'detail', '') }}</div>
                </div>
            @endforeach
        </div>
    </section>

    @if($activeDiscount)
        <section class="px-6 py-5 border-y border-amber-200 bg-amber-50 text-amber-950 lg:px-16 dark:border-amber-900/60 dark:bg-amber-950/40 dark:text-amber-100">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-700 dark:text-amber-300">Promo Hari Ini</p>
                    <h2 class="text-2xl font-bold">{{ $activeDiscount->name }}</h2>
                    <p class="text-sm text-amber-900/80 dark:text-amber-100/80">{{ $activeDiscount->description ?? 'Discount event is active.' }}</p>
                </div>
                <div class="px-4 py-2 text-sm font-semibold text-white rounded-full bg-amber-600">-{{ floatval($activeDiscount->discount_percentage) }}%</div>
            </div>
        </section>
    @endif

    <section class="bg-[#FBF6EC] px-6 py-20 lg:px-16" aria-label="Mengapa Memilih Kami">
        <span class="mb-2 block text-xs font-medium uppercase tracking-[0.15em] text-[#5C3D1E]">{{ data_get($welcome, 'feature_section_title', 'Kenapa Yellow Drink?') }}</span>
        <h2 class="mb-14 text-4xl font-bold text-[#311f08] [font-family:'Playfair_Display',serif] lg:text-5xl">{{ data_get($welcome, 'feature_section_title', 'Kenapa Yellow Drink?') }}</h2>
        <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
            @foreach(data_get($welcome, 'features', []) as $feature)
                <div class="rounded-2xl border border-[#5C3D1E]/10 bg-white p-8 transition hover:-translate-y-1.5 hover:shadow-[0_20px_40px_rgba(92,61,30,0.1)]">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-[#F5C518] text-2xl">{{ data_get($feature, 'emoji', '✨') }}</div>
                    <h3 class="mb-2 text-xl font-bold text-[#311f08] [font-family:'Playfair_Display',serif]">{{ data_get($feature, 'title', 'Fitur') }}</h3>
                    <p class="text-sm leading-7 text-[#6B5C47]">{{ data_get($feature, 'description', '') }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section id="menu" class="bg-[#422b0e] px-6 py-20 lg:px-16">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-12">
            <div>
                <h2 class="text-4xl font-bold text-[#F5EDD6] [font-family:'Playfair_Display',serif] lg:text-5xl">{{ data_get($menuSettings, 'page_intro_title', 'Menu Terfavorit') }}</h2>
                <p class="mt-2 max-w-2xl text-sm leading-7 text-[#9E8A6E]">{{ data_get($menuSettings, 'page_intro_subtitle', 'Produk di bawah ini diambil langsung dari data produk.') }}</p>
            </div>
            @if($activeDiscount)
                <span class="inline-flex items-center gap-1 rounded-full border border-[#F5C518]/35 bg-[#F5C518]/10 px-4 py-2 text-xs font-medium uppercase tracking-widest text-[#F5C518]">Discount active</span>
            @endif
        </div>

        <div id="menu-grid" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @forelse($featuredProducts as $product)
                @php
                    $priceCandidates = collect([$product->harga])
                        ->merge($product->variants->pluck('harga_tambahan')->map(fn ($price) => $product->harga + $price));
                    $minPrice = $priceCandidates->min();
                    $maxPrice = $priceCandidates->max();
                    $imagePath = $product->productImage?->url ?? ($product->gambar_produk ? asset($product->gambar_produk) : asset('images/drink.png'));
                @endphp
                <article class="group overflow-hidden rounded-[20px] border border-[#F5C518]/10 bg-white/5 transition hover:-translate-y-2 hover:border-[#F5C518]/40 hover:bg-white/[0.07]">
                    <div class="relative overflow-hidden h-52">
                        <img src="{{ $imagePath }}" alt="{{ $product->nama_produk }}" class="object-cover w-full h-full transition duration-500 group-hover:scale-105" />
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#311f08]/80 via-transparent to-transparent"></div>
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-[#311f08]/25 via-transparent to-transparent"></div>
                        <span class="absolute right-3 top-3 rounded-full border border-[#F5C518]/20 bg-[#1A1208]/85 px-2.5 py-1 text-[0.72rem] text-[#F5C518]">{{ $product->kategori?->nama_kategori ?? 'Menu' }}</span>
                        <span class="absolute bottom-3 left-3 text-lg font-bold text-[#F5C518] drop-shadow-[0_2px_8px_rgba(0,0,0,0.4)] [font-family:'Playfair_Display',serif]">Rp {{ number_format($minPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="p-4">
                        <h3 class="mb-1 text-lg font-bold text-[#F5EDD6] [font-family:'Playfair_Display',serif]">{{ $product->nama_produk }}</h3>
                        <p class="text-xs leading-6 text-[#9E8A6E]">Stok {{ $product->stok }} &middot; {{ $product->variants->count() ? $product->variants->count() . ' varian aktif' : 'Tanpa varian' }}</p>
                        @if($maxPrice > $minPrice)
                            <p class="mt-2 text-xs text-[#F5C518]/80">Rp {{ number_format($minPrice, 0, ',', '.') }} - Rp {{ number_format($maxPrice, 0, ',', '.') }}</p>
                        @endif
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-3xl border border-white/10 bg-white/5 p-10 text-center text-[#F2E8D0]">
                    <h3 class="text-2xl font-bold [font-family:'Playfair_Display',serif]">{{ data_get($menuSettings, 'empty_title', 'Belum ada produk aktif') }}</h3>
                    <p class="mt-2 text-sm text-[#9E8A6E]">{{ data_get($menuSettings, 'empty_message', 'Tambahkan produk aktif di admin product management untuk menampilkan menu di sini.') }}</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12 text-center">
            <a href="{{ data_get($menuSettings, 'cta_link', '/') }}" class="inline-block rounded-full border border-[#F5C518]/50 px-10 py-3.5 text-sm font-medium text-[#F5C518] transition hover:-translate-y-0.5 hover:bg-[#F5C518] hover:text-[#311f08]">{{ data_get($menuSettings, 'cta_label', 'Lihat Beranda') }}</a>
        </div>
    </section>

    <section id="about" class="bg-[#FBF6EC] px-6 py-20 lg:px-16">
        <div class="grid items-center max-w-6xl gap-16 mx-auto lg:grid-cols-2">
            <div class="relative">
                <div class="pointer-events-none absolute -left-4 -top-4 h-20 w-20 rounded-full border-2 border-[#F5C518]/35"></div>
                <div class="pointer-events-none absolute -left-2 -top-2 h-14 w-14 rounded-full border border-[#F5C518]/20"></div>
                <div class="overflow-hidden rounded-3xl">
                    <img src="{{ $bannerImage }}" alt="{{ data_get($welcome, 'brand_name', 'Yellow Drink') }}" class="aspect-[4/5] w-full object-cover" />
                    <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(160deg,rgba(245,197,24,0.08)_0%,transparent_40%,rgba(49,31,8,0.35)_100%)]"></div>
                </div>
                <div class="absolute -bottom-5 -right-5 flex h-28 w-28 flex-col items-center justify-center rounded-full bg-[#F5C518] text-[#311f08] shadow-[0_12px_30px_rgba(245,197,24,0.35)]">
                    <strong class="text-3xl font-black leading-none [font-family:'Playfair_Display',serif]">{{ data_get($welcome, 'about_badge_value', '100%') }}</strong>
                    <span class="text-xs font-medium">{{ data_get($welcome, 'about_badge_label', 'Terjangkau') }}</span>
                </div>
            </div>
            <div>
                <span class="mb-2 block text-xs font-medium uppercase tracking-[0.15em] text-[#5C3D1E]">{{ data_get($welcome, 'about_badge', 'Tentang Kami') }}</span>
                <h2 class="mb-6 text-4xl font-black leading-tight text-[#311f08] [font-family:'Playfair_Display',serif] lg:text-5xl">{!! nl2br(e(data_get($welcome, 'about_title', 'Yellow Drink,\nRasa yang Bicara'))) !!}</h2>
                <p class="mb-6 text-[0.95rem] leading-8 text-[#5C4430]">{{ data_get($welcome, 'about_body_1', '') }}</p>
                <p class="mb-8 text-[0.95rem] leading-8 text-[#5C4430]">{{ data_get($welcome, 'about_body_2', '') }}</p>
                <div class="space-y-4 text-sm font-medium text-[#311f08]">
                    @foreach(data_get($welcome, 'about_points', []) as $point)
                        <div class="flex items-center gap-3"><span class="h-2 w-2 rounded-full bg-[#F5C518]"></span>{{ $point }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="location" class="bg-[#311f08] px-6 py-20 lg:px-16">
        <span class="mb-2 block text-center text-xs font-medium uppercase tracking-[0.15em] text-[#F5C518]">{{ data_get($welcome, 'location_badge', 'Kunjungi Kami') }}</span>
        <h2 class="mb-14 text-center text-4xl font-bold text-[#F5EDD6] [font-family:'Playfair_Display',serif] lg:text-5xl">{{ data_get($welcome, 'location_title', 'Lokasi Toko') }}</h2>
        <div class="grid max-w-6xl gap-10 mx-auto lg:grid-cols-2">
            <div class="h-[360px] overflow-hidden rounded-3xl border border-[#F5C518]/12 bg-white/5">
                <iframe src="{{ data_get($welcome, 'location_map_embed', 'https://www.google.com/maps?q=-6.573796898904178,106.7601842828633&output=embed') }}" class="w-full h-full" style="border:0;" loading="lazy"></iframe>
            </div>
            <div class="space-y-8 rounded-3xl border border-[#F5C518]/12 bg-white/5 p-10">
                <div class="flex items-start gap-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#F5C518]/12 text-lg">📍</div>
                    <div>
                        <h4 class="mb-1 text-xs tracking-wider text-[#9E8A6E]">ALAMAT</h4>
                        <p class="text-sm leading-7 text-[#F2E8D0]">{!! nl2br(e(data_get($welcome, 'location_address', ''))) !!}</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#F5C518]/12 text-lg">🕐</div>
                    <div>
                        <h4 class="mb-1 text-xs tracking-wider text-[#9E8A6E]">JAM OPERASIONAL</h4>
                        <p class="text-sm leading-7 text-[#F2E8D0]">{!! nl2br(e(data_get($welcome, 'location_hours', ''))) !!}</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#F5C518]/12 text-lg">📞</div>
                    <div>
                        <h4 class="mb-1 text-xs tracking-wider text-[#9E8A6E]">KONTAK</h4>
                        <p class="text-sm leading-7 text-[#F2E8D0]"><a href="tel:{{ data_get($welcome, 'location_phone', '') }}" class="text-[#F5C518] hover:underline">{{ data_get($welcome, 'location_phone', '') }}</a><br /><a href="mailto:{{ data_get($welcome, 'location_email', '') }}" class="text-[#F5C518] hover:underline">{{ data_get($welcome, 'location_email', '') }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="flex flex-wrap items-center justify-between gap-4 border-t border-[#F5C518]/10 bg-[#422b0e] px-6 py-8 lg:px-16">
        <div class="text-xl font-bold text-[#F5C518] [font-family:'Playfair_Display',serif]">{{ data_get($welcome, 'brand_name', 'Yellow Drink') }}</div>
        <p class="text-sm text-[#9E8A6E]">{{ data_get($welcome, 'footer_note', '© 2025 Yellow Drink. Semua Berhak Minum Enak.') }}</p>
        <div class="flex gap-3">
            <a href="#" class="flex h-9 w-9 items-center justify-center rounded-full border border-[#F5C518]/25 text-xs text-[#9E8A6E] transition hover:border-[#F5C518] hover:text-[#F5C518]">f</a>
            <a href="#" class="flex h-9 w-9 items-center justify-center rounded-full border border-[#F5C518]/25 text-xs text-[#9E8A6E] transition hover:border-[#F5C518] hover:text-[#F5C518]">ig</a>
            <a href="#" class="flex h-9 w-9 items-center justify-center rounded-full border border-[#F5C518]/25 text-xs text-[#9E8A6E] transition hover:border-[#F5C518] hover:text-[#F5C518]">tw</a>
        </div>
    </footer>
</body>
</html>
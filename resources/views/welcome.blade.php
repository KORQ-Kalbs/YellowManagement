<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ data_get($welcomeSettings, 'brand_name', 'Yellow Drink') }} - Sistem Kasir & Laporan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,700;0,9..144,900;1,9..144,700;1,9..144,900&family=Cabinet+Grotesk:wght@400;500;700;800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Cabinet Grotesk', sans-serif; cursor: none; }
        h1, h2, h3, .font-display { font-family: 'Fraunces', serif; }
        #cursor { mix-blend-mode: multiply; transition: width .25s, height .25s, background .25s; }
        #cursor.big { width: 56px !important; height: 56px !important; }
        @keyframes floaty { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-18px)} }
        @keyframes floaty2 { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        @keyframes pulse-dot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.65)} }
        @keyframes spin { to{transform:translate(-50%,-50%) rotate(360deg)} }
        @keyframes marquee { from{transform:translateX(0)} to{transform:translateX(-50%)} }
        .drink-float { animation: floaty 4s ease-in-out infinite; }
        .pill-float  { animation: floaty2 5s ease-in-out infinite; }
        .pill-float2 { animation: floaty2 5s ease-in-out infinite 1.5s; }
        .badge-dot   { animation: pulse-dot 2s infinite; }
        .ring-spin   { animation: spin 18s linear infinite; }
        .marquee-track { animation: marquee 18s linear infinite; width: max-content; }
        .hero-ring   { border-radius:50%; border:2px solid rgba(0,0,0,.08); position:absolute; pointer-events:none; top:50%; left:50%; transform:translate(-50%,-50%); }
        .hero-clip   { clip-path: polygon(12% 0, 100% 0, 100% 100%, 0% 100%); }
        .underline-y::after { content:''; display:block; height:4px; width:70%; background:#C9A800; border-radius:2px; margin-top:4px; }
        .why-card:hover { background: #FFF176; }
        .menu-card:hover { transform: translateY(-8px) rotate(-1deg); }
        .about-decor::before { content:''; position:absolute; inset:24px -24px -24px 24px; background:#FFD600; border-radius:24px; z-index:0; }
    </style>
</head>
<body class="overflow-x-hidden bg-[#FFFEF5] text-[#1A1600]">

    @php
        $welcome = $welcomeSettings ?? \App\Models\DashboardSetting::defaultsForPage('welcome');
        $featuredProducts = ($menuProducts ?? collect())->take(4);
        $heroImage = asset(data_get($welcome, 'hero_image', 'images/drink.png'));
        $bannerImage = asset(data_get($welcome, 'banner_image', 'images/banner.png'));
        $activeDiscountLabel = $activeDiscount ? $activeDiscount->name . ' - ' . floatval($activeDiscount->discount_percentage) . '% OFF' : null;
    @endphp

    <!-- CURSOR -->
    <div id="cursor" class="pointer-events-none fixed z-[9999] h-3 w-3 -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#FFD600]"></div>

    <!-- NAV -->
    <nav class="fixed inset-x-0 top-0 z-50 flex items-center justify-between border-b border-[#FFD600]/18 bg-white/85 px-6 py-5 backdrop-blur-xl lg:px-14">
        <div class="font-display text-2xl font-black tracking-tight text-[#1A1600]">
            Yellow<span class="text-[#C9A800]">.</span>
        </div>
        <ul class="hidden items-center gap-8 text-xs font-bold uppercase tracking-[.09em] text-[#4A3F00] md:flex">
            <li><a href="#menu"     class="transition-colors hover:text-[#1A1600]">Menu</a></li>
            <li><a href="#about"    class="transition-colors hover:text-[#1A1600]">Tentang</a></li>
            <li><a href="#location" class="transition-colors hover:text-[#1A1600]">Lokasi</a></li>
        </ul>
        <a href="/login" class="rounded-full bg-[#1A1600] px-5 py-2.5 text-xs font-extrabold tracking-wide text-[#FFD600] transition hover:bg-[#FFD600] hover:text-[#1A1600]">
            Login Kasir
        </a>
    </nav>

    <!-- HERO -->
    <section class="grid min-h-screen grid-cols-1 overflow-hidden lg:grid-cols-2">

        <!-- Left: cream panel -->
        <div class="relative flex flex-col justify-end bg-white px-6 pb-20 pt-36 lg:px-14 lg:pb-24">
            <!-- yellow arc corner -->
            <div class="pointer-events-none absolute -top-20 -right-20 h-64 w-64 rounded-full bg-[#FFD600]"></div>

            <span class="relative z-10 mb-7 inline-flex w-fit items-center gap-2 rounded-full bg-[#FFD600] px-4 py-2 text-[.68rem] font-extrabold uppercase tracking-[.2em] text-[#1A1600]">
                <span class="badge-dot h-1.5 w-1.5 rounded-full bg-[#1A1600]"></span>
                {{ data_get($welcome, 'hero_badge', 'Sistem Kasir & Laporan Keuangan') }}
            </span>

            <h1 class="relative z-10 mb-6 font-display text-[clamp(2.8rem,5vw,4.8rem)] font-black leading-[1.04] tracking-tight text-[#1A1600]">
                {{ data_get($welcome, 'hero_title', 'Kelola Toko') }}<br />
                <em class="underline-y italic text-[#C9A800]">{{ data_get($welcome, 'hero_highlight', 'Lebih Mudah') }}</em><br />
                {{ data_get($welcome, 'hero_title_suffix', 'Setiap Hari') }}
            </h1>

            <p class="relative z-10 mb-9 max-w-sm text-[.92rem] leading-[1.95] text-[#4A3F00]">
                {{ data_get($welcome, 'hero_subtitle', 'Transaksi tercatat otomatis, laporan keuangan tersedia real-time, dan stok terpantau dari satu dasbor.') }}
            </p>

            <div class="relative z-10 flex flex-wrap gap-3">
                <a href="{{ data_get($welcome, 'hero_primary_link', '/login') }}"
                   class="rounded-full bg-[#1A1600] px-8 py-3.5 text-[.82rem] font-extrabold text-[#FFD600] transition hover:-translate-y-0.5 hover:bg-[#2A2800]">
                    {{ data_get($welcome, 'hero_primary_label', 'Masuk ke Kasir') }}
                </a>
                <a href="{{ data_get($welcome, 'hero_secondary_link', '#location') }}"
                   class="rounded-full border-2 border-[#1A1600] px-8 py-3.5 text-[.82rem] font-bold text-[#1A1600] transition hover:-translate-y-0.5 hover:bg-[#1A1600] hover:text-[#FFD600]">
                    {{ data_get($welcome, 'hero_secondary_label', 'Temukan Toko') }}
                </a>
            </div>
        </div>

        <!-- Right: yellow panel -->
        <div class="relative flex min-h-[50vh] items-center justify-center overflow-hidden bg-[#FFD600] lg:min-h-0">
            <!-- dot grid -->
            <div class="pointer-events-none absolute inset-0 opacity-20"
                 style="background-image:radial-gradient(circle,#000 1px,transparent 1px);background-size:28px 28px;"></div>

            <!-- circle rings -->
            <div class="hero-ring h-[600px] w-[600px]"></div>
            <div class="hero-ring h-[420px] w-[420px]"></div>
            <div class="hero-ring h-[240px] w-[240px]"></div>

            <!-- rotating text SVG -->
            <svg class="ring-spin pointer-events-none absolute left-1/2 top-1/2 h-[280px] w-[280px] opacity-25"
                 viewBox="0 0 280 280" xmlns="http://www.w3.org/2000/svg">
                <defs><path id="c" d="M140,140 m-100,0 a100,100 0 1,1 200,0 a100,100 0 1,1 -200,0"/></defs>
                <text font-family="Cabinet Grotesk" font-size="13" font-weight="800" letter-spacing="4" fill="#000">
                    <textPath href="#c">YELLOW DRINK · KASIR DIGITAL · YELLOW DRINK · LAPORAN KEUANGAN ·</textPath>
                </text>
            </svg>

            <!-- floating stat pills -->
            <div class="pill-float absolute left-[8%] top-[22%] z-10 rounded-2xl bg-[#1A1600] px-4 py-3 text-[.78rem] font-bold text-[#FFD600]">
                <strong class="font-display block text-[1.1rem] font-black leading-none">Real-time</strong>
                Laporan
            </div>
            <div class="pill-float2 absolute bottom-[28%] right-[6%] z-10 rounded-2xl bg-[#1A1600] px-4 py-3 text-[.78rem] font-bold text-[#FFD600]">
                <strong class="font-display block text-[1.1rem] font-black leading-none">10+</strong>
                Variasi
            </div>

            <!-- drink image -->
            <img src="{{ $heroImage }}" alt="{{ data_get($welcome, 'brand_name', 'Yellow Drink') }}"
                 class="drink-float relative z-10 w-[clamp(180px,22vw,380px)] drop-shadow-[0_40px_60px_rgba(0,0,0,.15)]" />
        </div>
    </section>

    <!-- MARQUEE -->
    <div class="overflow-hidden bg-[#1A1600] py-3.5" aria-hidden="true">
        <div class="marquee-track flex gap-0">
            @foreach(array_fill(0, 3, ['Kasir Digital','Laporan Harian','Manajemen Stok','Diskon & Promo','Multi Varian','Yellow Drink POS']) as $group)
                @foreach($group as $word)
                    <span class="font-display whitespace-nowrap px-8 text-base italic text-[#FFD600] after:ml-8 after:text-[.7rem] after:opacity-50 after:content-['✦']">{{ $word }}</span>
                @endforeach
            @endforeach
        </div>
    </div>

    <!-- ACTIVE DISCOUNT BANNER -->
    @if($activeDiscount)
        <section class="border-y border-amber-200 bg-amber-50 px-6 py-5 text-amber-950 lg:px-14">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[.18em] text-amber-700">Promo Hari Ini</p>
                    <h2 class="font-display text-2xl font-bold">{{ $activeDiscount->name }}</h2>
                    <p class="text-sm text-amber-900/80">{{ $activeDiscount->description ?? 'Discount event is active.' }}</p>
                </div>
                <div class="w-fit rounded-full bg-amber-600 px-4 py-2 text-sm font-bold text-white">
                    -{{ floatval($activeDiscount->discount_percentage) }}%
                </div>
            </div>
        </section>
    @endif

    <!-- WHY US -->
    <section class="bg-[#FFFEF5] px-6 py-24 lg:px-14" aria-label="Fitur Sistem">
        <span class="mb-3 block text-[.68rem] font-extrabold uppercase tracking-[.22em] text-[#8A7A20]">Fitur Utama Sistem</span>
        <h2 class="font-display mb-14 text-[clamp(2rem,4vw,3.2rem)] font-black tracking-tight text-[#1A1600]">
            {{ data_get($welcome, 'feature_section_title', 'Apa yang bisa dilakukan') }}
        </h2>
        <div class="grid gap-0.5 overflow-hidden rounded-3xl border border-black/[.06] bg-black/[.06] md:grid-cols-2 xl:grid-cols-3">
            @foreach(data_get($welcome, 'features', []) as $i => $feature)
                <div class="why-card relative bg-[#FFFEF5] p-11 transition-colors duration-200">
                    <div class="font-display mb-4 text-[3.5rem] font-black leading-none tracking-tight text-black/[.06]">
                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    <span class="mb-5 block text-[1.8rem]">{{ data_get($feature, 'emoji', '✨') }}</span>
                    <h3 class="font-display mb-2.5 text-xl font-bold text-[#1A1600]">{{ data_get($feature, 'title', 'Fitur') }}</h3>
                    <p class="text-[.84rem] leading-[1.85] text-[#4A3F00]">{{ data_get($feature, 'description', '') }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- MENU -->
    <section id="menu" class="relative overflow-hidden bg-[#FFD600] px-6 py-24 lg:px-14">
        <!-- big watermark -->
        <div class="font-display pointer-events-none absolute -bottom-10 -right-5 select-none text-[22rem] font-black leading-none text-black/[.04]">15+</div>

        <div class="relative z-10 mb-12 flex flex-wrap items-end justify-between gap-4">
            <div>
                <span class="mb-3 block text-[.68rem] font-extrabold uppercase tracking-[.22em] text-[#8A7A20]">
                    Pilihan Terbaik Kami
                </span>
                <h2 class="font-display text-[clamp(2rem,4vw,3.2rem)] font-black tracking-tight text-[#1A1600]">
                    {{ data_get($menuSettings, 'page_intro_title', 'Menu Terfavorit') }}
                </h2>
                @if(data_get($menuSettings, 'page_intro_subtitle'))
                    <p class="mt-2 max-w-lg text-sm leading-7 text-[#4A3F00]">
                        {{ data_get($menuSettings, 'page_intro_subtitle') }}
                    </p>
                @endif
            </div>
            @if($activeDiscount)
                <span class="rounded-full bg-[#1A1600] px-5 py-2 text-[.72rem] font-extrabold uppercase tracking-[.1em] text-[#FFD600]">
                    ⭐ Discount Active
                </span>
            @else
            @endif
        </div>

        <div class="relative z-10 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @forelse($featuredProducts as $product)
                @php
                    $priceCandidates = collect([$product->harga])
                        ->merge($product->variants->pluck('harga_tambahan')->map(fn($p) => $product->harga + $p));
                    $minPrice = $priceCandidates->min();
                    $maxPrice = $priceCandidates->max();
                    $imagePath = $product->productImage?->url
                        ?? ($product->gambar_produk ? asset($product->gambar_produk) : asset('images/drink.png'));
                @endphp
                <article class="menu-card overflow-hidden rounded-[20px] border border-[#FFD600]/10 bg-white shadow-sm transition duration-300 hover:shadow-2xl">
                    <div class="relative h-52 overflow-hidden">
                        <img src="{{ $imagePath }}" alt="{{ $product->nama_produk }}"
                             class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#0F0E0A]/60 to-transparent"></div>
                        <span class="absolute right-3 top-3 rounded-full bg-[#FFD600] px-3 py-1 text-[.72rem] font-extrabold text-[#1A1600]">
                            {{ $product->kategori?->nama_kategori ?? 'Menu' }}
                        </span>
                        <span class="font-display absolute bottom-3 left-3 text-lg font-black text-[#FFD600] drop-shadow-[0_2px_8px_rgba(0,0,0,.4)]">
                            Rp {{ number_format($minPrice, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="p-5">
                        <h3 class="font-display mb-1.5 text-lg font-bold text-[#1A1600]">{{ $product->nama_produk }}</h3>
                        <p class="text-xs leading-6 text-[#8A7A20]">
                            Stok {{ $product->stok }} &middot;
                            {{ $product->variants->count() ? $product->variants->count().' varian aktif' : 'Tanpa varian' }}
                        </p>
                        @if($maxPrice > $minPrice)
                            <p class="mt-2 text-xs font-semibold text-[#C9A800]">
                                Rp {{ number_format($minPrice, 0, ',', '.') }} – Rp {{ number_format($maxPrice, 0, ',', '.') }}
                            </p>
                        @endif
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-3xl border border-black/10 bg-white/60 p-10 text-center">
                    <h3 class="font-display text-2xl font-bold text-[#1A1600]">
                        {{ data_get($menuSettings, 'empty_title', 'Belum ada produk aktif') }}
                    </h3>
                    <p class="mt-2 text-sm text-[#8A7A20]">
                        {{ data_get($menuSettings, 'empty_message', 'Tambahkan produk aktif di admin product management untuk menampilkan menu di sini.') }}
                    </p>
                </div>
            @endforelse
        </div>

        <div class="relative z-10 mt-12 text-center">
            <a href="{{ data_get($menuSettings, 'cta_link', '/') }}"
               class="inline-block rounded-full bg-white px-10 py-3.5 text-[.84rem] font-extrabold text-[#1A1600] shadow-sm transition hover:-translate-y-0.5 hover:bg-[#1A1600] hover:text-[#FFD600]">
                {{ data_get($menuSettings, 'cta_label', 'Lihat Semua Menu') }} →
            </a>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="bg-[#FFFDE0] px-6 py-24 lg:px-14">
        <div class="mx-auto grid max-w-6xl items-center gap-20 lg:grid-cols-2">

            <!-- image col -->
            <div class="about-decor relative">
                <img src="{{ $bannerImage }}" alt="{{ data_get($welcome, 'brand_name', 'Yellow Drink') }}"
                     class="relative z-10 aspect-[4/5] w-full rounded-3xl object-cover shadow-[0_24px_60px_rgba(249,115,22,.12)]" />
                <div class="absolute -bottom-3 -right-3 z-20 flex h-[116px] w-[116px] flex-col items-center justify-center rounded-full border-4 border-white bg-[#1A1600] text-[#FFD600] shadow-xl">
                    <strong class="font-display block text-[1.6rem] font-black leading-none">
                        {{ data_get($welcome, 'about_badge_value', '100%') }}
                    </strong>
                    <span class="text-[.65rem] font-bold opacity-80">{{ data_get($welcome, 'about_badge_label', 'Terjangkau') }}</span>
                </div>
            </div>

            <!-- text col -->
            <div>
                <span class="mb-3 block text-[.68rem] font-extrabold uppercase tracking-[.22em] text-[#8A7A20]">
                    {{ data_get($welcome, 'about_badge', 'Tentang Sistem') }}
                </span>
                <h2 class="font-display mb-6 text-[clamp(2rem,3.5vw,3rem)] font-black leading-[1.1] tracking-tight text-[#1A1600]">
                    {!! nl2br(e(data_get($welcome, 'about_title', "Yellow Drink POS,Satu Dasbor untuk Semua Transaksi"))) !!}
                </h2>
                <p class="mb-4 text-[.9rem] leading-[1.95] text-[#4A3F00]">{{ data_get($welcome, 'about_body_1', 'Yellow Drink POS adalah sistem kasir digital yang dirancang untuk mempermudah operasional toko sehari-hari. Semua transaksi tercatat otomatis, stok terpantau secara real-time, dan laporan keuangan tersedia kapan saja.') }}</p>
                <p class="mb-8 text-[.9rem] leading-[1.95] text-[#4A3F00]">{{ data_get($welcome, 'about_body_2', 'Dari pencatatan penjualan hingga rekap harian dan bulanan, semua bisa dikelola dari satu dasbor yang simpel dan efisien — tanpa perlu keahlian akuntansi.') }}</p>
                <ul class="space-y-3.5">
                    @foreach(data_get($welcome, 'about_points', []) as $point)
                        <li class="flex items-center gap-3 text-[.84rem] font-semibold text-[#1A1600]">
                            <span class="h-2.5 w-2.5 flex-shrink-0 rounded-full border-2 border-[#1A1600] bg-[#FFD600]"></span>
                            {{ $point }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <!-- LOCATION -->
    <section id="location" class="bg-[#1A1600] px-6 py-24 lg:px-14">
        <div class="mb-14">
            <span class="mb-3 block text-[.68rem] font-extrabold uppercase tracking-[.22em] text-[#FFD600]/60">
                {{ data_get($welcome, 'location_badge', 'Kunjungi Kami') }}
            </span>
            <h2 class="font-display text-[clamp(2rem,4vw,3.2rem)] font-black tracking-tight text-[#FFFEF5]">
                {{ data_get($welcome, 'location_title', 'Lokasi Toko') }}
            </h2>
        </div>
        <div class="mx-auto grid max-w-6xl gap-6 lg:grid-cols-2">
            <div class="h-[380px] overflow-hidden rounded-[20px] border-2 border-[#FFD600]/12">
                <iframe src="{{ data_get($welcome, 'location_map_embed', 'https://www.google.com/maps?q=-6.573796898904178,106.7601842828633&output=embed') }}"
                        class="h-full w-full" style="border:0;" loading="lazy"></iframe>
            </div>
            <div class="flex flex-col gap-7 rounded-[20px] border border-[#FFD600]/10 bg-white/[.04] p-10">
                <div class="flex items-start gap-4">
                    <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl border border-[#FFD600]/15 bg-[#FFD600]/10 text-lg">📍</div>
                    <div>
                        <h4 class="mb-1.5 text-[.66rem] font-extrabold uppercase tracking-[.18em] text-[#FFD600]/60">Alamat</h4>
                        <p class="text-[.87rem] leading-[1.85] text-white/75">{!! nl2br(e(data_get($welcome, 'location_address', 'Jl. Raya Bogor No.1, Cibinong,
Kab. Bogor, Jawa Barat 16911'))) !!}</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl border border-[#FFD600]/15 bg-[#FFD600]/10 text-lg">🕐</div>
                    <div>
                        <h4 class="mb-1.5 text-[.66rem] font-extrabold uppercase tracking-[.18em] text-[#FFD600]/60">Jam Operasional</h4>
                        <p class="text-[.87rem] leading-[1.85] text-white/75">{!! nl2br(e(data_get($welcome, 'location_hours', ''))) !!}</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl border border-[#FFD600]/15 bg-[#FFD600]/10 text-lg">📞</div>
                    <div>
                        <h4 class="mb-1.5 text-[.66rem] font-extrabold uppercase tracking-[.18em] text-[#FFD600]/60">Kontak</h4>
                        <p class="text-[.87rem] leading-[1.85] text-white/75">
                            <a href="tel:{{ data_get($welcome, 'location_phone', '+62816634757') }}" class="font-semibold text-[#FFD600] hover:underline">{{ data_get($welcome, 'location_phone', '+62 816-634757') }}</a><br />
                            <a href="mailto:{{ data_get($welcome, 'location_email', '') }}" class="font-semibold text-[#FFD600] hover:underline">{{ data_get($welcome, 'location_email', '') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="flex flex-wrap items-center justify-between gap-4 border-t border-[#FFD600]/08 bg-[#0F0E0A] px-6 py-7 lg:px-14">
        <div class="font-display text-xl font-black text-[#FFD600]">Yellow.</div>
        <p class="text-[.78rem] text-white/30">{{ data_get($welcome, 'footer_note', '© 2025 Yellow Drink. Sistem Kasir & Laporan Keuangan.') }}</p>
        <div class="flex gap-2">
        </div>
    </footer>

    <!-- ACTIVE DISCOUNT TOAST -->
    @if($activeDiscountLabel)
        <div class="fixed bottom-4 right-4 z-[60] max-w-xs rounded-2xl border border-amber-200 bg-amber-50/95 px-4 py-3 text-sm text-amber-900 shadow-lg backdrop-blur lg:bottom-6 lg:right-6">
            <div class="font-semibold">Discount active</div>
            <div>{{ $activeDiscountLabel }}</div>
        </div>
    @endif

    <script>
        // Cursor
        const cur = document.getElementById('cursor');
        document.addEventListener('mousemove', e => {
            cur.style.left = e.clientX + 'px';
            cur.style.top  = e.clientY + 'px';
        });
        document.querySelectorAll('a, button, article').forEach(el => {
            el.addEventListener('mouseenter', () => cur.classList.add('big'));
            el.addEventListener('mouseleave', () => cur.classList.remove('big'));
        });
    </script>
</body>
</html>
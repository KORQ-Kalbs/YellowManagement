@extends('layouts.guest')

@section('htmlClass', 'scroll-smooth')
@section('title', data_get($menuSettings, 'page_title', 'Semua Menu Kami') . ' — Yellow Drink')
@section('bodyClass', 'overflow-x-hidden bg-[#FFFEF5] text-[#1A1600] guest-landing guest-landing--menu')

@push('guest-fonts')
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,700;0,9..144,900;1,9..144,700&family=Cabinet+Grotesk:wght@400;500;700;800&display=swap" rel="stylesheet" />
@endpush

@section('content')

@php
  $menu = $menuSettings ?? \App\Models\DashboardSetting::defaultsForPage('menu');
  $activeDiscountLabel = $activeDiscount ? $activeDiscount->name.' - '.floatval($activeDiscount->discount_percentage).'% OFF' : null;
@endphp

{{-- CURSOR --}}
<div id="cursor" class="pointer-events-none fixed z-[9999] h-3 w-3 -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#FFD600]"></div>

{{-- NAV --}}
<x-navbar
  variant="guest"
  :brand-name="data_get($welcomeSettings, 'brand_name', 'Yellow')"
  menu-href="/#menu"
  about-href="/#about"
  location-href="/#location"
  login-href="/login"
/>

{{-- PAGE HEADER --}}
<div class="relative overflow-hidden bg-[#FFFEF5] px-6 pb-14 pt-32 lg:px-14">
  {{-- yellow arc --}}
  <div class="pointer-events-none absolute -right-20 -top-20 h-80 w-80 rounded-full bg-[#FFD600]"></div>

  <div class="relative z-10">
    <p class="mb-4 text-[.68rem] font-extrabold uppercase tracking-[.18em] text-[#8A7A20]">
      <a href="/" class="hover:text-[#1A1600] no-underline">Beranda</a> › Menu
    </p>
    <h1 class="mb-4 text-[clamp(2.4rem,5vw,4rem)] font-black leading-[1.04] tracking-tight text-[#1A1600]">
      {{ data_get($menu,'page_title','Semua Menu') }}<br>
      <em class="text-[#C9A800]">Kami</em>
    </h1>
    <p class="max-w-lg text-[.92rem] leading-[1.8] text-[#4A3F00]">
      {{ data_get($menu,'page_subtitle','Pilih favoritmu dari produk yang aktif di database, lengkap dengan kategori dan varian.') }}
    </p>
    @if($activeDiscountLabel)
      <div class="inline-flex items-center gap-2 px-4 py-2 mt-5 text-sm font-bold border rounded-full border-amber-200 bg-amber-50 text-amber-900">
        🎉 Promo aktif:
        <span class="rounded-full bg-amber-600 px-3 py-0.5 text-xs font-bold text-white">{{ $activeDiscountLabel }}</span>
      </div>
    @endif
  </div>
</div>

{{-- MARQUEE --}}
<div class="overflow-hidden bg-[#1A1600] py-3" aria-hidden="true">
  <div class="flex marquee-track">
    @foreach(array_fill(0,3,['100% Segar Setiap Hari','Happy Hour☀️','Pure Freshness in Every Bottle','Diskon & Promo','Mood Booster!']) as $group)
      @foreach($group as $w)
        <span class="whitespace-nowrap px-8 text-sm font-bold italic text-[#FFD600]" style="font-family:'Fraunces',serif;">
          {{ $w }}<span class="ml-8 text-xs opacity-40">✦</span>
        </span>
      @endforeach
    @endforeach
  </div>
</div>

{{-- FILTER BAR --}}
<div class="sticky top-0 z-40 border-t border-[#FFD600]/10 bg-[#1A1600] px-6 py-3 lg:px-14">
  <div class="flex gap-2 overflow-x-auto" style="scrollbar-width:none;" id="filter-scroll">
    <button class="filter-btn flex-shrink-0 rounded-full border border-[#FFD600]/25 px-4 py-1.5 text-[.68rem] font-extrabold uppercase tracking-widest text-[#FFD600]/55 active" data-cat="all">
      Semua
    </button>
    @foreach($menuCategories ?? collect() as $cat)
      <button class="filter-btn flex-shrink-0 rounded-full border border-[#FFD600]/25 px-4 py-1.5 text-[.68rem] font-extrabold uppercase tracking-widest text-[#FFD600]/55" data-cat="{{ $cat['slug'] }}">
        {{ $cat['name'] }}
      </button>
    @endforeach
  </div>
</div>

{{-- MAIN CONTENT --}}
<div class="bg-[#FFFEF5] px-6 pb-24 pt-12 lg:px-14" id="main-content">
  @forelse($menuCategories ?? collect() as $category)
    <div class="mb-16 category-section" data-cat="{{ $category['slug'] }}">

      {{-- Category header --}}
      <div class="flex items-center gap-4 mb-7">
        <h2 class="whitespace-nowrap text-xl font-black text-[#1A1600]">{{ $category['name'] }}</h2>
        <div class="h-[1.5px] flex-1 rounded-full bg-gradient-to-r from-[#FFD600] to-transparent"></div>
        <span class="whitespace-nowrap rounded-full border border-[#FFD600] bg-[#FFF9C4] px-3 py-1 text-[.65rem] font-extrabold uppercase tracking-widest text-[#8A7A20]">
          {{ $category['items']->count() }} item
        </span>
      </div>

      {{-- Grid --}}
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($category['items'] as $i => $product)
          @php
            $prices  = collect([$product->harga])->merge($product->variants->filter->is_active->pluck('harga_tambahan')->map(fn($m)=>(float)$product->harga+(float)$m));
            $minP    = $prices->min(); $maxP = $prices->max();
            $imgUrl  = $product->productImage?->url ?? ($product->gambar_produk ? asset($product->gambar_produk) : asset('images/drink.png'));
            $actVar  = $product->variants->where('is_active',true);
          @endphp

          <div class="menu-card overflow-hidden rounded-[20px] border border-[#C9A800]/12 bg-white shadow-sm" style="animation-delay:{{ $i*60 }}ms">
            {{-- Image --}}
            <div class="relative h-48 overflow-hidden bg-[#FFF9C4]">
              <img src="{{ $imgUrl }}" alt="{{ $product->nama_produk }}" loading="lazy"
                   class="object-cover w-full h-full card-img"
                   onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
              <div class="items-center justify-center hidden w-full h-full text-5xl" style="background:linear-gradient(135deg,#FFF9C4,#FFE082)">🥤</div>

              {{-- overlays --}}
              <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#0F0E0A]/65 to-transparent"></div>
              <div class="absolute inset-x-0 top-0 pointer-events-none h-14 bg-gradient-to-b from-black/20 to-transparent"></div>

              {{-- variant badges --}}
              <div class="absolute flex flex-wrap gap-1 left-2 top-2">
                @foreach($actVar as $v)
                  <span class="rounded-lg bg-[#FFD600] px-2 py-0.5 text-[.6rem] font-extrabold uppercase text-[#1A1600]">{{ $v->kode_variant }}</span>
                @endforeach
              </div>

              {{-- price --}}
              <div class="absolute bottom-2 left-3">
                <p class="text-lg font-black leading-none text-[#FFD600]" style="font-family:'Fraunces',serif;text-shadow:0 2px 8px rgba(0,0,0,.4)">
                  Rp {{ number_format($minP,0,',','.') }}
                </p>
                @if($maxP > $minP)
                  <p class="text-[.65rem] font-bold text-[#FFD600]/75">s/d Rp {{ number_format($maxP,0,',','.') }}</p>
                @endif
              </div>
            </div>

            {{-- Body --}}
            <div class="p-4">
              <h3 class="mb-3 text-base font-black leading-tight text-[#1A1600]">{{ $product->nama_produk }}</h3>
              <table class="w-full text-[.68rem]" style="border-collapse:collapse;">
                @foreach([['Kategori',$product->kategori?->nama_kategori??'—'],['Stok',$product->stok],['Varian',$actVar->count()?$actVar->count().' aktif':'Tanpa varian'],['Harga','Rp '.number_format($product->harga,0,',','.')]] as [$k,$v])
                  <tr class="border-b border-[#FFD600]/15 last:border-0">
                    <td class="py-1 pr-3 font-extrabold uppercase tracking-wider text-[#8A7A20]">{{ $k }}</td>
                    <td class="py-1 text-[#4A3F00]">{{ $v }}</td>
                  </tr>
                @endforeach
              </table>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @empty
    <div class="rounded-3xl border border-[#FFD600]/35 bg-[#FFFDE0] px-10 py-16 text-center">
      <h3 class="mb-2 text-2xl font-black text-[#1A1600]">{{ data_get($menu,'empty_title','Belum ada produk aktif') }}</h3>
      <p class="text-sm text-[#8A7A20]">{{ data_get($menu,'empty_message','Tambahkan produk aktif di admin product management untuk menampilkan menu di sini.') }}</p>
    </div>
  @endforelse
</div>

{{-- FOOTER --}}
<footer class="flex flex-wrap items-center justify-between gap-4 border-t border-[#FFD600]/08 bg-[#0F0E0A] px-6 py-6 lg:px-14">
  <div class="text-xl font-black text-[#FFD600]" style="font-family:'Fraunces',serif;">
    {{ data_get($welcomeSettings,'brand_name','Yellow') }}.
  </div>
  <p class="text-xs text-white/30">{{ data_get($welcomeSettings,'footer_note','© 2025 Yellow Drink. Sistem Kasir & Laporan Keuangan.') }}</p>
  <div class="flex gap-2">
    @foreach(['f','ig','tw'] as $s)
      <a href="#" class="flex h-9 w-9 items-center justify-center rounded-full border border-[#FFD600]/20 text-[.68rem] font-bold text-white/35 transition hover:border-[#FFD600] hover:text-[#FFD600]">{{ $s }}</a>
    @endforeach
  </div>
</footer>

@endsection

@push('guest-scripts')
<script>
  const cur = document.getElementById('cursor');
  document.addEventListener('mousemove', e => { cur.style.left=e.clientX+'px'; cur.style.top=e.clientY+'px'; });
  document.querySelectorAll('a,button').forEach(el => {
    el.addEventListener('mouseenter',()=>cur.classList.add('big'));
    el.addEventListener('mouseleave',()=>cur.classList.remove('big'));
  });
  document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.filter-btn').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      const cat = btn.dataset.cat;
      document.querySelectorAll('.category-section').forEach(s => {
        s.style.display = cat==='all'||s.dataset.cat===cat ? 'block' : 'none';
      });
    });
  });
</script>
@endpush
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ data_get($menuSettings, 'page_title', 'Semua Menu Kami') }} — Yellow Drink</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  @vite(['resources/css/menu.css'])
</head>
<body>
  @php
    $menu = $menuSettings ?? \App\Models\DashboardSetting::defaultsForPage('menu');
    $activeDiscountLabel = $activeDiscount ? $activeDiscount->name . ' - ' . floatval($activeDiscount->discount_percentage) . '% OFF' : null;
  @endphp

  <nav>
    <a href="/" class="nav-logo">{{ data_get($welcomeSettings, 'brand_name', 'Yellow Drink') }}</a>
    <ul class="nav-links">
      <li><a href="/#menu">Menu</a></li>
      <li><a href="/#about">Tentang</a></li>
      <li><a href="/#location">Lokasi</a></li>
    </ul>
    <a href="/login" class="nav-cta">Login Kasir</a>
  </nav>

  <div class="page-header">
    <div class="breadcrumb">
      <a href="/">Beranda</a>
      <span>›</span>
      Menu
    </div>
    <h1>{{ data_get($menu, 'page_title', 'Semua Menu Kami') }}</h1>
    <p>{{ data_get($menu, 'page_subtitle', 'Pilih favoritmu dari produk yang aktif di database, lengkap dengan kategori dan varian.') }}</p>

    @if($activeDiscountLabel)
      <div class="mt-6 inline-flex items-center gap-2 rounded-full border border-amber-300 bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-900 shadow-sm">
        <span>Promo aktif:</span>
        <span>{{ $activeDiscountLabel }}</span>
      </div>
    @endif
  </div>

  <div class="filter-bar">
    <div class="filter-scroll" id="filter-scroll">
      <button class="filter-btn active" data-cat="all">Semua</button>
      @foreach($menuCategories ?? collect() as $category)
        <button class="filter-btn" data-cat="{{ $category['slug'] }}">{{ $category['name'] }}</button>
      @endforeach
    </div>
  </div>

  <div class="main-content" id="main-content">
    @forelse($menuCategories ?? collect() as $category)
      <div class="category-section" data-cat="{{ $category['slug'] }}">
        <div class="category-header">
          <h2>{{ $category['name'] }}</h2>
          <div class="category-line"></div>
          <span class="category-count">{{ $category['items']->count() }} item</span>
        </div>

        <div class="menu-grid">
          @foreach($category['items'] as $product)
            @php
              $priceOptions = collect([$product->harga])
                ->merge($product->variants->filter->is_active->pluck('harga_tambahan')->map(fn ($modifier) => (float) $product->harga + (float) $modifier));
              $minPrice = $priceOptions->min();
              $maxPrice = $priceOptions->max();
              $imageUrl = $product->productImage?->url ?? ($product->gambar_produk ? asset($product->gambar_produk) : asset('images/drink.png'));
              $activeVariants = $product->variants->where('is_active', true);
            @endphp

            <div class="menu-card">
              <div class="menu-img-wrap">
                <img
                  src="{{ $imageUrl }}"
                  alt="{{ $product->nama_produk }}"
                  loading="lazy"
                  onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                />
                <div class="img-fallback" style="display:none;">🥤</div>
                <div class="img-overlay-bottom"></div>
                <div class="img-overlay-top"></div>

                <div class="size-badges">
                  @foreach($activeVariants as $variant)
                    <span class="size-badge">{{ $variant->kode_variant }}</span>
                  @endforeach
                </div>

                <div class="price-on-img">
                  <span class="price-main">Rp {{ number_format($minPrice, 0, ',', '.') }}</span>
                  @if($maxPrice > $minPrice)
                    <span class="price-range">s/d Rp {{ number_format($maxPrice, 0, ',', '.') }}</span>
                  @endif
                </div>
              </div>

              <div class="menu-body">
                <h3>{{ $product->nama_produk }}</h3>
                <table class="size-table">
                  <tr>
                    <td>Kategori</td>
                    <td>{{ $product->kategori?->nama_kategori ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td>Stok</td>
                    <td>{{ $product->stok }}</td>
                  </tr>
                  <tr>
                    <td>Varian</td>
                    <td>{{ $activeVariants->count() ? $activeVariants->count() . ' aktif' : 'Tanpa varian' }}</td>
                  </tr>
                  <tr>
                    <td>Harga</td>
                    <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                  </tr>
                </table>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @empty
      <div class="category-section">
        <div class="menu-card" style="grid-column: 1 / -1; text-align:center;">
          <h3>{{ data_get($menu, 'empty_title', 'Belum ada produk aktif') }}</h3>
          <p style="margin-top: 12px;">{{ data_get($menu, 'empty_message', 'Tambahkan produk aktif di admin product management untuk menampilkan menu di sini.') }}</p>
        </div>
      </div>
    @endforelse
  </div>

  <footer>
    <div class="footer-logo">{{ data_get($welcomeSettings, 'brand_name', 'Yellow Drink') }}</div>
    <p>{{ data_get($welcomeSettings, 'footer_note', '© 2025 Yellow Drink. Semua Berhak Minum Enak.') }}</p>
    <div class="social-links">
      <a href="#" class="social-btn">f</a>
      <a href="#" class="social-btn">ig</a>
      <a href="#" class="social-btn">tw</a>
    </div>
  </footer>

  <script>
    const filterButtons = document.querySelectorAll('.filter-btn');
    const sections = document.querySelectorAll('.category-section');

    filterButtons.forEach((button) => {
      button.addEventListener('click', () => {
        filterButtons.forEach((item) => item.classList.remove('active'));
        button.classList.add('active');

        const category = button.dataset.cat;
        sections.forEach((section) => {
          const visible = category === 'all' || section.dataset.cat === category;
          section.style.display = visible ? 'block' : 'none';
        });
      });
    });
  </script>
</body>
</html>
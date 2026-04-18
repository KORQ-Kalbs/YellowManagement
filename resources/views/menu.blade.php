<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu — Yellow Drink</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --yellow: #F5C518;
      --yellow-dark: #D4A010;
      --cream: #F5EDD6;
      --cream-light: #FBF6EC;
      --brown-dark: #311f08;
      --brown-mid: #422b0e;
      --brown-soft: #5C3D1E;
      --text-light: #F2E8D0;
      --text-muted: #9E8A6E;
      --serif: 'Playfair Display', Georgia, serif;
      --sans: 'DM Sans', sans-serif;
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: var(--sans);
      background: var(--brown-dark);
      color: var(--text-light);
      overflow-x: hidden;
      min-height: 100vh;
    }

    /* ── NAV ── */
    nav {
      position: sticky; top: 0; z-index: 100;
      display: flex; align-items: center; justify-content: space-between;
      padding: 1.25rem 4rem;
      background: rgba(49,31,8,0.97);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(245,197,24,0.1);
    }
    .nav-logo {
      font-family: var(--serif);
      font-size: 1.5rem; font-weight: 700;
      color: var(--yellow);
      letter-spacing: 0.04em;
      text-decoration: none;
    }
    .nav-links { display: flex; gap: 2rem; list-style: none; }
    .nav-links a {
      font-size: 0.875rem; font-weight: 400;
      color: var(--text-light); text-decoration: none;
      letter-spacing: 0.05em;
      transition: color 0.2s;
    }
    .nav-links a:hover, .nav-links a.active { color: var(--yellow); }
    .nav-cta {
      padding: 0.6rem 1.4rem;
      background: var(--yellow); color: var(--brown-dark);
      font-family: var(--sans); font-size: 0.85rem; font-weight: 500;
      border-radius: 100px; text-decoration: none;
      transition: background 0.2s, transform 0.15s;
    }
    .nav-cta:hover { background: #fff; transform: scale(1.03); }

    /* ── PAGE HEADER ── */
    .page-header {
      background: var(--brown-mid);
      padding: 3.5rem 4rem 3rem;
      border-bottom: 1px solid rgba(245,197,24,0.1);
      position: relative;
      overflow: hidden;
    }
    .page-header::before {
      content: '';
      position: absolute;
      top: -60px; right: -60px;
      width: 320px; height: 320px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(245,197,24,0.08) 0%, transparent 70%);
      pointer-events: none;
    }
    .breadcrumb {
      font-size: 0.78rem; color: var(--text-muted);
      margin-bottom: 0.75rem; letter-spacing: 0.04em;
    }
    .breadcrumb a { color: var(--yellow); text-decoration: none; }
    .breadcrumb span { margin: 0 0.4rem; opacity: 0.4; }
    .page-header h1 {
      font-family: var(--serif);
      font-size: clamp(2.2rem, 5vw, 3.5rem);
      font-weight: 900; color: var(--cream);
      margin-bottom: 0.5rem;
      line-height: 1.1;
    }
    .page-header h1 em { font-style: italic; color: var(--yellow); }
    .page-header p {
      font-size: 0.95rem; color: var(--text-muted);
      max-width: 480px; line-height: 1.65;
    }

    /* ── FILTER TABS ── */
    .filter-bar {
      background: var(--brown-mid);
      padding: 1.25rem 4rem 1.5rem;
      border-bottom: 1px solid rgba(245,197,24,0.08);
      position: sticky; top: 73px; z-index: 50;
    }
    .filter-scroll {
      display: flex; gap: 0.6rem;
      overflow-x: auto; padding-bottom: 4px;
      scrollbar-width: none;
    }
    .filter-scroll::-webkit-scrollbar { display: none; }
    .filter-btn {
      flex-shrink: 0;
      padding: 0.45rem 1.1rem;
      border-radius: 100px; font-size: 0.8rem; font-weight: 500;
      border: 1px solid rgba(245,197,24,0.25);
      background: transparent; color: var(--text-muted);
      cursor: pointer; transition: all 0.2s; letter-spacing: 0.03em;
      font-family: var(--sans);
    }
    .filter-btn:hover { border-color: rgba(245,197,24,0.5); color: var(--text-light); }
    .filter-btn.active {
      background: var(--yellow); color: var(--brown-dark);
      border-color: var(--yellow); font-weight: 600;
    }

    /* ── MAIN CONTENT ── */
    .main-content {
      padding: 3rem 4rem 5rem;
      max-width: 1400px;
      margin: 0 auto;
    }

    /* ── CATEGORY SECTION ── */
    .category-section {
      margin-bottom: 4rem;
    }
    .category-header {
      display: flex; align-items: center; gap: 1rem;
      margin-bottom: 1.75rem;
    }
    .category-header h2 {
      font-family: var(--serif);
      font-size: 1.55rem; font-weight: 700;
      color: var(--cream);
    }
    .category-line {
      flex: 1; height: 1px;
      background: linear-gradient(to right, rgba(245,197,24,0.25), transparent);
    }
    .category-count {
      font-size: 0.75rem; color: var(--text-muted);
      border: 1px solid rgba(245,197,24,0.2);
      padding: 0.25rem 0.7rem; border-radius: 100px;
    }

    /* ── MENU GRID ── */
    .menu-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
      gap: 1.25rem;
    }

    /* ── MENU CARD — identical style to landing page ── */
    .menu-card {
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(245,197,24,0.1);
      border-radius: 20px; overflow: hidden;
      transition: transform 0.25s, border-color 0.25s, background 0.25s;
      cursor: pointer;
    }
    .menu-card:hover {
      transform: translateY(-8px);
      border-color: rgba(245,197,24,0.4);
      background: rgba(255,255,255,0.07);
    }

    .menu-img-wrap {
      position: relative;
      height: 180px;
      overflow: hidden;
      background: var(--brown-soft);
    }
    .menu-img-wrap img {
      width: 100%; height: 100%; object-fit: cover; display: block;
      transition: transform 0.5s;
    }
    .menu-card:hover .menu-img-wrap img { transform: scale(1.07); }

    /* fallback jika gambar tidak ada */
    .img-fallback {
      width: 100%; height: 100%;
      display: flex; align-items: center; justify-content: center;
      background: linear-gradient(135deg, rgba(92,61,30,0.6) 0%, rgba(49,31,8,0.8) 100%);
      font-size: 2.5rem;
    }

    .img-overlay-bottom {
      position: absolute; inset: 0;
      background: linear-gradient(to top, rgba(49,31,8,0.80) 0%, transparent 55%);
      pointer-events: none;
    }
    .img-overlay-top {
      position: absolute; inset: 0;
      background: linear-gradient(to bottom, rgba(49,31,8,0.25) 0%, transparent 45%);
      pointer-events: none;
    }

    /* Price sizes badge on image */
    .price-on-img {
      position: absolute; bottom: 10px; left: 12px;
      pointer-events: none;
    }
    .price-main {
      font-family: var(--serif);
      font-size: 1.05rem; font-weight: 700;
      color: var(--yellow);
      text-shadow: 0 2px 8px rgba(0,0,0,0.5);
      display: block; line-height: 1;
    }
    .price-range {
      font-size: 0.68rem; color: rgba(245,197,24,0.7);
      text-shadow: 0 1px 4px rgba(0,0,0,0.4);
      letter-spacing: 0.03em;
    }

    .size-badges {
      position: absolute; top: 10px; right: 10px;
      display: flex; gap: 3px;
    }
    .size-badge {
      background: rgba(26,18,8,0.85); backdrop-filter: blur(4px);
      border: 1px solid rgba(245,197,24,0.2);
      border-radius: 4px; padding: 2px 5px;
      font-size: 0.6rem; color: var(--text-muted);
      font-weight: 500;
    }

    .menu-body { padding: 1rem 1.1rem; }
    .menu-body h3 {
      font-family: var(--serif);
      font-size: 0.97rem; font-weight: 700;
      color: var(--cream); margin-bottom: 0.7rem;
      line-height: 1.3;
    }

    /* Size-price table */
    .size-table {
      width: 100%; border-collapse: collapse;
      margin-bottom: 0.9rem;
    }
    .size-table td {
      font-size: 0.72rem; padding: 2px 0;
      color: var(--text-muted);
    }
    .size-table td:last-child {
      text-align: right;
      color: var(--yellow); font-weight: 600;
    }
    .size-table td:first-child { color: rgba(158,138,110,0.65); }

    .menu-footer { display: flex; justify-content: flex-end; }
    .add-btn {
      padding: 0.42rem 1rem;
      background: var(--yellow); color: var(--brown-dark);
      font-size: 0.78rem; font-weight: 600;
      border: none; border-radius: 100px; cursor: pointer;
      transition: all 0.2s; font-family: var(--sans);
    }
    .add-btn:hover { background: #fff; transform: scale(1.05); }

    /* ── FOOTER ── */
    footer {
      background: var(--brown-mid);
      border-top: 1px solid rgba(245,197,24,0.1);
      padding: 2rem 4rem;
      display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
    }
    .footer-logo { font-family: var(--serif); font-size: 1.2rem; font-weight: 700; color: var(--yellow); }
    footer p { font-size: 0.8rem; color: var(--text-muted); }
    .social-links { display: flex; gap: 0.75rem; }
    .social-btn {
      width: 36px; height: 36px; border-radius: 50%;
      border: 1px solid rgba(245,197,24,0.25);
      display: flex; align-items: center; justify-content: center;
      color: var(--text-muted); font-size: 0.75rem;
      text-decoration: none; transition: all 0.2s;
    }
    .social-btn:hover { border-color: var(--yellow); color: var(--yellow); }

    /* ── HIDDEN class ── */
    .hidden { display: none !important; }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
      nav { padding: 1rem 1.5rem; }
      .nav-links { display: none; }
      .page-header { padding: 2.5rem 1.5rem 2rem; }
      .filter-bar { padding: 1rem 1.5rem; top: 64px; }
      .main-content { padding: 2rem 1.5rem 4rem; }
      footer { padding: 1.5rem; flex-direction: column; text-align: center; }
    }
  </style>
</head>
<body>

  <!-- NAV -->
  <nav>
    <a href="/" class="nav-logo">Yellow Drink</a>
    <ul class="nav-links">
      <li><a href="/#menu">Menu</a></li>
      <li><a href="/#about">Tentang</a></li>
      <li><a href="/#location">Lokasi</a></li>
    </ul>
    <a href="/login" class="nav-cta">Login Kasir</a>
  </nav>

  <!-- PAGE HEADER -->
  <div class="page-header">
    <div class="breadcrumb">
      <a href="/">Beranda</a>
      <span>›</span>
      Menu
    </div>
    <h1>Semua <em>Menu</em> Kami</h1>
    <p>Pilih favoritmu dari 40+ varian minuman — cokelat, kopi, smoothies, yogurt, thai tea, dan banyak lagi.</p>
  </div>

  <!-- FILTER TABS -->
  <div class="filter-bar">
    <div class="filter-scroll" id="filter-scroll">
      <button class="filter-btn active" data-cat="all">Semua</button>
      <button class="filter-btn" data-cat="cokelat">🍫 Cokelat</button>
      <button class="filter-btn" data-cat="kopi">☕ Kopi</button>
      <button class="filter-btn" data-cat="cream">🥛 Cream Series</button>
      <button class="filter-btn" data-cat="ice-cream">🍦 Ice Cream</button>
      <button class="filter-btn" data-cat="smoothies">🥤 Smoothies</button>
      <button class="filter-btn" data-cat="coconut">🥥 Coconut</button>
      <button class="filter-btn" data-cat="yogurt">🫙 Yogurt</button>
      <button class="filter-btn" data-cat="yakult">🧃 Yakult</button>
      <button class="filter-btn" data-cat="milk">🍓 Milk</button>
      <button class="filter-btn" data-cat="tea">🍵 Tea</button>
      <button class="filter-btn" data-cat="cincau">🧋 Cincau series</button>
    </div>
  </div>

  <!-- MAIN -->
  <div class="main-content" id="main-content">

   @php
$categories = [
  [
    'key' => 'cokelat',
    'label' => '🍫 Cokelat Series',
    'emoji' => '🍫',
    'items' => [
      ['nama'=>'Cokelat Oreo','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'coklatoreo.png'],
      ['nama'=>'Cokelat Magnum','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'coklatmagnum.png'],
      ['nama'=>'Cokelat Milo','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'coklatmilo.png'],
      ['nama'=>'Cokelat Delfi','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'coklatdelfi.png'],
      ['nama'=>'Silverqueen','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'silverqueen.png'],
    ]
  ],
  [
    'key' => 'kopi',
    'label' => '☕ Kopi Series',
    'emoji' => '☕',
    'items' => [
      ['nama'=>'Kopi Caramel','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'kopicaramel.png'],
      ['nama'=>'Cappuccino','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'cappuccino.png'],
    ]
  ],
  [
    'key' => 'cream',
    'label' => '🥛 Cream Series',
    'emoji' => '🥛',
    'items' => [
      ['nama'=>'Taro Cream','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'taro.png'],
      ['nama'=>'Hazelnut Cream','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'hazelnut.png'],
      ['nama'=>'Green Tea Cream','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'greentea.png'],
      ['nama'=>'Vanilla Milk','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'vanilla.png'],
      ['nama'=>'Vanilla Latte','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'vanillalatte.png'],
      ['nama'=>'Mocca Latte','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'mocca.png'],
      ['nama'=>'Bubblegum','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'bubblegum.png'],
      ['nama'=>'Red Velvet','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'redvelvet.png'],
      ['nama'=>'Alpukat Cream','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'alpukat.png'],
      ['nama'=>'Durian Cream','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'durian.png'],
      ['nama'=>'Leci Cream','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'leci.png'],
      ['nama'=>'Mangga Cream','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'mangga.png'],
      ['nama'=>'Melon Cream','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'melon.png'],
      ['nama'=>'Tiramisu','harga'=>['M'=>'7k','L'=>'9k','XL'=>'11k','XXL'=>'15k'],'img'=>'tiramisu.png'],
      ['nama'=>'Caramel Regal','harga'=>['L'=>'9k','XL'=>'12k'],'img'=>'caramelregal.png'],
      ['nama'=>'Brown Sugar Milk Tea','harga'=>['L'=>'9k','XL'=>'12k'],'img'=>'brownsugarm.png'],
      ['nama'=>'Strawberry Coklat Cream & Bobba','harga'=>['L'=>'9k','XL'=>'12k'],'img'=>'strawberrycream.png'],
    ]
  ],
  [
    'key' => 'ice-cream',
    'label' => '🍦 Ice Cream',
    'emoji' => '🍦',
    'items' => [
      ['nama'=>'Ice Cream Original','harga'=>['-'=>'13k'],'img'=>'iceoriginal.png'],
      ['nama'=>'Ice Cream Oreo','harga'=>['-'=>'15k'],'img'=>'iceoreo.png'],
      ['nama'=>'Ice Cream Strawberry','harga'=>['-'=>'15k'],'img'=>'icestrawberry.png'],
    ]
  ],
  [
    'key' => 'smoothies',
    'label' => '🥤 Smoothies dadang jawa',
    'emoji' => '🥤',
    'items' => [
      ['nama'=>'Alpukat Smoothies','harga'=>['XL'=>'15k','XXL'=>'20k'],'img'=>'alpukat.png'],
      ['nama'=>'Strawberry Smoothies','harga'=>['XL'=>'15k','XXL'=>'20k'],'img'=>'strawberry.png'],
      ['nama'=>'Mangga Smoothies','harga'=>['XL'=>'15k','XXL'=>'20k'],'img'=>'mangga.png'],
      ['nama'=>'Dragon Smoothies','harga'=>['XL'=>'15k','XXL'=>'20k'],'img'=>'dragon.png'],
    ]
  ],
  [
    'key' => 'coconut',
    'label' => '🥥 Coconut Series',
    'emoji' => '🥥',
    'items' => [
      ['nama'=>'Coconut Original','harga'=>['L'=>'10k','XL'=>'12k'],'img'=>'coconutoriginal.png'],
      ['nama'=>'Coconut Shake Ice Cream','harga'=>['L'=>'12k','XL'=>'15k'],'img'=>'coconutcream.png'],
      ['nama'=>'Coconut Strawberry','harga'=>['L'=>'12k','XL'=>'15k'],'img'=>'coconutstrawberry.png'],
    ]
  ],
  [
    'key' => 'yogurt',
    'label' => '🫙 Yogurt Series',
    'emoji' => '🫙',
    'items' => [
      ['nama'=>'Mangga Yogurt','harga'=>['L'=>'10k','XL'=>'12k'],'img'=>'manggayogurt.png'],
      ['nama'=>'Strawberry Yogurt','harga'=>['L'=>'10k','XL'=>'12k'],'img'=>'strawberryyogurt.png'],
      ['nama'=>'Blueberry Yogurt','harga'=>['L'=>'10k','XL'=>'12k'],'img'=>'blueberryyogurt.png'],
    ]
  ],
  [
    'key' => 'yakult',
    'label' => '🧃 Yakult Series',
    'emoji' => '🧃',
    'items' => [
      ['nama'=>'Leci Yakult','harga'=>['L'=>'10k','XL'=>'12k'],'img'=>'leciyakult.png'],
      ['nama'=>'Mangga Yakult','harga'=>['L'=>'10k','XL'=>'12k'],'img'=>'manggayakult.png'],
    ]
  ],
  [
    'key' => 'milk',
    'label' => '🍓 Milk Series',
    'emoji' => '🍓',
    'items' => [
      ['nama'=>'Blueberry Milk','harga'=>['L'=>'9k','XL'=>'12k'],'img'=>'bluberrymilk.png'],
      ['nama'=>'Strawberry Milk','harga'=>['L'=>'9k','XL'=>'12k'],'img'=>'strawberrymilk.png'],
    ]
  ],
  [
    'key' => 'tea',
    'label' => '🍵 Tea Series',
    'emoji' => '🍵',
    'items' => [
      ['nama'=>'Thai Tea','harga'=>['L'=>'10k','XL'=>'12k'],'img'=>'thaitea.png'],
      ['nama'=>'Thai Green Tea','harga'=>['L'=>'10k','XL'=>'12k'],'img'=>'thaigreen.png'],
      ['nama'=>'Lemon Tea','harga'=>['L'=>'7k','XL'=>'9k'],'img'=>'lemontea.png'],
      ['nama'=>'Squeeze Lemon','harga'=>['L'=>'7k','XL'=>'9k'],'img'=>'lemon.png'],
      ['nama'=>'Ice Tea','harga'=>['L'=>'4k','XL'=>'6k'],'img'=>'icetea.png'],
    ]
  ],
  [
    'key' => 'cincau',
    'label' => '🧋 Cincau Series',
    'emoji' => '🧋',
    'items' => [
      ['nama'=>'Milk Cincau Brown Sugar','harga'=>['M'=>'7k','L'=>'9k','XL'=>'12k'],'img'=>'cincau.png'],
      ['nama'=>'Milk Cincarul Pandan','harga'=>['M'=>'7k','L'=>'9k','XL'=>'12k'],'img'=>'milkcincarul.png']
    ]
  ]
];
@endphp
    @foreach($categories as $cat)
    <div class="category-section" data-cat="{{ $cat['key'] }}">
      <div class="category-header">
        <h2>{{ $cat['label'] }}</h2>
        <div class="category-line"></div>
        <span class="category-count">{{ count($cat['items']) }} item</span>
      </div>
      <div class="menu-grid">
        @foreach($cat['items'] as $menu)
        @php
          $sizes = array_keys($menu['harga']);
          $prices = array_values($menu['harga']);
          $minPrice = $prices[0];
          $maxPrice = end($prices);
          $priceLabel = count($prices) > 1
            ? $minPrice . ' – ' . $maxPrice
            : $minPrice;
        @endphp
        <div class="menu-card">
          <div class="menu-img-wrap">
            <img
              src="{{ asset('images/' . $menu['img']) }}"
              alt="{{ $menu['nama'] }}"
              loading="lazy"
              onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            />
            <div class="img-fallback" style="display:none;">🥤</div>
            <div class="img-overlay-bottom"></div>
            <div class="img-overlay-top"></div>

            <div class="size-badges">
              @foreach(array_keys($menu['harga']) as $sz)
                @if($sz !== '-')
                  <span class="size-badge">{{ $sz }}</span>
                @endif
              @endforeach
            </div>

            <div class="price-on-img">
              <span class="price-main">
                Rp {{ $minPrice }}
              </span>
              @if(count($prices) > 1)
                <span class="price-range">s/d {{ $maxPrice }}</span>
              @endif
            </div>
          </div>

          <div class="menu-body">
            <h3>{{ $menu['nama'] }}</h3>
            <table class="size-table">
              @foreach($menu['harga'] as $size => $price)
              <tr>
                <td>{{ $size !== '-' ? $size : 'Normal' }}</td>
                <td>Rp {{ $price }}</td>
              </tr>
              @endforeach
            </table>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endforeach

  </div>

  <!-- FOOTER -->
  <footer>
    <div class="footer-logo">Yellow Drink</div>
    <p>© 2025 Yellow Drink. Semua Berhak Minum Enak.</p>
    <div class="social-links">
      <a href="#" class="social-btn">f</a>
      <a href="#" class="social-btn">ig</a>
      <a href="#" class="social-btn">tw</a>
    </div>
  </footer>

  <script>
    // Filter by category
    const filterBtns = document.querySelectorAll('.filter-btn');
    const categorySections = document.querySelectorAll('.category-section');

    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const cat = btn.dataset.cat;

        categorySections.forEach(sec => {
          if (cat === 'all' || sec.dataset.cat === cat) {
            sec.classList.remove('hidden');
          } else {
            sec.classList.add('hidden');
          }
        });

        // Smooth scroll to top of content
        document.getElementById('main-content').scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });
  </script>
</body>
</html>
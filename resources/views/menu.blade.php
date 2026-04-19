<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu — Yellow Drink</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  @vite(['resources/css/menu.css'])
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
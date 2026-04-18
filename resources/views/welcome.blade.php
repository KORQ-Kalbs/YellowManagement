<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Yellow Drink - Semua Berhak Minum Enak</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="overflow-x-hidden bg-[#311f08] text-[#F2E8D0] [font-family:'DM_Sans',sans-serif]">
    <nav class="fixed inset-x-0 top-0 z-50 flex items-center justify-between bg-gradient-to-b from-[#1A1208]/95 to-transparent px-6 py-5 lg:px-16">
        <div class="text-2xl font-bold tracking-wide text-[#F5C518] [font-family:'Playfair_Display',serif]">Yellow Drink</div>
        <ul class="hidden items-center gap-8 text-sm tracking-wider md:flex">
            <li><a href="#menu" class="transition-colors hover:text-[#F5C518]">Menu</a></li>
            <li><a href="#about" class="transition-colors hover:text-[#F5C518]">Tentang</a></li>
            <li><a href="#location" class="transition-colors hover:text-[#F5C518]">Lokasi</a></li>
        </ul>
        <a href="/login" class="rounded-full bg-[#F5C518] px-5 py-2.5 text-sm font-medium text-[#311f08] transition hover:scale-105 hover:bg-white">Login Kasir</a>
    </nav>

    <section class="relative flex min-h-screen items-end overflow-hidden">
        <div class="absolute inset-0 bg-[#1A1208] [background-image:linear-gradient(160deg,rgba(26,18,8,0.55)_0%,rgba(26,18,8,0.1)_50%,rgba(26,18,8,0.7)_100%),radial-gradient(ellipse_at_70%_40%,rgba(245,197,24,0.08)_0%,transparent_60%)]"></div>
        <div class="pointer-events-none absolute right-[5%] top-[10%] h-[520px] w-[520px] rounded-full bg-[radial-gradient(circle,rgba(245,197,24,0.15)_0%,transparent_70%)]"></div>

        <div class="absolute bottom-20 right-[20%] flex w-[clamp(220px,28vw,500px)] items-end justify-center">
            <div class="pointer-events-none absolute bottom-0 left-1/2 h-[60%] w-[80%] -translate-x-1/2 bg-[radial-gradient(ellipse_at_center_bottom,rgba(245,197,24,0.18)_0%,transparent_70%)]"></div>
            <img src="{{ asset('images/drink.png') }}" alt="Yellow Drink" class="relative z-10 w-full drop-shadow-[0_30px_40px_rgba(0,0,0,0.5)]" />
        </div>

        <div class="relative z-10 max-w-2xl px-6 pb-40 lg:px-16">
            <span class="mb-6 inline-block rounded-full border border-[#F5C518]/40 px-4 py-1.5 text-xs font-medium uppercase tracking-[0.15em] text-[#F5C518]">Minuman Kekinian Terbaik</span>
            <h1 class="mb-6 text-5xl font-black leading-[1.05] text-[#F5EDD6] lg:text-7xl [font-family:'Playfair_Display',serif]">
                Segarnya Rasa<br /><em class="italic text-[#F5C518]">Temani</em><br />Setiap Cerita
            </h1>
            <p class="mb-10 max-w-lg text-base leading-8 text-[#9E8A6E] lg:text-[1.05rem]">
                Minuman berkualitas, harga ramah di kantong. Karena semua berhak minum enak.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="#menu" class="rounded-full bg-[#F5C518] px-8 py-3.5 text-sm font-medium tracking-wide text-[#311f08] transition hover:-translate-y-0.5 hover:bg-white">Lihat Menu</a>
                <a href="#location" class="rounded-full border border-[#F2E8D0]/30 px-8 py-3.5 text-sm tracking-wide text-[#F2E8D0] transition hover:border-[#F5C518] hover:text-[#F5C518]">Temukan Toko</a>
            </div>
        </div>

        <div class="absolute inset-x-0 bottom-0 z-10 hidden border-t border-[#F5C518]/10 bg-[#1A1208]/70 backdrop-blur-xl md:flex">
            <div class="flex-1 border-r border-[#F5C518]/10 px-8 py-5">
                <div class="text-3xl font-bold leading-none text-[#F5C518] [font-family:'Playfair_Display',serif]">15+</div>
                <div class="mt-1 text-xs leading-5 text-[#9E8A6E]">Varian Menu<br />Pilihan</div>
            </div>
            <div class="flex-1 border-r border-[#F5C518]/10 px-8 py-5">
                <div class="text-3xl font-bold leading-none text-[#F5C518] [font-family:'Playfair_Display',serif]">100%</div>
                <div class="mt-1 text-xs leading-5 text-[#9E8A6E]">Bahan Segar<br />Alami</div>
            </div>
            <div class="flex-1 border-r border-[#F5C518]/10 px-8 py-5">
                <div class="text-3xl font-bold leading-none text-[#F5C518] [font-family:'Playfair_Display',serif]">4.9</div>
                <div class="mt-1 text-xs leading-5 text-[#9E8A6E]">Rating<br />Pelanggan</div>
            </div>
            <div class="flex-1 px-8 py-5">
                <div class="text-3xl font-bold leading-none text-[#F5C518] [font-family:'Playfair_Display',serif]">500+</div>
                <div class="mt-1 text-xs leading-5 text-[#9E8A6E]">Pelanggan<br />Setia</div>
            </div>
        </div>
    </section>

    <section class="bg-[#FBF6EC] px-6 py-20 lg:px-16" aria-label="Mengapa Memilih Kami">
        <span class="mb-2 block text-xs font-medium uppercase tracking-[0.15em] text-[#5C3D1E]">Mengapa Memilih Kami</span>
        <h2 class="mb-14 text-4xl font-bold text-[#311f08] [font-family:'Playfair_Display',serif] lg:text-5xl">Kenapa Yellow Drink?</h2>
        <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-2xl border border-[#5C3D1E]/10 bg-white p-8 transition hover:-translate-y-1.5 hover:shadow-[0_20px_40px_rgba(92,61,30,0.1)]">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-[#F5C518] text-2xl">🌿</div>
                <h3 class="mb-2 text-xl font-bold text-[#311f08] [font-family:'Playfair_Display',serif]">Bahan Berkualitas</h3>
                <p class="text-sm leading-7 text-[#6B5C47]">100% menggunakan bahan pilihan terbaik, segar, alami, dan dipilih dengan cermat setiap harinya.</p>
            </div>
            <div class="rounded-2xl border border-[#5C3D1E]/10 bg-white p-8 transition hover:-translate-y-1.5 hover:shadow-[0_20px_40px_rgba(92,61,30,0.1)]">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-[#F5C518] text-2xl">💛</div>
                <h3 class="mb-2 text-xl font-bold text-[#311f08] [font-family:'Playfair_Display',serif]">Harga Terjangkau</h3>
                <p class="text-sm leading-7 text-[#6B5C47]">Minuman enak tidak harus mahal. Cita rasa premium dengan harga yang ramah di kantong.</p>
            </div>
            <div class="rounded-2xl border border-[#5C3D1E]/10 bg-white p-8 transition hover:-translate-y-1.5 hover:shadow-[0_20px_40px_rgba(92,61,30,0.1)]">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-[#F5C518] text-2xl">⚡</div>
                <h3 class="mb-2 text-xl font-bold text-[#311f08] [font-family:'Playfair_Display',serif]">Pelayanan Cepat</h3>
                <p class="text-sm leading-7 text-[#6B5C47]">Proses pemesanan efisien dan ramah. Minuman siap tersaji tanpa menunggu lama.</p>
            </div>
        </div>
    </section>

    <section id="menu" class="bg-[#422b0e] px-6 py-20 lg:px-16">
        <div class="mb-12 flex flex-wrap items-center justify-between gap-4">
            <h2 class="text-4xl font-bold text-[#F5EDD6] [font-family:'Playfair_Display',serif] lg:text-5xl">Menu Terfavorit</h2>
            <span class="inline-flex items-center gap-1 rounded-full border border-[#F5C518]/35 bg-[#F5C518]/10 px-4 py-2 text-xs font-medium uppercase tracking-widest text-[#F5C518]">Best Seller</span>
        </div>
        <div id="menu-grid" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4"></div>
        <div class="mt-12 text-center">
            <a href="/menu" class="inline-block rounded-full border border-[#F5C518]/50 px-10 py-3.5 text-sm font-medium text-[#F5C518] transition hover:-translate-y-0.5 hover:bg-[#F5C518] hover:text-[#311f08]">Lihat Semua Menu</a>
        </div>
    </section>

    <section id="about" class="bg-[#FBF6EC] px-6 py-20 lg:px-16">
        <div class="mx-auto grid max-w-6xl items-center gap-16 lg:grid-cols-2">
            <div class="relative">
                <div class="pointer-events-none absolute -left-4 -top-4 h-20 w-20 rounded-full border-2 border-[#F5C518]/35"></div>
                <div class="pointer-events-none absolute -left-2 -top-2 h-14 w-14 rounded-full border border-[#F5C518]/20"></div>
                <div class="overflow-hidden rounded-3xl">
                    <img src="{{ asset('images/banner.png') }}" alt="Yellow Drink" class="aspect-[4/5] w-full object-cover" />
                    <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(160deg,rgba(245,197,24,0.08)_0%,transparent_40%,rgba(49,31,8,0.35)_100%)]"></div>
                </div>
                <div class="absolute -bottom-5 -right-5 flex h-28 w-28 flex-col items-center justify-center rounded-full bg-[#F5C518] text-[#311f08] shadow-[0_12px_30px_rgba(245,197,24,0.35)]">
                    <strong class="text-3xl font-black leading-none [font-family:'Playfair_Display',serif]">100%</strong>
                    <span class="text-xs font-medium">Terjangkau</span>
                </div>
            </div>
            <div>
                <span class="mb-2 block text-xs font-medium uppercase tracking-[0.15em] text-[#5C3D1E]">Tentang Kami</span>
                <h2 class="mb-6 text-4xl font-black leading-tight text-[#311f08] [font-family:'Playfair_Display',serif] lg:text-5xl">Yellow Drink,<br />Rasa yang Bicara</h2>
                <p class="mb-6 text-[0.95rem] leading-8 text-[#5C4430]">Yellow Drink adalah UMKM minuman kekinian yang berkomitmen menyajikan minuman berkualitas dengan harga terjangkau. Kami menggunakan bahan pilihan dan resep original yang terus disempurnakan.</p>
                <p class="mb-8 text-[0.95rem] leading-8 text-[#5C4430]">Dengan visi <em>Semua Berhak Minum Enak</em>, kami ingin memberikan pengalaman minum yang menyenangkan untuk semua kalangan.</p>
                <div class="space-y-4 text-sm font-medium text-[#311f08]">
                    <div class="flex items-center gap-3"><span class="h-2 w-2 rounded-full bg-[#F5C518]"></span>Resep original dikembangkan oleh tim kami</div>
                    <div class="flex items-center gap-3"><span class="h-2 w-2 rounded-full bg-[#F5C518]"></span>Bahan baku diperbarui setiap hari</div>
                    <div class="flex items-center gap-3"><span class="h-2 w-2 rounded-full bg-[#F5C518]"></span>Tanpa pengawet, tanpa pewarna buatan</div>
                </div>
            </div>
        </div>
    </section>

    <section id="location" class="bg-[#311f08] px-6 py-20 lg:px-16">
        <span class="mb-2 block text-center text-xs font-medium uppercase tracking-[0.15em] text-[#F5C518]">Kunjungi Kami</span>
        <h2 class="mb-14 text-center text-4xl font-bold text-[#F5EDD6] [font-family:'Playfair_Display',serif] lg:text-5xl">Lokasi Toko</h2>
        <div class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-2">
            <div class="h-[360px] overflow-hidden rounded-3xl border border-[#F5C518]/12 bg-white/5">
                <iframe src="https://www.google.com/maps?q=-6.573796898904178,106.7601842828633&output=embed" class="h-full w-full" style="border:0;" loading="lazy"></iframe>
            </div>
            <div class="space-y-8 rounded-3xl border border-[#F5C518]/12 bg-white/5 p-10">
                <div class="flex items-start gap-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#F5C518]/12 text-lg">📍</div>
                    <div>
                        <h4 class="mb-1 text-xs tracking-wider text-[#9E8A6E]">ALAMAT</h4>
                        <p class="text-sm leading-7 text-[#F2E8D0]">Jl. Contoh No. 123, Jakarta Selatan<br />DKI Jakarta, Indonesia 12345</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#F5C518]/12 text-lg">🕐</div>
                    <div>
                        <h4 class="mb-1 text-xs tracking-wider text-[#9E8A6E]">JAM OPERASIONAL</h4>
                        <p class="text-sm leading-7 text-[#F2E8D0]">Senin - Jumat: 09.00 - 21.00<br />Sabtu - Minggu: 10.00 - 22.00</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#F5C518]/12 text-lg">📞</div>
                    <div>
                        <h4 class="mb-1 text-xs tracking-wider text-[#9E8A6E]">KONTAK</h4>
                        <p class="text-sm leading-7 text-[#F2E8D0]"><a href="tel:+6281234567890" class="text-[#F5C518] hover:underline">+62 812-3456-7890</a><br /><a href="mailto:info@yellowdrink.com" class="text-[#F5C518] hover:underline">info@yellowdrink.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="flex flex-wrap items-center justify-between gap-4 border-t border-[#F5C518]/10 bg-[#422b0e] px-6 py-8 lg:px-16">
        <div class="text-xl font-bold text-[#F5C518] [font-family:'Playfair_Display',serif]">Yellow Drink</div>
        <p class="text-sm text-[#9E8A6E]">© 2025 Yellow Drink. Semua Berhak Minum Enak.</p>
        <div class="flex gap-3">
            <a href="#" class="flex h-9 w-9 items-center justify-center rounded-full border border-[#F5C518]/25 text-xs text-[#9E8A6E] transition hover:border-[#F5C518] hover:text-[#F5C518]">f</a>
            <a href="#" class="flex h-9 w-9 items-center justify-center rounded-full border border-[#F5C518]/25 text-xs text-[#9E8A6E] transition hover:border-[#F5C518] hover:text-[#F5C518]">ig</a>
            <a href="#" class="flex h-9 w-9 items-center justify-center rounded-full border border-[#F5C518]/25 text-xs text-[#9E8A6E] transition hover:border-[#F5C518] hover:text-[#F5C518]">tw</a>
        </div>
    </footer>

    <script>
        const allItems = [
            { name: 'Cokelat Oreo', desc: 'manis dan renyahnya coklat oreo', price: 'Rp 18.000', rating: '4.9', img: "{{ asset('images/coklatoreo.png') }}" },
            { name: 'Mangga Yakult', desc: 'Segar manis mangga + probiotik yakult', price: 'Rp 15.000', rating: '4.8', img: "{{ asset('images/manggayakult.png') }}" },
            { name: 'Brown Sugar', desc: 'Manis legit brown sugar milk tea', price: 'Rp 16.000', rating: '4.9', img: "{{ asset('images/brownsugar.png') }}" },
            { name: 'Taro Latte', desc: 'Creamy taro dengan susu segar premium', price: 'Rp 17.000', rating: '4.8', img: "{{ asset('images/tarolatte.png') }}" },
        ];

        function renderMenu() {
            const html = allItems.map((item) => `
                <div class="group overflow-hidden rounded-[20px] border border-[#F5C518]/10 bg-white/5 transition hover:-translate-y-2 hover:border-[#F5C518]/40 hover:bg-white/[0.07]">
                    <div class="relative h-52 overflow-hidden">
                        <img src="${item.img}" alt="${item.name}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#311f08]/80 via-transparent to-transparent"></div>
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-[#311f08]/25 via-transparent to-transparent"></div>
                        <span class="absolute right-3 top-3 rounded-full border border-[#F5C518]/20 bg-[#1A1208]/85 px-2.5 py-1 text-[0.72rem] text-[#F5C518]">${item.rating}</span>
                        <span class="absolute bottom-3 left-3 text-lg font-bold text-[#F5C518] drop-shadow-[0_2px_8px_rgba(0,0,0,0.4)] [font-family:'Playfair_Display',serif]">${item.price}</span>
                    </div>
                    <div class="p-4">
                        <h3 class="mb-1 text-lg font-bold text-[#F5EDD6] [font-family:'Playfair_Display',serif]">${item.name}</h3>
                        <p class="text-xs leading-6 text-[#9E8A6E]">${item.desc}</p>
                    </div>
                </div>
            `).join('');
            document.getElementById('menu-grid').innerHTML = html;
        }

        renderMenu();
    </script>
</body>
</html>

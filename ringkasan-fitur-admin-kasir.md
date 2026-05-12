Berikut ringkasan fitur yang ada per peran, dengan sudut pandang bisnis dan teknis. Saya buat format tabel agar mudah dipresentasikan.

**Admin**

- Fitur: Dashboard dan KPI
  Tujuan bisnis: Memantau performa penjualan, produk terjual, pengeluaran, dan laba bersih
  Proses teknis (UI + backend): UI dashboard grafik; backend agregasi penjualan 7 hari, total pendapatan, total pengeluaran
  DB/API yang terlibat: transaksis, detail_transaksis, expenses
  Hal teknis + interaksi: Hanya transaksi berstatus selesai; query agregasi perlu efisien; bisa di-cache jika trafik tinggi
- Fitur: Kelola produk dan varian
  Tujuan bisnis: Menjaga katalog, harga, stok, dan opsi varian
  Proses teknis (UI + backend): UI CRUD produk + varian; backend validasi, upload gambar, sinkronisasi varian
  DB/API yang terlibat: products, product_variants, kategoris, product_images
  Hal teknis + interaksi: Validasi nama unik, harga, stok; upload file type/size; varian aktif dipakai di POS
- Fitur: Kelola kategori produk
  Tujuan bisnis: Klasifikasi produk untuk navigasi dan laporan
  Proses teknis (UI + backend): UI CRUD kategori; backend cache kategori
  DB/API yang terlibat: kategoris
  Hal teknis + interaksi: Cache kategori 1 jam, perlu invalidasi saat update
- Fitur: Kelola gambar produk
  Tujuan bisnis: Manajemen media produk terpusat
  Proses teknis (UI + backend): UI upload/search/edit/delete gambar; backend simpan file dan kaitkan ke produk
  DB/API yang terlibat: product_images, products
  Hal teknis + interaksi: File disimpan di public; validasi mime/size; jika dikaitkan ke produk maka gambar produk ikut diperbarui
- Fitur: Kelola event diskon
  Tujuan bisnis: Menjalankan promo periode tertentu
  Proses teknis (UI + backend): UI CRUD event; backend validasi tanggal dan persen; diskon diterapkan saat transaksi
  DB/API yang terlibat: discount_events, transaksis
  Hal teknis + interaksi: Event aktif berbasis tanggal dan flag; diskon mempengaruhi total dan laporan
- Fitur: Kelola pengeluaran dan kategori
  Tujuan bisnis: Kontrol biaya operasional untuk hitung laba bersih
  Proses teknis (UI + backend): UI CRUD pengeluaran + filter periode/kategori; upload bukti
  DB/API yang terlibat: expenses, expense_categories, users
  Hal teknis + interaksi: Lampiran disimpan di storage publik; kategori tidak bisa dihapus jika masih dipakai
- Fitur: Kelola kasir (user)
  Tujuan bisnis: Mengatur akses kasir
  Proses teknis (UI + backend): UI daftar/tambah/ubah/hapus kasir; backend hash password, role kasir
  DB/API yang terlibat: users, transaksis
  Hal teknis + interaksi: Email harus unik; tidak boleh hapus kasir yang punya transaksi
- Fitur: Laporan penjualan
  Tujuan bisnis: Analisis performa per hari/minggu/bulan + top produk
  Proses teknis (UI + backend): UI grafik + ringkasan; backend agregasi dan filter periode; ekspor PDF/Excel
  DB/API yang terlibat: transaksis, detail_transaksis, products, pembayarans
  Hal teknis + interaksi: Hanya transaksi selesai; ekspor via generator PDF/Excel
- Fitur: Manajemen transaksi
  Tujuan bisnis: Audit, koreksi, dan validasi transaksi
  Proses teknis (UI + backend): UI daftar dan detail transaksi; backend ubah status (selesai, batal, suspend), ekspor struk
  DB/API yang terlibat: transaksis, detail_transaksis, products, pembayarans, discount_events
  Hal teknis + interaksi: Pembatalan mengembalikan stok; status pending bisa disuspend; admin lihat semua transaksi
- Fitur: Pengaturan konten halaman publik
  Tujuan bisnis: Mengubah konten landing dan menu tanpa coding
  Proses teknis (UI + backend): UI editor konten; backend simpan JSON dan gabungkan dengan default
  DB/API yang terlibat: dashboard_settings
  Hal teknis + interaksi: Validasi JSON; konten dipakai di halaman publik

**Kasir**

- Fitur: Dashboard kasir
  Tujuan bisnis: Melihat performa harian dan transaksi terakhir
  Proses teknis (UI + backend): UI grafik 7 hari dan ringkasan; backend agregasi transaksi milik kasir
  DB/API yang terlibat: transaksis, detail_transaksis, pembayarans
  Hal teknis + interaksi: Filter berdasarkan user kasir; query ringkas agar cepat
- Fitur: POS dan buat transaksi
  Tujuan bisnis: Menjalankan penjualan cepat dan akurat
  Proses teknis (UI + backend): UI pilih produk, varian, diskon, jumlah; backend validasi, cek stok, hitung total, simpan transaksi dan pembayaran
  DB/API yang terlibat: products, product_variants, transaksis, detail_transaksis, pembayarans, discount_events
  Hal teknis + interaksi: Pembayaran cash wajib jumlah bayar; non-cash otomatis penuh; transaksi dibuat dalam DB transaction; stok dikurangi
- Fitur: Selesaikan, suspend, batalkan transaksi
  Tujuan bisnis: Menangani transaksi pending dan koreksi
  Proses teknis (UI + backend): UI aksi status; backend update metode bayar dan jumlah bayar, status selesai, atau batalkan dan kembalikan stok
  DB/API yang terlibat: transaksis, pembayarans, products
  Hal teknis + interaksi: Cancel mengembalikan stok; suspend menyimpan status pending; hanya transaksi milik kasir
- Fitur: Cetak struk
  Tujuan bisnis: Memberi bukti pembayaran ke pelanggan
  Proses teknis (UI + backend): UI tombol ekspor; backend generate struk PDF/Excel
  DB/API yang terlibat: transaksis, detail_transaksis, pembayarans, discount_events
  Hal teknis + interaksi: Hanya transaksi sendiri; template struk konsisten dengan laporan
- Fitur: Riwayat transaksi saya
  Tujuan bisnis: Melacak transaksi yang sudah dibuat
  Proses teknis (UI + backend): UI list dan detail transaksi; backend filter berdasarkan user kasir
  DB/API yang terlibat: transaksis, detail_transaksis, pembayarans
  Hal teknis + interaksi: Pagination; akses dibatasi per user
- Fitur: Laporan kasir
  Tujuan bisnis: Evaluasi performa per kasir
  Proses teknis (UI + backend): UI filter periode dan grafik; backend agregasi hanya transaksi kasir
  DB/API yang terlibat: transaksis, detail_transaksis, products
  Hal teknis + interaksi: Ekspor PDF/Excel; periodik (harian, mingguan, bulanan)
- Fitur: Cek produk dan stok
  Tujuan bisnis: Mengetahui ketersediaan dan harga
  Proses teknis (UI + backend): UI daftar produk read-only; backend ambil produk aktif dan kategori
  DB/API yang terlibat: products, product_variants, kategoris
  Hal teknis + interaksi: Data kategori di-cache; POS hanya tampilkan stok > 0
- Fitur: Catat pengeluaran kasir
  Tujuan bisnis: Pencatatan biaya operasional per shift
  Proses teknis (UI + backend): UI CRUD pengeluaran; backend simpan dan filter; upload bukti
  DB/API yang terlibat: expenses, expense_categories, users
  Hal teknis + interaksi: Akses hanya data milik kasir; validasi jumlah dan lampiran

**Catatan teknis lintas fitur (untuk audiens teknis)**

- Akses dikontrol oleh role (admin atau kasir) dan autentikasi.
- Validasi input dilakukan di layer request sebelum masuk bisnis proses.
- Transaksi memakai DB transaction untuk menjaga konsistensi stok dan pembayaran.
- Cache dipakai untuk data yang jarang berubah (kategori, notifikasi stok menipis).
- File upload perlu batas ukuran dan mime; disimpan di public atau storage publik.

Jika Anda mau, saya bisa:

1. Ubah format ini menjadi 1 fitur per slide dengan speaker notes.
2. Tambahkan fitur lain yang spesifik di aplikasi Anda (misalnya retur, membership, atau inventory opname).

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardSetting extends Model
{
    use HasFactory;

    protected $table = 'dashboard_settings';

    protected $fillable = [
        'page',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public static function defaultsForPage(string $page): array
    {
        return match ($page) {
            'welcome' => [
                'brand_name' => 'Yellow Drink',
                'hero_badge' => 'Minuman Kekinian Terbaik',
                'hero_title' => 'Segarnya Rasa',
                'hero_highlight' => 'Temani',
                'hero_title_suffix' => 'Setiap Cerita',
                'hero_subtitle' => 'Minuman berkualitas, harga ramah di kantong. Karena semua berhak minum enak.',
                'hero_primary_label' => 'Lihat Menu',
                'hero_primary_link' => '#menu',
                'hero_secondary_label' => 'Temukan Toko',
                'hero_secondary_link' => '#location',
                'hero_image' => 'images/drink.png',
                'banner_image' => 'images/banner.png',
                'stats' => [
                    ['value' => '15+', 'label' => 'Varian Menu', 'detail' => 'Pilihan'],
                    ['value' => '100%', 'label' => 'Bahan Segar', 'detail' => 'Alami'],
                    ['value' => '4.9', 'label' => 'Rating', 'detail' => 'Pelanggan'],
                    ['value' => '500+', 'label' => 'Pelanggan', 'detail' => 'Setia'],
                ],
                'feature_section_title' => 'Kenapa Yellow Drink?',
                'features' => [
                    ['emoji' => '🌿', 'title' => 'Bahan Berkualitas', 'description' => '100% menggunakan bahan pilihan terbaik, segar, alami, dan dipilih dengan cermat setiap harinya.'],
                    ['emoji' => '💛', 'title' => 'Harga Terjangkau', 'description' => 'Minuman enak tidak harus mahal. Cita rasa premium dengan harga yang ramah di kantong.'],
                    ['emoji' => '⚡', 'title' => 'Pelayanan Cepat', 'description' => 'Proses pemesanan efisien dan ramah. Minuman siap tersaji tanpa menunggu lama.'],
                ],
                'about_badge' => 'Tentang Kami',
                'about_title' => 'Yellow Drink, biar rasa yang bicara',
                'about_body_1' => 'Yellow Drink adalah UMKM minuman kekinian yang berkomitmen menyajikan minuman berkualitas dengan harga terjangkau. Kami menggunakan bahan pilihan dan resep original yang terus disempurnakan.',
                'about_body_2' => 'Dengan visi Semua Berhak Minum Enak, kami ingin memberikan pengalaman minum yang menyenangkan untuk semua kalangan.',
                'about_points' => [
                    'Resep original dikembangkan oleh tim kami',
                    'Bahan baku diperbarui setiap hari',
                    'Tanpa pengawet, tanpa pewarna buatan',
                ],
                'about_image' => 'images/banner.png',
                'about_badge_value' => '100%',
                'about_badge_label' => 'Terjangkau',
                'location_badge' => 'Kunjungi Kami',
                'location_title' => 'Lokasi Toko',
                'location_map_embed' => 'https://www.google.com/maps?q=-6.573796898904178,106.7601842828633&output=embed',
                'location_address' => "Jl. Sindang Barang Pengkolan No.132, RT.04/RW.06, Sindangbarang, Kec. Bogor Bar., Kota Bogor, Jawa Barat 16117",
                'location_hours' => "Setiap Hari: 09.00 - 19.00",
                'location_phone' => '+62 816-634-757',
                'footer_note' => '© 2025 Yellow Drink. Semua Berhak Minum Enak.',
            ],
            'menu' => [
                'page_title' => 'Semua Menu',
                'page_highlight' => 'Menu',
                'page_subtitle' => 'Pilih favoritmu dari produk yang aktif di database, lengkap dengan kategori dan varian.',
                'page_badge' => 'Menu Aktif',
                'page_intro_title' => 'Menu Terfavorit',
                'page_intro_subtitle' => 'Produk di bawah ini diambil langsung dari data produk.',
                'empty_title' => 'Belum ada produk aktif',
                'empty_message' => 'Tambahkan produk aktif di admin product management untuk menampilkan menu di sini.',
                'cta_label' => 'Lihat Beranda',
                'cta_link' => '/',
                'product_limit_per_category' => 12,
            ],
            default => [],
        };
    }

    public static function pageContent(string $page): array
    {
        $record = static::query()->where('page', $page)->first();

        return array_replace_recursive(static::defaultsForPage($page), $record?->content ?? []);
    }

    public static function upsertPage(string $page, array $content): self
    {
        return static::updateOrCreate([
            'page' => $page,
        ], [
            'content' => $content,
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Product;
use App\Models\ProductVariant;

class MenuSeeder extends Seeder
{
    /**
     * Seed semua menu Yellow Drink sesuai brosur.
     *
     * Jalankan: php artisan db:seed --class=MenuSeeder
     */
    public function run(): void
    {
        // ──────────────────────────────────────
        // 1. HAPUS DATA LAMA
        // ──────────────────────────────────────
        ProductVariant::query()->delete();
        Product::query()->delete();
        Kategori::query()->delete();

        // Clear category cache
        cache()->forget('kategoris_all');
        cache()->forget('kategoris_with_count');

        // ──────────────────────────────────────
        // 2. BUAT KATEGORI
        // ──────────────────────────────────────
        $categories = [
            'Cream Series'   => 'Minuman cream dengan topping boba/cincau',
            'Ice Cream'      => 'Aneka ice cream cup',
            'Smoothies'      => 'Minuman smoothies buah segar',
            'Coconut Shake'  => 'Coconut shake series',
            'Yogurt'         => 'Minuman yogurt segar',
            'Yakult'         => 'Minuman yakult segar',
            'Milk Series'    => 'Susu dan milk-based drinks',
            'Tea'            => 'Aneka teh dan lemon',
        ];

        $catModels = [];
        foreach ($categories as $nama => $deskripsi) {
            $catModels[$nama] = Kategori::create([
                'nama_kategori' => $nama,
                'deskripsi'     => $deskripsi,
            ]);
        }

        // ──────────────────────────────────────
        // 3. HELPER: Variant templates
        // ──────────────────────────────────────

        // M:7k, L:9k, XL:11k, XXL:15k  → base = 7000
        $varCream = [
            ['kode_variant' => 'M',   'nama_variant' => 'Medium',       'harga_tambahan' => 0,    'urutan' => 1],
            ['kode_variant' => 'L',   'nama_variant' => 'Large',        'harga_tambahan' => 2000, 'urutan' => 2],
            ['kode_variant' => 'XL',  'nama_variant' => 'Extra Large',  'harga_tambahan' => 4000, 'urutan' => 3],
            ['kode_variant' => 'XXL', 'nama_variant' => 'Extra Extra Large', 'harga_tambahan' => 8000, 'urutan' => 4],
        ];

        // XL:15k, XXL:20k → base = 15000
        $varSmoothie = [
            ['kode_variant' => 'XL',  'nama_variant' => 'Extra Large',  'harga_tambahan' => 0,    'urutan' => 1],
            ['kode_variant' => 'XXL', 'nama_variant' => 'Extra Extra Large', 'harga_tambahan' => 5000, 'urutan' => 2],
        ];

        // L:10k, XL:12k → base = 10000
        $varL10_XL12 = [
            ['kode_variant' => 'L',  'nama_variant' => 'Large',       'harga_tambahan' => 0,    'urutan' => 1],
            ['kode_variant' => 'XL', 'nama_variant' => 'Extra Large', 'harga_tambahan' => 2000, 'urutan' => 2],
        ];

        // L:12k, XL:15k → base = 12000
        $varL12_XL15 = [
            ['kode_variant' => 'L',  'nama_variant' => 'Large',       'harga_tambahan' => 0,    'urutan' => 1],
            ['kode_variant' => 'XL', 'nama_variant' => 'Extra Large', 'harga_tambahan' => 3000, 'urutan' => 2],
        ];

        // L:18k, XL:20k → base = 18000
        $varL18_XL20 = [
            ['kode_variant' => 'L',  'nama_variant' => 'Large',       'harga_tambahan' => 0,    'urutan' => 1],
            ['kode_variant' => 'XL', 'nama_variant' => 'Extra Large', 'harga_tambahan' => 2000, 'urutan' => 2],
        ];

        // L:9k, XL:12k → base = 9000
        $varL9_XL12 = [
            ['kode_variant' => 'L',  'nama_variant' => 'Large',       'harga_tambahan' => 0,    'urutan' => 1],
            ['kode_variant' => 'XL', 'nama_variant' => 'Extra Large', 'harga_tambahan' => 3000, 'urutan' => 2],
        ];

        // M:7k, L:9k, XL:12k → base = 7000
        $varM7_L9_XL12 = [
            ['kode_variant' => 'M',  'nama_variant' => 'Medium',      'harga_tambahan' => 0,    'urutan' => 1],
            ['kode_variant' => 'L',  'nama_variant' => 'Large',       'harga_tambahan' => 2000, 'urutan' => 2],
            ['kode_variant' => 'XL', 'nama_variant' => 'Extra Large', 'harga_tambahan' => 5000, 'urutan' => 3],
        ];

        // L:7k, XL:9k → base = 7000
        $varL7_XL9 = [
            ['kode_variant' => 'L',  'nama_variant' => 'Large',       'harga_tambahan' => 0,    'urutan' => 1],
            ['kode_variant' => 'XL', 'nama_variant' => 'Extra Large', 'harga_tambahan' => 2000, 'urutan' => 2],
        ];

        // L:4k, XL:6k → base = 4000
        $varL4_XL6 = [
            ['kode_variant' => 'L',  'nama_variant' => 'Large',       'harga_tambahan' => 0,    'urutan' => 1],
            ['kode_variant' => 'XL', 'nama_variant' => 'Extra Large', 'harga_tambahan' => 2000, 'urutan' => 2],
        ];

        // ──────────────────────────────────────
        // 4. PRODUK CREAM SERIES
        //    M:7k, L:9k, XL:11k, XXL:15k
        // ──────────────────────────────────────
        $creamProducts = [
            'Cokelat Oreo',
            'Cokelat Magnum',
            'Cokelat Milo',
            'Cokelat Delfi',
            'Silverqueen',
            'Kopi Caramel',
            'Cappucino',
            'Tiramisu',
            'Taro',
            'Hazelnut',
            'Green Tea',
            'Vanilla Milk',
            'Vanilla Latte',
            'Mocca Latte',
            'Bubblegum',
            'Red Velvet',
            'Alpukat',
            'Durian',
            'Leci',
            'Mangga',
            'Melon',
        ];

        foreach ($creamProducts as $name) {
            $product = Product::create([
                'nama_produk' => $name,
                'kategori_id' => $catModels['Cream Series']->id,
                'harga'       => 7000,
                'stok'        => 100,
                'status'      => 'active',
            ]);
            $this->createVariants($product, $varCream);
        }

        // ──────────────────────────────────────
        // 5. ICE CREAM (tanpa variant)
        // ──────────────────────────────────────
        $iceCreamProducts = [
            ['nama' => 'Ice Cream Original',    'harga' => 13000],
            ['nama' => 'Ice Cream Oreo',        'harga' => 15000],
            ['nama' => 'Ice Cream Strawberry',  'harga' => 15000],
        ];

        foreach ($iceCreamProducts as $item) {
            Product::create([
                'nama_produk' => $item['nama'],
                'kategori_id' => $catModels['Ice Cream']->id,
                'harga'       => $item['harga'],
                'stok'        => 100,
                'status'      => 'active',
            ]);
        }

        // ──────────────────────────────────────
        // 6. SMOOTHIES — XL:15k, XXL:20k
        // ──────────────────────────────────────
        $smoothieProducts = [
            'Alpukat Smoothies',
            'Strawberry Smoothies',
            'Mangga Smoothies',
            'Dragon Smoothies',
        ];

        foreach ($smoothieProducts as $name) {
            $product = Product::create([
                'nama_produk' => $name,
                'kategori_id' => $catModels['Smoothies']->id,
                'harga'       => 15000,
                'stok'        => 100,
                'status'      => 'active',
            ]);
            $this->createVariants($product, $varSmoothie);
        }

        // ──────────────────────────────────────
        // 7. COCONUT SHAKE (harga berbeda per produk)
        // ──────────────────────────────────────
        $coconutShakes = [
            ['nama' => 'Coconut Shake Original',    'harga' => 10000, 'variants' => $varL10_XL12],
            ['nama' => 'Coconut Shake Strawberry',  'harga' => 12000, 'variants' => $varL12_XL15],
            ['nama' => 'Coconut Shake Ice Cream',   'harga' => 18000, 'variants' => $varL18_XL20],
        ];

        foreach ($coconutShakes as $item) {
            $product = Product::create([
                'nama_produk' => $item['nama'],
                'kategori_id' => $catModels['Coconut Shake']->id,
                'harga'       => $item['harga'],
                'stok'        => 100,
                'status'      => 'active',
            ]);
            $this->createVariants($product, $item['variants']);
        }

        // ──────────────────────────────────────
        // 8. YOGURT — L:10k, XL:12k
        // ──────────────────────────────────────
        $yogurtProducts = [
            'Mangga Yogurt',
            'Strawberry Yogurt',
            'Blueberry Yogurt',
        ];

        foreach ($yogurtProducts as $name) {
            $product = Product::create([
                'nama_produk' => $name,
                'kategori_id' => $catModels['Yogurt']->id,
                'harga'       => 10000,
                'stok'        => 100,
                'status'      => 'active',
            ]);
            $this->createVariants($product, $varL10_XL12);
        }

        // ──────────────────────────────────────
        // 9. YAKULT — L:9k, XL:12k
        // ──────────────────────────────────────
        $yakultProducts = [
            'Leci Yakult',
            'Mangga Yakult',
        ];

        foreach ($yakultProducts as $name) {
            $product = Product::create([
                'nama_produk' => $name,
                'kategori_id' => $catModels['Yakult']->id,
                'harga'       => 9000,
                'stok'        => 100,
                'status'      => 'active',
            ]);
            $this->createVariants($product, $varL9_XL12);
        }

        // ──────────────────────────────────────
        // 10. MILK SERIES
        // ──────────────────────────────────────

        // L:9k, XL:12k group
        $milkL9 = [
            'Blueberry Milk',
            'Strawberry Milk',
            'Brown Sugar Milk Tea',
            'Caramel Regal',
            'Strawberry Cokelat Cream & Boba',
        ];

        foreach ($milkL9 as $name) {
            $product = Product::create([
                'nama_produk' => $name,
                'kategori_id' => $catModels['Milk Series']->id,
                'harga'       => 9000,
                'stok'        => 100,
                'status'      => 'active',
            ]);
            $this->createVariants($product, $varL9_XL12);
        }

        // M:7k, L:9k, XL:12k group
        $milkM7 = [
            'Milk Cincau Brown Sugar',
            'Milk Coconut Pandan',
        ];

        foreach ($milkM7 as $name) {
            $product = Product::create([
                'nama_produk' => $name,
                'kategori_id' => $catModels['Milk Series']->id,
                'harga'       => 7000,
                'stok'        => 100,
                'status'      => 'active',
            ]);
            $this->createVariants($product, $varM7_L9_XL12);
        }

        // ──────────────────────────────────────
        // 11. TEA
        // ──────────────────────────────────────

        // L:10k, XL:12k
        $teaL10 = [
            'Thai Tea',
            'Thai Tea Green',
        ];

        foreach ($teaL10 as $name) {
            $product = Product::create([
                'nama_produk' => $name,
                'kategori_id' => $catModels['Tea']->id,
                'harga'       => 10000,
                'stok'        => 100,
                'status'      => 'active',
            ]);
            $this->createVariants($product, $varL10_XL12);
        }

        // L:7k, XL:9k
        $teaL7 = [
            'Lemon Tea',
            'Squeeze Lemon',
        ];

        foreach ($teaL7 as $name) {
            $product = Product::create([
                'nama_produk' => $name,
                'kategori_id' => $catModels['Tea']->id,
                'harga'       => 7000,
                'stok'        => 100,
                'status'      => 'active',
            ]);
            $this->createVariants($product, $varL7_XL9);
        }

        // Es Teh — L:4k, XL:6k
        $product = Product::create([
            'nama_produk' => 'Es Teh',
            'kategori_id' => $catModels['Tea']->id,
            'harga'       => 4000,
            'stok'        => 100,
            'status'      => 'active',
        ]);
        $this->createVariants($product, $varL4_XL6);

        // ──────────────────────────────────────
        // SUMMARY
        // ──────────────────────────────────────
        $totalProducts = Product::count();
        $totalVariants = ProductVariant::count();
        $totalCategories = Kategori::count();

        $this->command->info("✅ Seeder selesai!");
        $this->command->info("   Kategori : {$totalCategories}");
        $this->command->info("   Produk   : {$totalProducts}");
        $this->command->info("   Variant  : {$totalVariants}");
    }

    /**
     * Buat variant untuk sebuah product.
     */
    private function createVariants(Product $product, array $variants): void
    {
        foreach ($variants as $v) {
            ProductVariant::create([
                'product_id'     => $product->id,
                'kode_variant'   => $v['kode_variant'],
                'nama_variant'   => $v['nama_variant'],
                'harga_tambahan' => $v['harga_tambahan'],
                'is_active'      => true,
                'urutan'         => $v['urutan'],
            ]);
        }
    }
}

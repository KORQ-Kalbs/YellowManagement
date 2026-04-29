<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductImageSeeder extends Seeder
{
    /**
     * Files to skip (non-product images)
     */
    private array $skipFiles = ['banner', 'drink', 'logo', 'icon'];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageDirectory = public_path('images');

        if (! File::exists($imageDirectory)) {
            $this->command->error('Images directory not found!');
            return;
        }

        // Clear old product images and reset gambar_produk
        ProductImage::query()->delete();
        Product::query()->update(['gambar_produk' => null]);

        $files = File::allFiles($imageDirectory);
        $linked = 0;
        $skipped = 0;
        $notFound = 0;

        foreach ($files as $file) {
            $filename = strtolower($file->getFilename());
            $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);

            // Skip non-product files
            if ($this->shouldSkipFile($filenameWithoutExt)) {
                $this->command->line("⏭️  Skipped: {$filename}");
                $skipped++;
                continue;
            }

            // Try to find matching product
            $product = $this->findProductByImageName($filenameWithoutExt);

            if (!$product) {
                $this->command->warn("❌ No product found for: {$filename}");
                $notFound++;
                continue;
            }

            // Skip if product already has an image (due to unique constraint)
            if ($product->productImage()->exists()) {
                $this->command->line("⏭️  Skipped (duplicate): {$filename} → {$product->nama_produk} already has image");
                $skipped++;
                continue;
            }

            // Create image record and link to product
            $absolutePath = $file->getPathname();
            $relativePath = 'images/' . $file->getFilename();
            $detectedMimeType = File::mimeType($absolutePath) ?: 'application/octet-stream';

            $productImage = ProductImage::create([
                'product_id' => $product->id,
                'title' => Str::headline($filenameWithoutExt),
                'alt_text' => $product->nama_produk,
                'original_name' => $file->getFilename(),
                'file_name' => $file->getFilename(),
                'file_path' => $relativePath,
                'mime_type' => $detectedMimeType,
                'size' => $file->getSize(),
            ]);

            // Update product's gambar_produk field
            $product->update([
                'gambar_produk' => $relativePath,
            ]);

            $this->command->info("✅ Linked: {$filename} → {$product->nama_produk}");
            $linked++;
        }

        // Summary
        $this->command->info("\n" . str_repeat("─", 60));
        $this->command->info("📊 Product Image Seeding Summary:");
        $this->command->info("   ✅ Linked   : {$linked}");
        $this->command->info("   ⏭️  Skipped  : {$skipped} (includes duplicates & non-products)");
        $this->command->info("   ❌ Not Found: {$notFound}");
        $this->command->info(str_repeat("─", 60));
    }

    /**
     * Check if file should be skipped
     */
    private function shouldSkipFile(string $filename): bool
    {
        foreach ($this->skipFiles as $skip) {
            if (str_contains(strtolower($filename), strtolower($skip))) {
                return true;
            }
        }
        return false;
    }

    /**
     * Find product by image filename using fuzzy matching
     * 
     * Examples:
     * - "coklatoreo.png" → "Cokelat Oreo"
     * - "cappuccino.png" → "Cappucino"
     * - "tarolatte.png" → "Taro" or "Taro Latte"
     */
    private function findProductByImageName(string $imageName): ?Product
    {
        $products = Product::all();

        // Normalize image name
        $normalizedImage = $this->normalizeString($imageName);

        // Exact match first
        foreach ($products as $product) {
            if ($normalizedImage === $this->normalizeString($product->nama_produk)) {
                return $product;
            }
        }

        // Fuzzy matching - check if all words in product name exist in image name
        foreach ($products as $product) {
            $productWords = $this->getWords($this->normalizeString($product->nama_produk));
            $imageWords = $this->getWords($normalizedImage);

            // Check if any product word is in image
            $matches = 0;
            foreach ($productWords as $word) {
                if (in_array($word, $imageWords) || str_contains($normalizedImage, $word)) {
                    $matches++;
                }
            }

            // If more than 50% of product words match, consider it a match
            if ($matches > 0 && $matches >= ceil(count($productWords) * 0.5)) {
                return $product;
            }
        }

        // Substring matching - if product name is substring of image
        foreach ($products as $product) {
            $normalized = $this->normalizeString($product->nama_produk);
            if (str_contains($normalizedImage, $normalized) || str_contains($normalized, $normalizedImage)) {
                return $product;
            }
        }

        return null;
    }

    /**
     * Normalize string for comparison
     * - Remove spaces
     * - Convert to lowercase
     * - Remove special characters
     */
    private function normalizeString(string $str): string
    {
        $str = strtolower($str);
        $str = preg_replace('/[^a-z0-9]/', '', $str);
        return $str;
    }

    /**
     * Get words from string
     */
    private function getWords(string $str): array
    {
        return preg_split('/[^a-z0-9]+/', $str, -1, PREG_SPLIT_NO_EMPTY);
    }
}
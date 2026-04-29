<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class VerifyImageMatching extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:image-matching {--verbose}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Verify and preview image-to-product matching without seeding';

    /**
     * Files to skip (non-product images)
     */
    private array $skipFiles = ['banner', 'drink', 'logo', 'icon'];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info("🔍 Verifying image-to-product matching...\n");

        $imageDirectory = public_path('images');

        if (! File::exists($imageDirectory)) {
            $this->error('❌ Images directory not found!');
            return self::FAILURE;
        }

        $files = File::allFiles($imageDirectory);
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->error('❌ No products found! Run MenuSeeder first: php artisan db:seed --class=MenuSeeder');
            return self::FAILURE;
        }

        $linked = [];
        $skipped = [];
        $notFound = [];
        $duplicates = [];

        foreach ($files as $file) {
            $filename = strtolower($file->getFilename());
            $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);

            // Skip non-product files
            if ($this->shouldSkipFile($filenameWithoutExt)) {
                $skipped[] = $filename;
                continue;
            }

            // Try to find matching product
            $product = $this->findProductByImageName($filenameWithoutExt);

            if (!$product) {
                $notFound[] = $filename;
            } else {
                // Check if product already has an image
                if (in_array($product->id, array_column($linked, 'product_id'))) {
                    // Duplicate: product already linked
                    $duplicates[] = [
                        'image' => $filename,
                        'product' => $product->nama_produk,
                    ];
                } else {
                    $linked[] = [
                        'image' => $filename,
                        'product' => $product->nama_produk,
                        'product_id' => $product->id,
                        'category' => $product->kategori->nama_kategori ?? 'N/A',
                    ];
                }
            }
        }

        // Display results
        $this->displayLinked($linked);
        $this->displayDuplicates($duplicates);
        $this->displaySkipped($skipped);
        $this->displayNotFound($notFound);

        // Summary
        $this->info("\n" . str_repeat("─", 70));
        $this->line("📊 Verification Summary:");
        $this->info("   ✅ Can be linked : " . count($linked));
        $this->line("   🔄 Duplicates   : " . count($duplicates));
        $this->line("   ⏭️  Skipped      : " . count($skipped));
        $this->warn("   ❌ Not found    : " . count($notFound));
        $this->info(str_repeat("─", 70));

        if (count($notFound) === 0 && count($linked) > 0) {
            $this->info("\n✨ All images can be successfully linked! Run this to seed:");
            $this->line("   php artisan db:seed --class=ProductImageSeeder");
            return self::SUCCESS;
        }

        return count($notFound) > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function displayLinked(array $linked): void
    {
        if (empty($linked)) {
            return;
        }

        $this->info("\n✅ Images that can be linked (" . count($linked) . "):");
        $this->line(str_repeat("─", 70));

        foreach ($linked as $item) {
            $this->line(sprintf(
                "  %-30s → %-25s [%s]",
                $item['image'],
                $item['product'],
                $item['category']
            ));
        }
    }

    private function displayDuplicates(array $duplicates): void
    {
        if (empty($duplicates)) {
            return;
        }

        $this->warn("\n🔄 Duplicate images (product already linked) (" . count($duplicates) . "):");
        $this->line(str_repeat("─", 70));

        foreach ($duplicates as $item) {
            $this->line(sprintf(
                "  %-30s → %-25s (SKIPPED - product already has image)",
                $item['image'],
                $item['product']
            ));
        }
    }

    private function displaySkipped(array $skipped): void
    {
        if (empty($skipped)) {
            return;
        }

        $this->info("\n⏭️  Skipped files (" . count($skipped) . "):");
        $this->line(str_repeat("─", 70));

        foreach ($skipped as $filename) {
            $this->line("  {$filename}");
        }
    }

    private function displayNotFound(array $notFound): void
    {
        if (empty($notFound)) {
            return;
        }

        $this->warn("\n❌ Images with no matching product (" . count($notFound) . "):");
        $this->line(str_repeat("─", 70));

        foreach ($notFound as $filename) {
            $this->line("  {$filename}");
            $this->line("  💡 Tip: Rename this file to match a product name, or add it to skipFiles");
        }
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

        // Fuzzy matching
        foreach ($products as $product) {
            $productWords = $this->getWords($this->normalizeString($product->nama_produk));
            $imageWords = $this->getWords($normalizedImage);

            $matches = 0;
            foreach ($productWords as $word) {
                if (in_array($word, $imageWords) || str_contains($normalizedImage, $word)) {
                    $matches++;
                }
            }

            if ($matches > 0 && $matches >= ceil(count($productWords) * 0.5)) {
                return $product;
            }
        }

        // Substring matching
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

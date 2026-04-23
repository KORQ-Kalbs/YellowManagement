<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageDirectory = public_path('images');

        if (! File::exists($imageDirectory)) {
            return;
        }

        $files = File::allFiles($imageDirectory);

        foreach ($files as $file) {
            $absolutePath = $file->getPathname();
            $relativePath = 'images/' . str_replace('\\', '/', ltrim(Str::after($absolutePath, public_path('images') . DIRECTORY_SEPARATOR), '/\\'));
            $detectedMimeType = File::mimeType($absolutePath) ?: 'application/octet-stream';

            ProductImage::updateOrCreate(
                ['file_path' => $relativePath],
                [
                    'title' => Str::headline(pathinfo($file->getFilename(), PATHINFO_FILENAME)),
                    'alt_text' => Str::headline(pathinfo($file->getFilename(), PATHINFO_FILENAME)),
                    'original_name' => $file->getFilename(),
                    'file_name' => $file->getFilename(),
                    'mime_type' => $detectedMimeType,
                    'size' => $file->getSize(),
                ]
            );
        }
    }
}
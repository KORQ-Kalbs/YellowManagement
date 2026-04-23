<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductImageController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $imagesQuery = ProductImage::query()->latest();

        if ($search !== '') {
            $imagesQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('original_name', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%");
            });
        }

        $images = $imagesQuery->paginate(12)->withQueryString();

        $stats = [
            'total' => ProductImage::count(),
            'recent' => ProductImage::where('created_at', '>=', now()->subDays(7))->count(),
            'searched' => $search !== '' ? $images->total() : null,
        ];

        return view('admin.img-product.index', compact('images', 'stats', 'search'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],
        ]);

        $uploadedFile = $request->file('image');
        $storedImage = $this->storeUploadedImage($uploadedFile);

        ProductImage::create([
            'title' => $validated['title'] ?? null,
            'alt_text' => $validated['alt_text'] ?? null,
            'original_name' => $uploadedFile->getClientOriginalName(),
            'file_name' => $storedImage['file_name'],
            'file_path' => $storedImage['file_path'],
            'mime_type' => $uploadedFile->getClientMimeType(),
            'size' => $uploadedFile->getSize(),
        ]);

        return redirect()
            ->route('admin.img-product.index')
            ->with('success', 'Image uploaded successfully');
    }

    public function update(Request $request, ProductImage $productImage): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],
        ]);

        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $storedImage = $this->storeUploadedImage($uploadedFile);

            $this->deleteImageFile($productImage->file_path);

            $productImage->update([
                'original_name' => $uploadedFile->getClientOriginalName(),
                'file_name' => $storedImage['file_name'],
                'file_path' => $storedImage['file_path'],
                'mime_type' => $uploadedFile->getClientMimeType(),
                'size' => $uploadedFile->getSize(),
            ]);
        }

        $productImage->update([
            'title' => $validated['title'] ?? null,
            'alt_text' => $validated['alt_text'] ?? null,
        ]);

        return redirect()
            ->route('admin.img-product.index')
            ->with('success', 'Image updated successfully');
    }

    public function destroy(ProductImage $productImage): RedirectResponse
    {
        $this->deleteImageFile($productImage->file_path);
        $productImage->delete();

        return redirect()
            ->route('admin.img-product.index')
            ->with('success', 'Image deleted successfully');
    }

    private function storeUploadedImage($uploadedFile): array
    {
        $directory = public_path('images');

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $baseName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName = Str::slug($baseName);
        $fileName = now()->format('YmdHis') . '-' . Str::random(8) . ($safeName ? '-' . $safeName : '');
        $extension = strtolower($uploadedFile->getClientOriginalExtension() ?: $uploadedFile->extension() ?: 'jpg');
        $storedFileName = $fileName . '.' . $extension;

        $uploadedFile->move($directory, $storedFileName);

        return [
            'file_name' => $storedFileName,
            'file_path' => 'images/' . $storedFileName,
        ];
    }

    private function deleteImageFile(?string $filePath): void
    {
        if (! $filePath) {
            return;
        }

        $absolutePath = public_path($filePath);

        if (File::exists($absolutePath)) {
            File::delete($absolutePath);
        }
    }
}
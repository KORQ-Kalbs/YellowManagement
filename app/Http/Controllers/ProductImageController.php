<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductImageController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $imagesQuery = ProductImage::query()->with('product:id,nama_produk')->latest();
        $products = Product::select('id', 'nama_produk')->orderBy('nama_produk')->get();

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

        return view('admin.img-product.index-img-product', compact('images', 'stats', 'search', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'product_id' => [
                'nullable',
                'exists:products,id',
                Rule::unique('product_images', 'product_id')->whereNotNull('product_id'),
            ],
            'image' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],
        ]);

        $uploadedFile = $request->file('image');
        $storedImage = $this->storeUploadedImage($uploadedFile);

        ProductImage::create([
            'title' => $validated['title'] ?? null,
            'alt_text' => $validated['alt_text'] ?? null,
            'product_id' => $validated['product_id'] ?? null,
            'original_name' => $uploadedFile->getClientOriginalName(),
            'file_name' => $storedImage['file_name'],
            'file_path' => $storedImage['file_path'],
            'mime_type' => $uploadedFile->getClientMimeType(),
            'size' => $uploadedFile->getSize(),
        ]);

        if (! empty($validated['product_id'])) {
            $this->syncProductImage((int) $validated['product_id'], $storedImage['file_path']);
        }

        return redirect()
            ->route('admin.img-product.index')
            ->with('success', 'Image uploaded successfully');
    }

    public function update(Request $request, ProductImage $productImage): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'product_id' => [
                'nullable',
                'exists:products,id',
                Rule::unique('product_images', 'product_id')
                    ->ignore($productImage->id)
                    ->whereNotNull('product_id'),
            ],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],
        ]);

        $originalProductId = $productImage->product_id;

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
            'product_id' => $validated['product_id'] ?? null,
        ]);

        if (! empty($originalProductId) && (int) $originalProductId !== (int) ($validated['product_id'] ?? 0)) {
            $this->clearProductImage((int) $originalProductId, $productImage->file_path);
        }

        if (! empty($validated['product_id'])) {
            $this->syncProductImage((int) $validated['product_id'], $productImage->file_path);
        }

        return redirect()
            ->route('admin.img-product.index')
            ->with('success', 'Image updated successfully');
    }

    public function destroy(ProductImage $productImage): RedirectResponse
    {
        if ($productImage->product_id) {
            $this->clearProductImage((int) $productImage->product_id, $productImage->file_path);
        }

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

    private function syncProductImage(int $productId, string $filePath): void
    {
        Product::whereKey($productId)->update([
            'gambar_produk' => $filePath,
        ]);
    }

    private function clearProductImage(int $productId, string $filePath): void
    {
        Product::whereKey($productId)
            ->where('gambar_produk', $filePath)
            ->update([
                'gambar_produk' => null,
            ]);
    }
}
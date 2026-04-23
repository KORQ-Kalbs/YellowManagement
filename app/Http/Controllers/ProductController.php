<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        // Optimize: Select only needed columns
        $products = Product::select('id', 'nama_produk', 'kategori_id', 'harga', 'stok', 'status', 'created_at')
            ->with(['kategori:id,nama_kategori', 'allVariants'])
            ->latest()
            ->paginate(15);
        
        // Use cached categories
        $kategoris = cache()->remember('kategoris_all', 3600, function () {
            return Kategori::select('id', 'nama_kategori')->orderBy('nama_kategori')->get();
        });

        return view('admin.produk.index', compact('products', 'kategoris'));
    }

    /**
     * Tampilkan form untuk membuat produk baru.
     */
    public function create(): View
    {
        // Use cached categories
        $kategoris = cache()->remember('kategoris_all', 3600, function () {
            return Kategori::select('id', 'nama_kategori')->orderBy('nama_kategori')->get();
        });
        return view('products.create', compact('kategoris'));
    }

    /**
     * Simpan produk baru ke database.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();

            if ($request->hasFile('gambar')) {
                $validated['gambar_produk'] = $this->storeProductImage($request->file('gambar'));
            }

            unset($validated['gambar']);

            $product = Product::create($validated);

            // Sync variants
            $this->syncVariants($product, $request->input('variants', []));

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menambahkan produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Tampilkan detail produk.
     */
    public function show(Product $product): View
    {
        return view('products.view', compact('product'));
    }

    /**
     * Tampilkan form untuk mengedit produk.
     */
    public function edit(Product $product): View
    {
        // Use cached categories
        $kategoris = cache()->remember('kategoris_all', 3600, function () {
            return Kategori::select('id', 'nama_kategori')->orderBy('nama_kategori')->get();
        });
        return view('products.edit', compact('product', 'kategoris'));
    }

    /**
     * Update produk di database.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        try {
            $validated = $request->validated();

            if ($request->hasFile('gambar')) {
                $this->deleteProductImage($product->gambar_produk);
                $validated['gambar_produk'] = $this->storeProductImage($request->file('gambar'));
            }

            unset($validated['gambar']);

            $product->update($validated);

            // Sync variants
            $this->syncVariants($product, $request->input('variants', []));

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produk berhasil diperbarui');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal memperbarui produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hapus produk dari database.
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            $this->deleteProductImage($product->gambar_produk);
            $product->delete();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    /**
     * Sync product variants: create new, update existing, delete removed.
     */
    private function syncVariants(Product $product, array $variantsData): void
    {
        if (empty($variantsData)) {
            // No variants submitted - delete all existing
            $product->allVariants()->delete();
            return;
        }

        $submittedIds = [];
        $urutan = 0;

        foreach ($variantsData as $vData) {
            $urutan++;
            $payload = [
                'nama_variant'   => $vData['nama_variant'],
                'kode_variant'   => $vData['kode_variant'],
                'harga_tambahan' => $vData['harga_tambahan'] ?? 0,
                'is_active'      => isset($vData['is_active']) ? true : false,
                'urutan'         => $urutan,
            ];

            if (!empty($vData['id'])) {
                // Update existing variant
                $variant = ProductVariant::where('id', $vData['id'])
                    ->where('product_id', $product->id)
                    ->first();
                if ($variant) {
                    $variant->update($payload);
                    $submittedIds[] = $variant->id;
                }
            } else {
                // Create new variant
                $variant = $product->allVariants()->create($payload);
                $submittedIds[] = $variant->id;
            }
        }

        // Delete variants that were removed from the form
        ProductVariant::where('product_id', $product->id)
            ->whereNotIn('id', $submittedIds)
            ->delete();
    }

    private function storeProductImage($uploadedFile): string
    {
        $directory = public_path('images/products');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $baseName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName = Str::slug($baseName);
        $extension = strtolower($uploadedFile->getClientOriginalExtension() ?: 'jpg');
        $fileName = now()->format('YmdHis') . '-' . Str::random(8) . ($safeName ? '-' . $safeName : '') . '.' . $extension;

        $uploadedFile->move($directory, $fileName);

        return 'images/products/' . $fileName;
    }

    private function deleteProductImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        $absolutePath = public_path($path);

        if (File::exists($absolutePath)) {
            File::delete($absolutePath);
        }
    }
}

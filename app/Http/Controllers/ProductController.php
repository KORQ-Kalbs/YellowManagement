<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        // Optimize: Select only needed columns
        $products = Product::select('id', 'nama_produk', 'kategori_id', 'harga', 'stok', 'status', 'created_at')
            ->with('kategori:id,nama_kategori')
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
            Product::create($request->validated());

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
            $product->update($request->validated());

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
            $product->delete();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Services\CacheService;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        // Optimize: Use cache for categories (rarely change)
        $kategoris = CacheService::getKategorisWithCount();
        
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        Kategori::create($validated);

        // Clear category cache
        CacheService::clearKategoriCache();

        return redirect()->route('admin.kategoris.index')->with('success', 'Category created successfully');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori->update($validated);

        // Clear category cache
        CacheService::clearKategoriCache();

        return redirect()->route('admin.kategoris.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        // Clear category cache
        CacheService::clearKategoriCache();

        return redirect()->route('admin.kategoris.index')->with('success', 'Category deleted successfully');
    }
}

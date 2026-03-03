<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransaksiRequest;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Pembayaran;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Tampilkan daftar transaksi.
     */
    public function index(): View
    {
        // Optimize: Select only needed columns to reduce memory
        $query = Transaksi::select('id', 'no_invoice', 'user_id', 'tanggal_transaksi', 'total_harga', 'status')
            ->with([
                'details:id,transaksi_id,product_id,jumlah,subtotal',
                'details.product:id,nama_produk',
                'user:id,name',
                'pembayaran:id,transaksi_id,metode_pembayaran,jumlah_pembayaran'
            ])
            ->latest('tanggal_transaksi');

        // Check if user is admin or kasir
        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        $transaksis = $query->paginate(20);
        
        $view = auth()->user()->role === 'admin' ? 'admin.transaksi.index' : 'kasir.transaksi.index';
        return view($view, compact('transaksis'));
    }

    /**
     * Simpan transaksi baru ke database (MULTI-ITEM).
     */
    public function store(StoreTransaksiRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            
            // Calculate total harga dari semua items
            $totalHarga = 0;
            $itemsData = [];
            
            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Check stock availability
                if ($product->stok < $item['jumlah']) {
                    DB::rollback();
                    return back()
                        ->with('error', "Stok {$product->nama_produk} tidak mencukupi. Tersedia: {$product->stok}")
                        ->withInput();
                }
                
                $subtotal = $product->harga * $item['jumlah'];
                $totalHarga += $subtotal;
                
                $itemsData[] = [
                    'product' => $product,
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $subtotal
                ];
            }

            // Validasi jumlah bayar
            $kembalian = $validated['jumlah_bayar'] - $totalHarga;
            
            if ($validated['jumlah_bayar'] < $totalHarga) {
                DB::rollback();
                return back()
                    ->with('error', 'Jumlah bayar kurang dari total harga')
                    ->withInput();
            }

            // Create Transaksi
            $transaksi = Transaksi::create([
                'user_id' => auth()->id(),
                'total_harga' => $totalHarga,
                'status' => 'completed', // Changed from 'selesai' to match enum
                'tanggal_transaksi' => now(),
            ]);

            // Create DetailTransaksi & Update Stock
            foreach ($itemsData as $itemData) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'product_id' => $itemData['product']->id,
                    'jumlah' => $itemData['jumlah'],
                    'subtotal' => $itemData['subtotal'],
                ]);

                // Kurangi stok
                $itemData['product']->decrement('stok', $itemData['jumlah']);
            }

            // Create Pembayaran
            Pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'jumlah_pembayaran' => $validated['jumlah_bayar'],
                'tanggal_pembayaran' => now(),
            ]);

            DB::commit();

            // Store transaction ID in session to show receipt popup
            session(['show_receipt' => $transaksi->id]);

            // Redirect based on user role
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.pos');
            }
            
            return redirect()->route('kasir.pos');

        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->with('error', 'Gagal memproses transaksi: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Ubah status transaksi menjadi selesai.
     */
    public function selesai($id): RedirectResponse
    {
        try {
            $transaksi = Transaksi::findOrFail($id);

            // Check if already has payment
            if (!$transaksi->pembayaran) {
                return back()->with('error', 'Transaksi belum dibayar');
            }

            $transaksi->update([
                'status' => 'completed'
            ]);

            return redirect()
                ->back()
                ->with('success', 'Transaksi berhasil diselesaikan');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menyelesaikan transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Batalkan transaksi.
     */
    public function batalkan($id): RedirectResponse
    {
        DB::beginTransaction();
        
        try {
            $transaksi = Transaksi::with('details.product')->findOrFail($id);

            // Kembalikan stok
            foreach ($transaksi->details as $detail) {
                $detail->product->increment('stok', $detail->jumlah);
            }

            $transaksi->update([
                'status' => 'cancelled'
            ]);

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Transaksi berhasil dibatalkan dan stok dikembalikan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail transaksi
     */
    public function show($id): View
    {
        $transaksi = Transaksi::with(['details.product', 'user', 'pembayaran'])
            ->findOrFail($id);

        // Check if user is admin or kasir viewing their own transaction
        if (auth()->user()->role !== 'admin' && $transaksi->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this transaction');
        }

        // Return appropriate view based on role
        if (auth()->user()->role === 'admin') {
            return view('admin.transaksi.show', compact('transaksi'));
        } else {
            return view('kasir.transaksi.show', compact('transaksi'));
        }
    }
}
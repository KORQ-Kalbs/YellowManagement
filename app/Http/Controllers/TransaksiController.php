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
        $transaksis = Transaksi::with(['details.product', 'user', 'pembayaran'])
            ->latest('tanggal_transaksi')
            ->paginate(15);

        return view('kasir.transaksi.index', compact('transaksis'));
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
                'status' => 'selesai', // Langsung selesai karena sudah dibayar
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
            $kembalian = $validated['jumlah_bayar'] - $totalHarga;
            
            Pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'jumlah_bayar' => $validated['jumlah_bayar'],
                'kembalian' => $kembalian,
            ]);

            DB::commit();

            return redirect()
                ->route('kasir.pos')
                ->with('success', "Transaksi berhasil! Invoice: {$transaksi->no_invoice}. Kembalian: Rp " . number_format($kembalian, 0, ',', '.'));

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
                'status' => 'selesai'
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
                'status' => 'dibatalkan'
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

        return view('kasir.transaksi.show', compact('transaksi'));
    }
}
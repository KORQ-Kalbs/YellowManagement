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
        $query = Transaksi::select('id', 'no_invoice', 'user_id', 'tanggal_transaksi', 'total_harga', 'status', 'discount_event_id')
            ->with([
                'details:id,transaksi_id,product_id,jumlah,subtotal',
                'details.product:id,nama_produk',
                'user:id,name',
                'pembayaran:id,transaksi_id,metode_pembayaran,jumlah_pembayaran',
                'discountEvent:id,name,discount_percentage',
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

                // Base price + variant price modifier
                $hargaSatuan = floatval($product->harga);
                $variantId   = $item['variant_id'] ?? null;

                if ($variantId) {
                    $variant = \App\Models\ProductVariant::find($variantId);
                    if ($variant && $variant->product_id == $product->id) {
                        $hargaSatuan += floatval($variant->harga_tambahan);
                    } else {
                        $variantId = null; // invalid variant, ignore
                    }
                }

                $subtotal    = $hargaSatuan * $item['jumlah'];
                $totalHarga += $subtotal;
                
                $itemsData[] = [
                    'product'    => $product,
                    'variant_id' => $variantId,
                    'jumlah'     => $item['jumlah'],
                    'subtotal'   => $subtotal,
                    'catatan'    => $item['catatan'] ?? null,
                ];
            }

            // Apply discount if provided
            if (!empty($validated['discount_event_id'])) {
                $discountEvent = \App\Models\DiscountEvent::active()->find($validated['discount_event_id']);
                if ($discountEvent) {
                    $discountAmount = ($totalHarga * $discountEvent->discount_percentage) / 100;
                    $totalHarga -= $discountAmount;
                }
            }

            // Validasi jumlah bayar hanya untuk cash
            if ($validated['metode_pembayaran'] === 'cash') {
                $jumlahBayarInput = $validated['jumlah_bayar'] ?? 0;
                if ($jumlahBayarInput < $totalHarga) {
                    DB::rollback();
                    return back()
                        ->with('error', 'Jumlah bayar kurang dari total harga')
                        ->withInput();
                }
            } else {
                $validated['jumlah_bayar'] = $totalHarga; // Automatically set full payment for non-cash methods
            }

            // Create Transaksi
            $transaksi = Transaksi::create([
                'user_id' => auth()->id(),
                'discount_event_id' => $validated['discount_event_id'] ?? null,
                'total_harga' => $totalHarga,
                'status' => 'pending', 
                'tanggal_transaksi' => now(),
            ]);

            // Create DetailTransaksi & Update Stock
            foreach ($itemsData as $itemData) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'product_id'   => $itemData['product']->id,
                    'variant_id'   => $itemData['variant_id'],
                    'jumlah'       => $itemData['jumlah'],
                    'subtotal'     => $itemData['subtotal'],
                    'catatan'      => $itemData['catatan'],
                ]);

                // Kurangi stok
                $itemData['product']->decrement('stok', $itemData['jumlah']);
            }

            // Create Pembayaran (Default to input for cash, full price otherwise)
            Pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'jumlah_pembayaran' => $validated['metode_pembayaran'] === 'cash' ? $validated['jumlah_bayar'] : $transaksi->total_harga,
                'tanggal_pembayaran' => now(),
            ]);

            DB::commit();

            // Store transaction ID in session to show pending popup
            session(['pending_transaksi' => $transaksi->id]);

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
    public function selesai(Request $request, $id): RedirectResponse
    {
        try {
            $transaksi = Transaksi::findOrFail($id);

            // Check if already has payment
            if (!$transaksi->pembayaran) {
                return back()->with('error', 'Transaksi belum dibayar');
            }
            
            // Allow dynamic cash amount tracking if passed from POS popup
            if ($request->has('jumlah_bayar_diterima') && $transaksi->pembayaran->metode_pembayaran == 'cash') {
                 $transaksi->pembayaran->update([
                      'jumlah_pembayaran' => $request->jumlah_bayar_diterima
                 ]);
            }

            $transaksi->update([
                'status' => 'completed'
            ]);
            
            session()->forget('pending_transaksi');
            session(['show_receipt' => $transaksi->id]);

            return redirect()
                ->back()
                ->with('success', 'Transaksi berhasil diselesaikan');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menyelesaikan transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Suspend (park) transaksi - keep as pending, just dismiss the modal.
     */
    public function suspend($id): RedirectResponse
    {
        try {
            $transaksi = Transaksi::findOrFail($id);

            // Transaction stays 'pending' — just clear the popup session
            session()->forget('pending_transaksi');

            $route = auth()->user()->role === 'admin' ? 'admin.pos' : 'kasir.pos';

            return redirect()
                ->route($route)
                ->with('success', 'Transaksi ditunda. Dapat dilanjutkan dari riwayat transaksi.');
        } catch (\Exception $e) {
            $route = auth()->user()->role === 'admin' ? 'admin.pos' : 'kasir.pos';
            return redirect()->route($route)->with('error', 'Gagal menunda transaksi: ' . $e->getMessage());
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
            session()->forget('pending_transaksi');

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
        $transaksi = Transaksi::with(['details.product', 'details.variant', 'user', 'pembayaran', 'discountEvent'])
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
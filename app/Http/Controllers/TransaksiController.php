<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransaksiRequest;
use App\Models\Transaksi;
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
        $transaksis = Transaksi::with('product', 'user')
            ->latest()
            ->paginate(15);

        return view('kasir-view.transaction.index', compact('transaksis'));
    }

    /**
     * Simpan transaksi baru ke database.
     */
    public function store(StoreTransaksiRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $validated['user_id'] = auth()->id();
            $validated['status'] = 'diproses';
            $validated['tanggal_transaksi'] = now();

            Transaksi::create($validated);

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Transaksi berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->with('error', 'Gagal menambahkan transaksi: ' . $e->getMessage())
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
        try {
            $transaksi = Transaksi::findOrFail($id);

            $transaksi->update([
                'status' => 'dibatalkan'
            ]);

            return redirect()
                ->back()
                ->with('success', 'Transaksi berhasil dibatalkan');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePembayaranRequest;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class PembayaranController extends Controller
{
    /**
     * Simpan pembayaran transaksi.
     */
    public function store(StorePembayaranRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();

            $transaksi = Transaksi::findOrFail($validated['id_transaksi']);

            // Validasi jumlah bayar
            if ($validated['jumlah_bayar'] < $transaksi->total_harga) {
                DB::rollback();
                return back()
                    ->with('error', 'Jumlah pembayaran kurang dari total harga')
                    ->withInput();
            }

            $kembalian = $validated['jumlah_bayar'] - $transaksi->total_harga;

            Pembayaran::create([
                'id_transaksi' => $transaksi->id,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'jumlah_bayar' => $validated['jumlah_bayar'],
                'kembalian' => $kembalian
            ]);

            $transaksi->update([
                'status' => 'selesai'
            ]);

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Pembayaran berhasil diproses');

        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage())
                ->withInput();
        }
    }
}

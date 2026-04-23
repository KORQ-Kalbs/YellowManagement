<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Contracts\View\View as ViewContract;
use Maatwebsite\Excel\Concerns\FromView;

class TransaksiReceiptExport implements FromView
{
    public function __construct(protected Transaksi $transaksi)
    {
    }

    public function view(): ViewContract
    {
        return view('exports.transaksi-receipt', [
            'transaksi' => $this->transaksi->loadMissing([
                'details.product.kategori',
                'details.variant',
                'user',
                'pembayaran',
                'discountEvent',
            ]),
        ]);
    }
}
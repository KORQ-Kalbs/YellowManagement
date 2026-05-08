<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran - {{ $transaksi->no_invoice }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        .receipt {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 16px;
        }

        .header h1 {
            font-size: 22px;
            margin: 0 0 4px 0;
            text-transform: uppercase;
        }

        .header p {
            margin: 0;
            font-size: 10px;
            color: #6b7280;
        }

        .divider {
            border-top: 1px dashed #d1d5db;
            margin: 14px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .meta td {
            padding: 2px 0;
            vertical-align: top;
        }

        .meta td:last-child {
            text-align: right;
        }

        .items th,
        .items td {
            border-bottom: 1px solid #e5e7eb;
            padding: 6px 4px;
            text-align: left;
        }

        .items th {
            font-size: 10px;
            text-transform: uppercase;
            color: #6b7280;
        }

        .item-line {
            margin: 2px 0 0;
            font-family: monospace;
            white-space: pre;
        }

        .totals td {
            padding: 4px 0;
        }

        .totals td:last-child {
            text-align: right;
        }

        .grand-total {
            font-size: 14px;
            font-weight: bold;
            border-top: 1px solid #d1d5db;
            padding-top: 6px;
        }

        .muted {
            color: #6b7280;
        }

        .right {
            text-align: right;
        }
    </style>
</head>
<body>
    @php
        $subtotalBruto = $transaksi->details->sum('subtotal');
        $discountPct = $transaksi->discountEvent ? floatval($transaksi->discountEvent->discount_percentage) : 0;
        $discountAmount = $subtotalBruto - floatval($transaksi->total_harga);
        $paymentAmount = $transaksi->pembayaran ? floatval($transaksi->pembayaran->jumlah_pembayaran) : 0;
        $changeAmount = max(0, $paymentAmount - floatval($transaksi->total_harga));
    @endphp

    <div class="receipt">
        <div class="header">
            <h1>Yellow Drink</h1>
            <p>Jl. Sindang Barang Pengkolan No.132, RT.04/RW.06, Sindangbarang, Kec. Bogor Bar., Kota Bogor, Jawa Barat 16117</p>
            <p>Telp: +62 816-634-757</p>
        </div>

        <div class="divider"></div>

        <table class="meta">
            <tr>
                <td>No. Invoice</td>
                <td>{{ $transaksi->no_invoice }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>{{ $transaksi->tanggal_transaksi->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td>Kasir</td>
                <td>{{ $transaksi->user->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Metode</td>
                <td>{{ strtoupper($transaksi->pembayaran->metode_pembayaran ?? 'CASH') }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <table class="items">
            <thead>
                <tr>
                    <th>Produk</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi->details as $detail)
                    <tr>
                        <td>
                            <div>{{ $detail->product->nama_produk }}</div>
                            <div class="item-line">{{ str_pad($detail->jumlah . ' x', 12) }}{{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                            @if($detail->variant)
                                <div class="muted">{{ $detail->variant->kode_variant }}</div>
                            @endif
                            @if($detail->catatan)
                                <div class="muted">{{ $detail->catatan }}</div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="divider"></div>

        <table class="totals">
            <tr>
                <td>Subtotal</td>
                <td>Rp {{ number_format($subtotalBruto, 0, ',', '.') }}</td>
            </tr>
            @if($discountPct > 0)
                <tr>
                    <td>Diskon {{ number_format($discountPct, 0) }}%</td>
                    <td>- Rp {{ number_format($discountAmount, 0, ',', '.') }}</td>
                </tr>
            @endif
            <tr class="grand-total">
                <td>Total</td>
                <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
            </tr>
            @if($transaksi->pembayaran)
                <tr>
                    <td>Bayar</td>
                    <td>Rp {{ number_format($paymentAmount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Kembali</td>
                    <td>Rp {{ number_format($changeAmount, 0, ',', '.') }}</td>
                </tr>
            @endif
        </table>

        <div class="divider"></div>

        <p class="right muted">Terima kasih atas kunjungan Anda.</p>
    </div>
</body>
</html>
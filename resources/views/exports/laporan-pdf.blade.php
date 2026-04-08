<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi - {{ $selectedDate->format('d/m/Y') }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1f2937; background: #fff; }

        /* Header */
        .header { text-align: center; padding: 20px 0 12px; border-bottom: 2px solid #1d4ed8; margin-bottom: 16px; }
        .header h1 { font-size: 20px; font-weight: 700; color: #1d4ed8; letter-spacing: 1px; }
        .header p { font-size: 10px; color: #6b7280; margin-top: 2px; }

        /* Meta info */
        .meta { display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 10px; color: #374151; }
        .meta span { display: block; }
        .meta strong { color: #111827; }

        /* Summary boxes */
        .summary { display: flex; gap: 10px; margin-bottom: 18px; }
        .summary-box { flex: 1; border: 1px solid #e5e7eb; border-radius: 6px; padding: 10px 12px; background: #f9fafb; }
        .summary-box .label { font-size: 9px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }
        .summary-box .value { font-size: 13px; font-weight: 700; color: #111827; margin-top: 2px; }
        .summary-box.green .value { color: #16a34a; }
        .summary-box.red .value { color: #dc2626; }
        .summary-box.blue .value { color: #2563eb; }

        /* Table */
        table { width: 100%; border-collapse: collapse; font-size: 9.5px; }
        thead tr { background: #1d4ed8; color: #fff; }
        thead th { padding: 7px 8px; text-align: left; font-weight: 600; font-size: 9px; text-transform: uppercase; letter-spacing: 0.4px; }
        tbody tr:nth-child(even) { background: #f3f4f6; }
        tbody tr:nth-child(odd) { background: #fff; }
        tbody td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .discount-row { color: #dc2626; font-weight: 600; }
        .total-row td { font-weight: 700; background: #eff6ff !important; border-top: 2px solid #1d4ed8; font-size: 10px; }

        /* Footer */
        .footer { margin-top: 20px; border-top: 1px solid #e5e7eb; padding-top: 10px; display: flex; justify-content: space-between; font-size: 9px; color: #9ca3af; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>LAPORAN TRANSAKSI</h1>
        <p>Yellow Drink &mdash; Jl. Kasir Yellow No. 1 &mdash; Telp: 0812-3456-7890</p>
    </div>

    <!-- Meta -->
    <div class="meta">
        <div>
            <span><strong>Periode:</strong>
                @if($period === 'day') Harian &mdash; {{ $selectedDate->format('d F Y') }}
                @elseif($period === 'week') Mingguan &mdash; {{ $selectedDate->copy()->startOfWeek()->format('d M') }} s/d {{ $selectedDate->copy()->endOfWeek()->format('d M Y') }}
                @else Bulanan &mdash; {{ $selectedDate->format('F Y') }}
                @endif
            </span>
            @if($isKasir)
                <span><strong>Kasir:</strong> {{ auth()->user()->name }}</span>
            @endif
        </div>
        <div style="text-align:right;">
            <span><strong>Dicetak:</strong> {{ now()->format('d/m/Y H:i') }}</span>
            <span><strong>Total Transaksi:</strong> {{ $transaksis->count() }}</span>
        </div>
    </div>

    <!-- Summary -->
    @php
        $grandSubtotal  = $transaksis->sum(fn($t) => $t->details->sum('subtotal'));
        $grandDiscount  = $transaksis->sum(fn($t) => $t->details->sum('subtotal') - floatval($t->total_harga));
        $grandTotal     = $transaksis->sum(fn($t) => floatval($t->total_harga));
    @endphp
    <div class="summary">
        <div class="summary-box">
            <div class="label">Subtotal Asli</div>
            <div class="value">Rp {{ number_format($grandSubtotal, 0, ',', '.') }}</div>
        </div>
        <div class="summary-box red">
            <div class="label">Total Potongan</div>
            <div class="value">- Rp {{ number_format($grandDiscount, 0, ',', '.') }}</div>
        </div>
        <div class="summary-box green">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($grandTotal, 0, ',', '.') }}</div>
        </div>
        <div class="summary-box blue">
            <div class="label">Jml Transaksi</div>
            <div class="value">{{ $transaksis->count() }}</div>
        </div>
    </div>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Metode</th>
                <th>Event Diskon</th>
                <th class="text-right">Subtotal Asli</th>
                <th class="text-right">Potongan</th>
                <th class="text-right">Total Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $i => $t)
                @php
                    $subtotalAsli = $t->details->sum('subtotal');
                    $potongan     = $subtotalAsli - floatval($t->total_harga);
                    $discountPct  = $t->discountEvent ? floatval($t->discountEvent->discount_percentage) : 0;
                @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $t->no_invoice }}</td>
                    <td>{{ $t->tanggal_transaksi->format('d/m/Y H:i') }}</td>
                    <td>{{ $t->user->name ?? '-' }}</td>
                    <td class="text-center">{{ strtoupper($t->pembayaran->metode_pembayaran ?? '-') }}</td>
                    <td>
                        @if($t->discountEvent)
                            {{ $t->discountEvent->name }} ({{ number_format($discountPct, 0) }}%)
                        @else
                            <span style="color:#9ca3af;">-</span>
                        @endif
                    </td>
                    <td class="text-right">{{ number_format($subtotalAsli, 0, ',', '.') }}</td>
                    <td class="text-right discount-row">
                        @if($potongan > 0)- {{ number_format($potongan, 0, ',', '.') }}@else -@endif
                    </td>
                    <td class="text-right" style="font-weight:600;">{{ number_format($t->total_harga, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding:20px; color:#9ca3af;">
                        Tidak ada data transaksi pada periode ini.
                    </td>
                </tr>
            @endforelse

            @if($transaksis->count() > 0)
            <tr class="total-row">
                <td colspan="6" class="text-right">TOTAL</td>
                <td class="text-right">Rp {{ number_format($grandSubtotal, 0, ',', '.') }}</td>
                <td class="text-right discount-row">- Rp {{ number_format($grandDiscount, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <span>Laporan ini digenerate otomatis oleh sistem kasir Yellow Drink.</span>
        <span>Halaman 1</span>
    </div>

</body>
</html>
